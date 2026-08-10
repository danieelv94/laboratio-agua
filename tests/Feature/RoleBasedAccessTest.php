<?php

namespace Tests\Feature;

use App\Models\StudyRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RoleBasedAccessTest extends TestCase
{
    use RefreshDatabase;

    private function createBaseRequest(array $overrides = []): StudyRequest
    {
        return StudyRequest::create(array_merge([
            'solicitante' => 'Municipio Test',
            'representante' => 'Representante Test',
            'puesto_departamento' => 'Puesto Test',
            'direccion' => 'Dirección Test',
            'email' => 'test@correo.com',
            'puntos_muestreo' => ['POZO'],
            'tipos_muestra' => ['AGUA POTABLE'],
            'normativas' => ['NOM-127-SSA1-2021'],
            'referencia_bancaria' => 'REF-' . uniqid(),
            'status' => 'pendiente',
        ], $overrides));
    }

    /**
     * Test that guests and non-admin users cannot access the registration page.
     */
    public function test_registration_is_restricted_to_admin()
    {
        // Guests should be redirected to login
        $this->get(route('register'))
            ->assertRedirect(route('login'));

        // Lab users should get 403 Forbidden
        $lab = User::factory()->create(['role' => 'laboratorio']);
        $this->actingAs($lab)
            ->get(route('register'))
            ->assertStatus(403);

        // Billing users should get 403 Forbidden
        $billing = User::factory()->create(['role' => 'administracion']);
        $this->actingAs($billing)
            ->get(route('register'))
            ->assertStatus(403);

        // Admin should get 200 OK
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)
            ->get(route('register'))
            ->assertStatus(200);
    }

    /**
     * Test that admin can successfully register new users with different roles.
     */
    public function test_admin_can_register_new_users_with_roles()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)
            ->post(route('register'), [
                'name' => 'New Billing Agent',
                'email' => 'billing@ceaa.gob.mx',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'role' => 'administracion',
            ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'email' => 'billing@ceaa.gob.mx',
            'role' => 'administracion',
        ]);
        
        // Ensure admin is STILL logged in
        $this->assertAuthenticatedAs($admin);
    }

    /**
     * Test role-based dashboard filtering.
     */
    public function test_role_based_dashboard_filtering()
    {
        // Request with invoice requested (RFC is not null)
        $invoiceReq = $this->createBaseRequest([
            'rfc' => 'XAXX010101000',
            'razon_social' => 'Razon Social Test',
            'referencia_bancaria' => 'REF-INV'
        ]);

        // Request WITHOUT invoice requested (RFC is null)
        $noInvoiceReq = $this->createBaseRequest([
            'rfc' => null,
            'razon_social' => null,
            'referencia_bancaria' => 'REF-NO-INV'
        ]);

        $admin = User::factory()->create(['role' => 'admin']);
        $lab = User::factory()->create(['role' => 'laboratorio']);
        $billing = User::factory()->create(['role' => 'administracion']);

        // Admin sees both
        $responseAdmin = $this->actingAs($admin)->get(route('dashboard'));
        $responseAdmin->assertSee('REF-INV');
        $responseAdmin->assertSee('REF-NO-INV');

        // Lab sees both
        $responseLab = $this->actingAs($lab)->get(route('dashboard'));
        $responseLab->assertSee('REF-INV');
        $responseLab->assertSee('REF-NO-INV');

        // Billing only sees invoice requests
        $responseBilling = $this->actingAs($billing)->get(route('dashboard'));
        $responseBilling->assertSee('REF-INV');
        $responseBilling->assertDontSee('REF-NO-INV');
    }

    /**
     * Test route-level role protection for scheduling/testing actions and invoice uploads.
     */
    public function test_role_based_action_protections()
    {
        $req = $this->createBaseRequest();

        $lab = User::factory()->create(['role' => 'laboratorio']);
        $billing = User::factory()->create(['role' => 'administracion']);

        // Lab user trying to upload an invoice ZIP should get 403
        Storage::fake('public');
        $zip = UploadedFile::fake()->create('factura.zip', 100, 'application/zip');
        
        $this->actingAs($lab)
            ->post(route('dashboard.solicitud.factura', $req->id), [
                'archivo_factura' => $zip,
            ])
            ->assertStatus(403);

        // Billing user trying to update technical status/schedule should get 403
        $this->actingAs($billing)
            ->post(route('dashboard.solicitud.actualizar', $req->id), [
                'status' => 'pago_verificado',
            ])
            ->assertStatus(403);
    }

    /**
     * Test successful invoice upload and public tracking page download link.
     */
    public function test_invoice_upload_and_citizen_download()
    {
        Storage::fake('public');
        
        $req = $this->createBaseRequest([
            'rfc' => 'XAXX010101000',
            'razon_social' => 'Razon Social Test'
        ]);

        $billing = User::factory()->create(['role' => 'administracion']);
        $zip = UploadedFile::fake()->create('factura.zip', 100, 'application/zip');

        // Billing uploads invoice
        $response = $this->actingAs($billing)
            ->post(route('dashboard.solicitud.factura', $req->id), [
                'archivo_factura' => $zip,
            ]);

        $response->assertRedirect(route('dashboard.solicitud', $req->id));
        
        $req->refresh();
        $this->assertNotNull($req->archivo_factura);
        Storage::disk('public')->assertExists($req->archivo_factura);

        // Public page displays download link
        $publicResponse = $this->get(route('solicitud.ver', $req->referencia_bancaria));
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('Factura Emitida');
        $publicResponse->assertSee('Descargar Factura (ZIP)');
        $publicResponse->assertSee(asset('storage/' . $req->archivo_factura));
    }

    /**
     * Test that requesting an invoice validates all billing fields.
     */
    public function test_submitting_request_requiring_invoice_validates_billing_fields()
    {
        $response = $this->post(route('solicitud.guardar'), [
            'solicitante' => 'Municipio Test',
            'representante' => 'Representante Test',
            'puesto_departamento' => 'Puesto Test',
            'direccion' => 'Dirección Muestreo',
            'email' => 'test@correo.com',
            'cantidad_muestras' => 1,
            'puntos_muestreo' => ['POZO'],
            'tipos_muestra' => ['AGUA POTABLE'],
            'normativas' => ['NOM-127-SSA1-2021'],
            'requiere_factura' => 1, // Requires invoice
            // Missing all billing fields
        ]);

        $response->assertSessionHasErrors(['rfc', 'razon_social', 'direccion_fiscal', 'uso_cfdi', 'metodo_pago', 'forma_pago']);
    }

    /**
     * Test that not requiring an invoice nullifies/cleans up any sent billing fields.
     */
    public function test_submitting_request_without_invoice_cleans_billing_fields()
    {
        $response = $this->post(route('solicitud.guardar'), [
            'solicitante' => 'Municipio Test',
            'representante' => 'Representante Test',
            'puesto_departamento' => 'Puesto Test',
            'direccion' => 'Dirección Muestreo',
            'email' => 'test@correo.com',
            'cantidad_muestras' => 1,
            'puntos_muestreo' => ['POZO'],
            'tipos_muestra' => ['AGUA POTABLE'],
            'normativas' => ['NOM-127-SSA1-2021'],
            'requiere_factura' => 0, // DOES NOT require invoice
            
            // Send billing fields anyways (e.g. from browser autocomplete or tampering)
            'rfc' => 'XAXX010101000',
            'razon_social' => 'Razon Social Test',
            'direccion_fiscal' => 'Direccion Fiscal Test',
        ]);

        $response->assertRedirect(); // Should redirect to confirmation/success tracking page
        
        // Assert that the database entry has NULL billing fields
        $this->assertDatabaseHas('study_requests', [
            'solicitante' => 'Municipio Test',
            'rfc' => null,
            'razon_social' => null,
            'direccion_fiscal' => null,
        ]);
    }

    /**
     * Test public upload of payment voucher.
     */
    public function test_citizen_can_upload_payment_voucher()
    {
        Storage::fake('public');
        
        $req = $this->createBaseRequest([
            'status' => 'pendiente',
            'comprobante_pago' => null,
        ]);

        $file = \Illuminate\Http\UploadedFile::fake()->create('comprobante.pdf', 100, 'application/pdf');

        $response = $this->post(route('solicitud.comprobante', $req->referencia_bancaria), [
            'comprobante_pago' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $req->refresh();
        $this->assertNotNull($req->comprobante_pago);
        Storage::disk('public')->assertExists($req->comprobante_pago);
    }

    /**
     * Test public re-upload of payment voucher when rejected.
     */
    public function test_citizen_can_reupload_payment_voucher_when_rejected()
    {
        Storage::fake('public');
        
        $req = $this->createBaseRequest([
            'status' => 'rechazado',
            'comprobante_pago' => 'vouchers/old.pdf',
        ]);

        $file = \Illuminate\Http\UploadedFile::fake()->create('comprobante_nuevo.pdf', 100, 'application/pdf');

        $response = $this->post(route('solicitud.comprobante', $req->referencia_bancaria), [
            'comprobante_pago' => $file,
        ]);

        if ($response->status() !== 302) {
            dd($response->status(), $response->content());
        }
        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $req->refresh();
        $this->assertEquals('pendiente', $req->status); // Must reset to pending!
        $this->assertNotNull($req->comprobante_pago);
        $this->assertNotEquals('vouchers/old.pdf', $req->comprobante_pago);
        Storage::disk('public')->assertExists($req->comprobante_pago);
    }
}
