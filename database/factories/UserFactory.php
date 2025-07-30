<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Фабрика пользователей.
 *
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Текущий пароль, используемый фабрикой
     *
     * @var string|null
     */
    protected static ?string $password;

    /**
     * Определить значения по умолчанию для пользователя
     *
     * @return array{
     *     name: string,
     *     email: string,
     *     email_verified_at: Carbon,
     *     password: string,
     *     remember_token: string
     * }
     */
    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
            'is_admin'          => false,
        ];
    }

    /**
     * Указать, что email пользователя не подтвержден
     *
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
