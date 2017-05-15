@extends('layouts.app')

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
                                <input type="number" placeholder="Number of Shares" name="shares" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Buy Shares</button>
                            </div>
                        </form>
                    </div>
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ session()->pull('success') }}
                        </div>
                    @elseif(session()->has('error'))

                    @endif
                    @if(Auth::check())
                        <a onclick="showBuyShares()" class="btn btn-primary" id="buySharesButton">Buy Shares</a>
                        @if(Auth::user()->sharesOfCompany($company) > 0)
                            <a href="#" class="btn btn-warning">Sell Shares</a>
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
                        <div class="col-xl-3 col-sm-6">${{ $company->value }}</div>
                    </div>                    
                    @if($stocks->count() > 0)
                        @foreach($stocks->get() as $stock)
                            <li>{{ $stock->value }}</li>
                        @endforeach
                    @else
                    No stock changes today.
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Latest Transactions</h4>
                    @if($shares->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Bought Shares</th>
                                    <th>Time</th>
                                </tr>
                            </thead>           
                        @foreach($shares->get() as $share)
                            <tbody>
                                <tr>
                                    <td><a href="/user/{{ $share->user->name }}">{{ $share->user->name }}</a></td>
                                    <td>{{ $share->amount }}</td>
                                    <td>{{ $share->updated_at->format("H:i:s") }}</td>
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
</script>
@endsection