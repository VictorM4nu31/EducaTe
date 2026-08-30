<?php

namespace Tests;

use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Garantizar que existan los roles/permisos usados por `assignRole`
        // al crear usuarios con la factory. Idempotente.
        $this->seed(RolesAndPermissionsSeeder::class);
    }
}
