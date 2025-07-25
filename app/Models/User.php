<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * Модель пользователя
 *
 * @property int $id Идентификатор
 * @property string $name Имя пользователя
 * @property string $email Email
 * @property Carbon|null $email_verified_at Дата верификации email
 * @property string|null $password Пароль (хэш)
 * @property string|null $remember_token Токен "запомнить меня"
 * @property Carbon|null $created_at Дата создания
 * @property Carbon|null $updated_at Дата обновления
 * @property bool $is_admin Признак администратора
 *
 * @property-read Collection|Post $posts Посты пользователя
 * @property-read Collection|Comment $comments Комментарии пользователя
 *
 * @mixin Model
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Массово присваиваемые атрибуты
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    /**
     * Скрытые атрибуты при сериализации
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Преобразования типов
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * Посты пользователя
     *
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Комментарии пользователя
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
