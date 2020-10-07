<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\Comments;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function allarticles(){
        $pop = Articles::orderBy('aviews','desc')->orderBy('acomments','desc');
        $new = Articles::orderBy('aid','desc');
        $topfivepopular = $pop->limit(5)->get();
        $topfivenew = $new->limit(5)->get();
        $newarticles = $new->simplePaginate(10);
        $populararticles = $pop->simplePaginate(10);
        $allpopular = $pop->get();
        return view('articles',compact('populararticles','newarticles','topfivenew','topfivepopular','allpopular'));
    }

    public static function allarticlesFromView(){
        return Articles::orderBy('aid','desc')->get();
    }

    public function getsinglearticle($aid){

        // get articles
        $article = Articles::get()->where('aid',$aid)->first();
        if(!$article) return redirect('/public/allarticles');

        // get comments
        $comments = Comments::where('aid',$aid)->orderBy('created_at','desc')->simplePaginate(20);
        $comments_size = count(Comments::where('aid',$aid)->get('cid'));

        // increment article's view by 1
        $article->increment('aviews');

        return view('getsinglearticle',compact('article','comments','comments_size'));
    }
}
