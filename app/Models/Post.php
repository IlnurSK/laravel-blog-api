<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Модель поста
 *
 * @property int $id Идентификатор
 * @property int $user_id ID пользователя
 * @property int $category_id ID категории
 * @property string $title Заголовок поста
 * @property string $body Текст поста
 * @property bool $is_published Опубликован ли пост
 * @property Carbon|null $created_at Дата создания
 * @property Carbon|null $updated_at Дата обновления
 *
 * @property-read User $user Автор поста
 * @property-read Category $category Категория поста
 * @property-read Collection|Tag[] $tags Теги поста
 * @property-read Collection|Comment[] $comments Комментарии поста
 *
 * @mixin Model
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'is_published',
        'user_id',
        'category_id',
    ];

    /**
     * Автор поста
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Категория поста
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Теги поста
     *
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Комментарии поста
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
