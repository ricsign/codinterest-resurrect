<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\Comments;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function allarticles(){
        $newarticles = Articles::orderBy('aid','desc')->limit(6)->get();
        $populararticles = Articles::orderBy('aviews','desc')->orderBy('acomments','desc')->limit(6)->get();
        return view('articles',compact('populararticles','newarticles'));
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
