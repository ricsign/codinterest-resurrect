<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function allarticles(){
        return view('articles');
    }

    public function getsinglearticle($aid){

        $article = Articles::get()->where('aid',$aid)->first();
        if(!$article) return redirect('/public/allarticles');

        // increment article's view by 1
        $article->increment('aviews');

        return view('getsinglearticle',compact('article'));
    }
}
