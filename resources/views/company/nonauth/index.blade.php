@extends('layouts.app')
@section('title', $company->identifier)
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-5 col-sm-12">
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
                        @foreach($transactions as $transaction)
                            <tbody>
                                <tr>
                                    @if($transaction->user_id != null)
                                        <td><a href="/user/{{ $transaction->user->name }}">{{ $transaction->user->name }}</a></td>
                                    @else
                                        <td>System</td>
                                    @endif
                                    <td>{{ $transaction->getType() }}</td>
                                    <td>{{ $transaction->parsePayload()}}</td>
                                    @if($transaction->getType() != 'random')
                                        <td>${{ number_format(($transaction->shares * $company->value) / 100,2)}}</td>
                                    @else
                                        <td></td>
                                    @endif
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
        <div class="col-xl-7 col-sm-12">
            <div class="card">
                <div class="card-block">
                    <p class="card-text">
                        {!! $chart->render() !!}
                    </p>
                </div>
            </div>        
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Stock Changes</h4>
                    <div class="row">
                        <div class="col-xl-3 col-sm-6"><strong>Current value</strong></div>
                        <div class="col-xl-3 col-sm-6">${{ $company->getValue() }}</div>
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
                                    <td>${{ $stock->getPreviousValue() }}</td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    <td>${{ $stock->getCurrentValue() }}</td>
                                    <td>${{ $stock->getChangeValue() }}</td>
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