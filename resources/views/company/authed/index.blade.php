@extends('layouts.app')
@section('title', $company->identifier)
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-6 col-sm-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">{{ $company->name }} <sup>{{ $company->identifier }}</sup></h4>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Maximum Shares</th>
                                    <th>Free Shares</th>
                                    <th>Sold Shares</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $company->shares }}</td>
                                    <td>{{ $company->free_shares }}</td>
                                    <td>{{ $company->shares - $company->free_shares }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="buySharesDiv" class="hidden">
                        <form action="/company/{{ $company->identifier }}/buy" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="sharenum">Number of Shares</label>
                                <input type="number" placeholder="Number of Shares" name="shares" class="form-control" min="1" max="{{ $company->free_shares }}">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Buy Shares</button>
                            </div>
                        </form>
                    </div>
                    <div id="sellSharesDiv" class="hidden">
                        <form action="/company/{{ $company->identifier }}/sell" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="sharenum">Number of Shares</label>
                                <input type="number" placeholder="Number of Shares" name="shares" class="form-control" min="1" max="{{ Auth::user()->sharesOfCompany($company) }}">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-danger">Sell Shares</button>
                            </div>
                        </form>
                    </div>
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ session()->pull('success') }}
                        </div>
                    @elseif(session()->has('error'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ session()->pull('error') }}
                        </div>
                    @endif
                    @if(Auth::check())
                        <a onclick="showBuyShares()" class="btn btn-primary" id="buySharesButton">Buy Shares</a>
                        @if(Auth::user()->sharesOfCompany($company) > 0)
                            <a onclick="showSellShares()" class="btn btn-danger" id="sellSharesButton">Sell Shares</a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-sm-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Stock Changes</h4>
                    <div class="row">
                        <div class="col-xl-3 col-sm-6"><strong>Current value</strong></div>
                        <div class="col-xl-3 col-sm-6">${{ number_format($company->value / 100,2) }}</div>
                    </div>                    
                    @if($stocks->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Previous Value</th>
                                    <th>New Value</th>
                                    <th>Value Change</th>
                                    <th>Time</th>
                                </tr>
                            </thead>           
                        @foreach($stocks->get() as $stock)
                            <tbody>
                                <tr>
                                    @if($stock->previous != 0)
                                    <td>${{ number_format($stock->previous / 100,2) }}</td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    <td>${{ number_format($stock->value / 100,2) }}</td>
                                    <td>${{ number_format(($stock->value - $stock->previous) / 100,2) }}</td>
                                    <td>{{ $stock->created_at->diffForHumans() }}</td>
                                </tr>
                            </tbody>                            
                        @endforeach
                        </table>            
                    @else
                    No stock changes today.
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Latest Transactions</h4>
                    @if($transactions->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Share Amount</th>
                                    <th>Value</th>
                                    <th>Time</th>
                                </tr>
                            </thead>           
                        @foreach($transactions->get() as $transaction)
                            <tbody>
                                <tr>
                                    <td><a href="/user/{{ $transaction->user->name }}">{{ $transaction->user->name }}</a></td>
                                    <td>{{ $transaction->getType() }}</td>
                                    <td>{{ $transaction->shares }}</td>
                                    <td>${{ number_format(($transaction->shares * $company->value) / 100,2)}}</td>
                                    <td>{{ $transaction->created_at->diffForHumans() }}</td>
                                </tr>
                            </tbody>                            
                        @endforeach
                        </table>                                 
                    @else
                    No Transactions today.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
function showBuyShares() {
    $("#buySharesDiv").show();
    $("#buySharesButton").hide();
}
function showSellShares() {
    $("#sellSharesDiv").show();
    $("#sellSharesButton").hide();
}
</script>
@endsection