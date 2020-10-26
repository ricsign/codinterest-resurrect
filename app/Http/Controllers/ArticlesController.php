<?php

// This controller controls all the logics regarding the articles

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\Comments;

class ArticlesController extends Controller
{
    // function that allows view to get articles from controllers
    public static function allarticlesFromView()
    {
        return Articles::orderBy('aid', 'desc')->get();
    }


    // function that yields the articles page
    public function allarticles()
    {
        // get articles by popular and recent
        $pop = Articles::orderBy('aviews', 'desc')->orderBy('acomments', 'desc');
        $new = Articles::orderBy('aid', 'desc');
        $topfivepopular = $pop->limit(5)->get();
        $topfivenew = $new->limit(5)->get();
        $newarticles = $new->simplePaginate(10);
        $populararticles = $pop->simplePaginate(10);
        $allpopular = $pop->get();
        return view('articles', compact('populararticles', 'newarticles', 'topfivenew', 'topfivepopular', 'allpopular'));
    }


    // page that only get one individual article
    public function getsinglearticle($aid)
    {
        // 1. get articles
        $article = Articles::get()->where('aid', $aid)->first();
        if (!$article) return redirect('/public/allarticles');

        // 2. get comments
        $comments = Comments::where('aid', $aid)->orderBy('created_at', 'desc')->simplePaginate(20);
        $comments_size = count(Comments::where('aid', $aid)->get('cid'));

        // 3. increment article's view by 1
        $article->increment('aviews');

        return view('getsinglearticle', compact('article', 'comments', 'comments_size'));
    }
}
