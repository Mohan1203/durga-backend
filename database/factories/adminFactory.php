<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Admin;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class adminFactory extends Factory
{
    protected $model = Admin::class;
    public function definition(): array
    {
        return [
            'email' => 'admin@gmail.com',
            'password' => 'admin@123',
        ];
    }
}
