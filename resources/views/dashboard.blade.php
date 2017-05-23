@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="offset-xl-1 col-xl-6 col-sm-12">    
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Latest Transactions</h4>
                        @if($transactions->count() > 0 )                     
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Company</th>
                                    <th>Share Amount</th>
                                    <th>Time</th>
                                </tr>
                            </thead>           
                        @foreach($transactions as $transaction)
                            <tbody>
                                <tr>
                                    <td>{{ $transaction->getType() }}</td>
                                    <td><a href="/company/{{ $transaction->company->identifier }}">{{ $transaction->company->name }}</a></td>
                                    <td>{{ $transaction->parsePayload()}}</td>
                                    <td>{{ $transaction->created_at->diffForHumans() }}</td>
                                </tr>
                            </tbody>                            
                        @endforeach
                        </table>                         
                        @else
                        No transactions so far.
                        @endif
                    </div>
                </div>
        </div>
        <div class="col-xl-3 col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Your Bank Account</h4>
                            <p class="card-text">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <td><strong>Current Bank Credit</strong></td>
                                                <td>${{ Auth::user()->getBalance() }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Change since starting</strong></td>
                                                <td>
                                                    @if(Auth::user()->getProfit() > 0)
                                                        <span style="color:green">${{ Auth::user()->getProfit() }}</span>
                                                    @else 
                                                        <span style="color:red">${{ Auth::user()->getProfit() }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Share Value</strong></td>
                                                <td>${{ Auth::user()->getOwnedShareValue() }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </p>
                        </div>
                    </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection