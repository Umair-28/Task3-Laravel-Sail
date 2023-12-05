<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class testController extends Controller
{
    public function test()  
    {   
        return view('test');
    }
    public function test2() {
        $alltest = \App\Models\Test::all();
        return response($alltest);
        }
}
