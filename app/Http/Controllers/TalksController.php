<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TalksController extends Controller
{
    // function that returns a create talk page view
    public function createtalkpage(){
        return view('createtalk');
    }
}
