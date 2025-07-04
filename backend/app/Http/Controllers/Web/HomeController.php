<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * @throws ConnectionException
     */
    // Метод отображения главной страницы, с получением данных по API

    public function index(Request $request)
    {
        // Создаем запрос с категориями и тегами
        $query = $request->only(['category_id', 'tag_id']);

        // Обращаемся к API с нашим запросом
        $response = Http::get(route('api.posts.index', $query));

        // Обрабатываем ошибки
        if (!$response->ok()) {
            abort(500, 'Ошибка при получении постов с API');
        }

        // Сохраняем массив постов
        $posts = $response->json('data');

        // Сохраняем мета данные, если она есть (пагинацию)
        $meta = $response->json('meta') ?? [];

        // Получим массивы всех доступных категорий и тегов
        $categories = Http::get(route('api.categories.index'))->json('data');
        $tags = Http::get(route('api.tags.index'))->json('data');

        // Возвращаем представление стартовой страницы и передаем туда все данные
        return view('home.index', compact('posts', 'meta', 'categories', 'tags'));


    }
}
