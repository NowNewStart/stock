<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Company;
use App\User;
use Auth;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $mvc = Company::orderBy('value', 'desc')->get()->take(10);
        $users = Bank::orderByDesc('credit')->take(100)->get()->map->user;

        return view('welcome', ['mvc' => $mvc, 'users' => $users]);
    }

    /**
     * @return view
     */
    public function getDashboard()
    {
        $transactions = Auth::user()->transactions()->orderByDesc('id')->take(10)->get();

        return view('dashboard', [
            'transactions' => $transactions,
        ]);
    }

    /**
     * @return view
     */
    public function getUserLeaderboardByCredit()
    {
        $users = Bank::orderByDesc('credit')->take(100)->get()->map->user;

        return view('leaderboards.user', ['users' => $users, 'sorted_by' => 'Credit']);
    }

    /**
     * @return view
     */
    public function getUserLeaderboardByShares()
    {
        $users = User::take(100)->get()->sortByDesc(function ($user, $key) {
            return $user->sharesOwned();
        });

        return view('leaderboards.user', ['users' => $users, 'sorted_by' => 'Shares owned']);
    }

    /**
     * @return view
     */
    public function getCompanyLeaderboardByValue()
    {
        $companies = Company::take(100)->get()->sortByDesc('value');

        return view('leaderboards.company', ['companies' => $companies, 'sorted_by' => 'Value']);
    }

    /**
     * @return view
     */
    public function getCompanyLeaderboardByShares()
    {
        $companies = Company::take(100)->get()->sortByDesc(function ($company, $key) {
            return $company->getSoldShares();
        });

        return view('leaderboards.company', ['companies' => $companies, 'sorted_by' => 'Shares sold']);
    }
}
