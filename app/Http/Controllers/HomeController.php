<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Company;

class HomeController extends Controller
{
    /**
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

    /**
     * @return view
     */
    public function getDashboard()
    {
        return view('dashboard');
    }
}
