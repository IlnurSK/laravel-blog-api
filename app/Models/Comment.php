<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Модель комментария
 *
 * @property int $id Идентификатор
 * @property string $body Текст комментария
 * @property int $user_id ID пользователя
 * @property int $post_id ID поста
 * @property Carbon|null $created_at Дата создания
 * @property Carbon|null $updated_at Дата обновления
 *
 * @property-read User $user Автор комментария
 * @property-read Post $post Пост, к которому относится комментарий
 *
 * @mixin Model
 */
class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'user_id',
        'post_id',
    ];

    /**
     * Автор комментария
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Пост, к которому относится комментарий
     *
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
