<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

/**
 * Сервис для работы с тегами.
 */
class TagService
{
    /**
     * Получить список всех тегов.
     *
     * @return Collection<Tag> Коллекция тегов
     */
    public function index(): Collection
    {
        return Tag::all();
    }

    /**
     * Создать новый тег.
     *
     * @param array{name: string} $data Данные для создания
     * @return Tag Новый тег
     */
    public function create(array $data): Tag
    {
        return Tag::create($data);
    }

    /**
     * Обновить тег.
     *
     * @param Tag $tag Тег для обновления
     * @param array{name: string} $data Данные для обновления
     * @return Tag Обновленный тег
     */
    public function update(Tag $tag, array $data): Tag
    {
        $tag->update($data);
        return $tag;
    }

    /**
     * Удалить тег.
     *
     * @param Tag $tag Тег для удаления
     * @return void
     */
    public function delete(Tag $tag): void
    {
        $tag->delete();
    }
}
