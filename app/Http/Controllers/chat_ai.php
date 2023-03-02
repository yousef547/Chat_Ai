<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class chat_ai extends Controller
{
    public function index(){
        return view('admin.chatAi.index');
    }
}
