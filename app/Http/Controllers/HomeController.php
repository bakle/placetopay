<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Mostrar vista de simulacion de checkout
     *
     * @return view     
     **/
    public function index()
    {
        $price = number_format(rand(1000, 10000), 0);
        session(['price' => $price]);
        
        return view('home', compact('price'));
    }
}
