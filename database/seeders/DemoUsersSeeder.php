<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DemoUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Crea 3 usuarios de demostración: Admin, Docente y Alumno
     */
    public function run(): void
    {
        // ========================================
        // 1. USUARIO ADMIN
        // ========================================
        $admin = User::firstOrCreate(
            ['email' => 'admin@demo.educate.com'],
            [
                'name' => 'Administrador Sistema',
                'password' => bcrypt('demo123'),
                'email_verified_at' => now(),
                'rfc' => 'ADMIN000000000',
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
            ]
        );
        $admin->assignRole('admin');
        
        // Crear wallet con balance inicial
        if (!$admin->wallet()->exists()) {
            $admin->wallet()->create(['balance' => 50000]);
        }

        // ========================================
        // 2. USUARIO DOCENTE
        // ========================================
        $teacher = User::firstOrCreate(
            ['email' => 'docente@demo.educate.com'],
            [
                'name' => 'Dr. Juan Carlos Rivera',
                'password' => bcrypt('demo123'),
                'email_verified_at' => now(),
                'rfc' => 'DOCENT0000000001',
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
            ]
        );
        $teacher->assignRole('docente');
        
        // Crear wallet con balance para recompensas
        if (!$teacher->wallet()->exists()) {
            $teacher->wallet()->create(['balance' => 5000]);
        }

        // ========================================
        // 3. USUARIO ALUMNO
        // ========================================
        $student = User::firstOrCreate(
            ['email' => 'alumno@demo.educate.com'],
            [
                'name' => 'María González López',
                'password' => bcrypt('demo123'),
                'email_verified_at' => now(),
                'rfc' => 'GONZA000000001',
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
            ]
        );
        $student->assignRole('alumno');
        
        // Crear wallet con saldo inicial para estudiantes
        if (!$student->wallet()->exists()) {
            $student->wallet()->create(['balance' => 1250]);
        }
    }
}
