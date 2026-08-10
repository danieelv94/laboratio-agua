<?php

namespace Tests\Feature;

use App\Models\StudyRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudyRequestSchedulingTest extends TestCase
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
            'status' => 'pago_verificado',
        ], $overrides));
    }

    public function test_cannot_schedule_two_visits_on_the_same_day()
    {
        $user = User::factory()->create();

        // Create first request already scheduled for a day
        $req1 = $this->createBaseRequest([
            'fecha_muestreo' => '2026-08-10 10:00:00',
            'status' => 'muestreo_programado',
        ]);

        // Create second request waiting to be scheduled
        $req2 = $this->createBaseRequest();

        // Attempt to schedule second request on the same day (different time)
        $response = $this->actingAs($user)
            ->from(route('dashboard.solicitud', $req2->id))
            ->post(route('dashboard.solicitud.actualizar', $req2->id), [
                'status' => 'muestreo_programado',
                'fecha_muestreo' => '2026-08-10 14:00:00',
            ]);

        $response->assertRedirect(route('dashboard.solicitud', $req2->id));
        $response->assertSessionHasErrors('fecha_muestreo');

        // Confirm it was NOT scheduled
        $this->assertEquals('pago_verificado', $req2->fresh()->status);
    }

    public function test_can_schedule_visits_on_different_days()
    {
        $user = User::factory()->create();

        $req1 = $this->createBaseRequest([
            'fecha_muestreo' => '2026-08-10 10:00:00',
            'status' => 'muestreo_programado',
        ]);

        $req2 = $this->createBaseRequest();

        // Schedule second request on a different day
        $response = $this->actingAs($user)
            ->from(route('dashboard.solicitud', $req2->id))
            ->post(route('dashboard.solicitud.actualizar', $req2->id), [
                'status' => 'muestreo_programado',
                'fecha_muestreo' => '2026-08-11 10:00:00',
            ]);

        $response->assertRedirect(route('dashboard.solicitud', $req2->id));
        $response->assertSessionHasNoErrors();

        // Confirm it was scheduled successfully
        $this->assertEquals('muestreo_programado', $req2->fresh()->status);
        $this->assertEquals('2026-08-11 10:00:00', $req2->fresh()->fecha_muestreo->format('Y-m-d H:i:s'));
    }

    public function test_dashboard_show_view_receives_occupied_dates()
    {
        $user = User::factory()->create();

        // Create a couple of scheduled requests
        $this->createBaseRequest([
            'fecha_muestreo' => '2026-08-10 10:00:00',
            'status' => 'muestreo_programado',
        ]);
        $this->createBaseRequest([
            'fecha_muestreo' => '2026-08-15 14:00:00',
            'status' => 'muestreo_programado',
        ]);

        // Request being scheduled
        $req = $this->createBaseRequest();

        $response = $this->actingAs($user)
            ->get(route('dashboard.solicitud', $req->id));

        $response->assertStatus(200);
        $response->assertViewHas('occupiedDates');
        
        $occupiedDates = $response->viewData('occupiedDates');
        $this->assertCount(2, $occupiedDates);
        $this->assertContains('2026-08-10', $occupiedDates);
        $this->assertContains('2026-08-15', $occupiedDates);
    }

    public function test_rejection_requires_comment()
    {
        $user = User::factory()->create();
        $req = $this->createBaseRequest([
            'status' => 'pendiente'
        ]);

        // Attempt to reject without comment
        $response = $this->actingAs($user)
            ->from(route('dashboard.solicitud', $req->id))
            ->post(route('dashboard.solicitud.actualizar', $req->id), [
                'status' => 'rechazado',
                'comentarios_staff' => '',
            ]);

        $response->assertRedirect(route('dashboard.solicitud', $req->id));
        $response->assertSessionHasErrors('comentarios_staff');
        $this->assertEquals('pendiente', $req->fresh()->status);
    }

    public function test_rejection_succeeds_with_comment()
    {
        $user = User::factory()->create();
        $req = $this->createBaseRequest([
            'status' => 'pendiente'
        ]);

        // Attempt to reject with comment
        $response = $this->actingAs($user)
            ->from(route('dashboard.solicitud', $req->id))
            ->post(route('dashboard.solicitud.actualizar', $req->id), [
                'status' => 'rechazado',
                'comentarios_staff' => 'El recibo de pago no coincide con el importe cotizado.',
            ]);

        $response->assertRedirect(route('dashboard.solicitud', $req->id));
        $response->assertSessionHasNoErrors();
        $this->assertEquals('rechazado', $req->fresh()->status);
        $this->assertEquals('El recibo de pago no coincide con el importe cotizado.', $req->fresh()->comentarios_staff);
    }

    public function test_public_tracking_shows_pending_voucher_message()
    {
        $req = $this->createBaseRequest([
            'status' => 'pendiente',
            'comprobante_pago' => 'vouchers/test.pdf'
        ]);

        $response = $this->get(route('solicitud.ver', $req->referencia_bancaria));

        $response->assertStatus(200);
        $response->assertSee('Comprobante de Pago en Revisión');
        $response->assertSee('Su comprobante ha sido recibido y está en proceso de validación. Una vez aprobado, en esta misma plataforma se mostrará la fecha de programación de su muestreo.');
    }

    public function test_public_tracking_shows_validated_payment_message()
    {
        $req = $this->createBaseRequest([
            'status' => 'pago_verificado',
            'comprobante_pago' => 'vouchers/test.pdf'
        ]);

        $response = $this->get(route('solicitud.ver', $req->referencia_bancaria));

        $response->assertStatus(200);
        $response->assertSee('Pago Verificado');
        $response->assertSee('El pago de su depósito ha sido validado con éxito. En esta misma plataforma se mostrará la fecha de programación de la visita para la toma de muestras.');
    }
}
