<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'password' => static::$password ??= Hash::make('password'),
            'is_super_user' => false,
            'remember_token' => Str::random(10),
        ];
    }

    public function superUser(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_super_user' => true,
        ]);
    }

    public function regularUser(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_super_user' => false,
        ]);
    }
}