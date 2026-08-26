<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that guests and non-admins are restricted from user management.
     */
    public function test_guests_and_non_admins_restricted_from_user_management()
    {
        // 1. Guest
        $this->get(route('dashboard.usuarios'))
            ->assertRedirect(route('login'));

        // 2. Lab role (should get 403)
        $lab = User::factory()->create(['role' => 'laboratorio']);
        $this->actingAs($lab)
            ->get(route('dashboard.usuarios'))
            ->assertStatus(403);

        // 3. Billing role (should get 403)
        $billing = User::factory()->create(['role' => 'administracion']);
        $this->actingAs($billing)
            ->get(route('dashboard.usuarios'))
            ->assertStatus(403);
    }

    /**
     * Test that admin can view user listing.
     */
    public function test_admin_can_view_user_listing()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $otherUser = User::factory()->create(['name' => 'John Doe', 'role' => 'laboratorio']);

        $response = $this->actingAs($admin)
            ->get(route('dashboard.usuarios'));

        $response->assertStatus(200);
        $response->assertSee('John Doe');
        $response->assertSee('Laboratorio');
    }

    /**
     * Test that admin can create a new user.
     */
    public function test_admin_can_create_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)
            ->post(route('dashboard.usuarios.guardar'), [
                'name' => 'Jane Smith',
                'email' => 'jane@ceaa.gob.mx',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'role' => 'administracion',
            ]);

        $response->assertRedirect(route('dashboard.usuarios'));
        $this->assertDatabaseHas('users', [
            'email' => 'jane@ceaa.gob.mx',
            'role' => 'administracion',
        ]);

        // Assert log was created
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'user_created',
            'user_id' => $admin->id,
        ]);
    }

    /**
     * Test that admin can edit an existing user.
     */
    public function test_admin_can_edit_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $userToEdit = User::factory()->create(['name' => 'Old Name', 'role' => 'laboratorio']);

        $response = $this->actingAs($admin)
            ->post(route('dashboard.usuarios.actualizar', $userToEdit->id), [
                'name' => 'New Name',
                'email' => $userToEdit->email,
                'role' => 'administracion',
                'password' => null, // don't change password
            ]);

        $response->assertRedirect(route('dashboard.usuarios'));
        
        $userToEdit->refresh();
        $this->assertEquals('New Name', $userToEdit->name);
        $this->assertEquals('administracion', $userToEdit->role);

        // Assert log was created
        $this->assertDatabaseHas('activity_logs', [
            'action' => 'user_updated',
            'user_id' => $admin->id,
        ]);
    }

    /**
     * Test that admin cannot suspend themselves.
     */
    public function test_admin_cannot_suspend_themselves()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)
            ->post(route('dashboard.usuarios.suspender', $admin->id));

        $response->assertSessionHasErrors(['suspension']);
        
        $admin->refresh();
        $this->assertFalse($admin->suspended);
    }

    /**
     * Test that admin can suspend and reactivate other users.
     */
    public function test_admin_can_toggle_suspension_on_others()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $other = User::factory()->create(['role' => 'laboratorio', 'suspended' => false]);

        // 1. Suspend
        $response = $this->actingAs($admin)
            ->post(route('dashboard.usuarios.suspender', $other->id));

        $response->assertRedirect(route('dashboard.usuarios'));
        $other->refresh();
        $this->assertTrue($other->suspended);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'user_suspended',
            'user_id' => $admin->id,
        ]);

        // 2. Reactivate
        $response = $this->actingAs($admin)
            ->post(route('dashboard.usuarios.suspender', $other->id));

        $response->assertRedirect(route('dashboard.usuarios'));
        $other->refresh();
        $this->assertFalse($other->suspended);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'user_reactivated',
            'user_id' => $admin->id,
        ]);
    }

    /**
     * Test that suspended user cannot log in.
     */
    public function test_suspended_user_cannot_log_in()
    {
        $user = User::factory()->create([
            'email' => 'suspended@ceaa.gob.mx',
            'password' => bcrypt('password123'),
            'suspended' => true,
        ]);

        $response = $this->post(route('login'), [
            'email' => 'suspended@ceaa.gob.mx',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    /**
     * Test that logged in user is logged out dynamically when suspended.
     */
    public function test_logged_in_user_logged_out_when_suspended()
    {
        $user = User::factory()->create(['role' => 'laboratorio', 'suspended' => false]);

        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        // Make user suspended in the database
        $user->suspended = true;
        $user->save();

        // Access dashboard (should trigger CheckSuspended middleware)
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    /**
     * Test that admin can view the activity logs page.
     */
    public function test_admin_can_view_activity_logs()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        ActivityLog::log('user_created', 'Jane Doe created');

        $response = $this->actingAs($admin)
            ->get(route('dashboard.bitacora'));

        $response->assertStatus(200);
        $response->assertSee('Jane Doe created');
    }
}
