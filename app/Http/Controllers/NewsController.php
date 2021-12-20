<?php

namespace App\Http\Controllers;

use App\Models\News;

class NewsController extends Controller
{
    public function getList()
    {
        $news = News::query()
            ->whereDate('published_at', '<=', date('Y-m-d H:i:s'))
            ->where('is_published', true)
            ->ordered()
            ->paginate(5);

        return view('newsList', ['news' => $news]);
    }

    public function getDetails(string $slug)
    {
        $newsEntry = News::query()
            ->where('slug', $slug)
            ->whereDate('published_at', '<=', date('Y-m-d H:i:s'))
            ->where('is_published', true)
            ->first();

        if ($newsEntry === null)
            abort(404);
        return view('news', ['newsEntry' => $newsEntry]);
    }
}
