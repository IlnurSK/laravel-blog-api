<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class TagService
{
    public function index(): Collection
    {
        return Tag::all();
    }
    public function create(array $data): Tag
    {
        // Возвращаем экземпляр нового Тега
        return Tag::create($data);
    }

    public function update(Tag $tag, array $data): Tag
    {
        // Обновляем данные в текущем Теге
        $tag->update($data);
        return $tag;
    }

    public function delete(Tag $tag): void
    {
        // Удаляем Тег
        $tag->delete();
    }

}
