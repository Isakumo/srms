<?php

namespace Tests\Feature\Auth;

use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_login_succeeds(): void
    {
        $school = School::create([
            'name' => 'Test School',
            'code' => 'test-school',
            'status' => 'ACTIVE',
        ]);

        $user = User::factory()->create([
            'school_id' => $school->id,
            'username' => 'student01',
            'password' => bcrypt('password123'),
            'status' => 'ACTIVE',
        ]);

        $response = $this->post('/login', [
            'username' => 'student01',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_login_fails(): void
    {
        $response = $this->from('/login')->post('/login', [
            'username' => 'unknown',
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}
