<?php

namespace App\Http\Controllers;

use App\Models\Postagem;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Postagem::whereNotNull('publicado_em')
            ->where('publicado_em', '<=', now())
            ->orderBy('publicado_em', 'desc')
            ->paginate(9);

        return view('blog.index', compact('posts'));
    }

    public function show(string $slug): View
    {
        $post = Postagem::where('slug', $slug)
            ->whereNotNull('publicado_em')
            ->where('publicado_em', '<=', now())
            ->firstOrFail();

        return view('blog.show', compact('post'));
    }
}