<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * @throws ConnectionException
     */
    // Метод отображения главной страницы, с получением данных по API
    public function index()
    {
        // Обращаемся к API с нашим запросом
        $response = Http::baseUrl(config('app.api_url'))->get('/api/posts');

        // Сохраняем массив постов в случае успеха, если нет то пустой массив
        $posts = $response->successful() ? $response->json('data') : [];

        // Возвращаем представление стартовой страницы и передаем туда посты
        return view('home.index', compact('posts'));
    }
}
