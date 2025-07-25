<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * Модель тега
 *
 * @property int $id Идентификатор
 * @property string $name Название тега
 * @property Carbon|null $created_at Дата создания
 * @property Carbon|null $updated_at Дата обновления
 *
 * @property-read Collection|Post[] $posts Посты, связанные с тегом
 *
 * @mixin Model
 */
class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Получить посты, связанные с тегом
     *
     * @return BelongsToMany
     */
    public function posts():BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
