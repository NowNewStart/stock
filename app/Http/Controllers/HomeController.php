<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Bank;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $mvc = Company::orderBy('value', 'desc')->get()->take(10);
        $mvu = Bank::orderBy('credit', 'desc')->get()->take(10)->map(function ($bank) {
            return ['user' => $bank->user, 'bank' => $bank];
        });
        return view('welcome', ['mvc' => $mvc, 'mvu' => $mvu]);
    }
}
