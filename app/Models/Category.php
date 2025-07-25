<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Модель категории
 *
 * @property int $id Идентификатор
 * @property string $name Название категории
 * @property Carbon|null $created_at Дата создания
 * @property Carbon|null $updated_at Дата обновления
 *
 * @property-read Collection|Post[] $posts Посты категории
 *
 * @mixin Model
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Получить посты принадлежащие категории
     *
     * @return HasMany
     */
    public function posts():HasMany
    {
        return $this->hasMany(Post::class);
    }
}
