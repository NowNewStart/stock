@extends('layouts.app')
@section('title', $user->name)
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-6 col-sm-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">{{ $user->name }}</h4>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <td><strong>Joined</strong></td>
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Bank Account Value</strong></td>
                                    <td>${{ number_format($user->bank->credit / 100,2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Amount of Shares owned</strong></td>
                                    <td>{{ $user->sharesOwned() }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>                    
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-sm-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Latest Transactions</h4>
                    @if($shares->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Bought Shares</th>
                                    <th>Value</th>
                                    <th>Time</th>
                                </tr>
                            </thead>           
                        @foreach($shares->get() as $share)
                            <tbody>
                                <tr>
                                    <td><a href="/user/{{ $share->user->name }}">{{ $share->user->name }}</a></td>
                                    <td>{{ $share->amount }}</td>
                                    <td>${{ number_format(($share->amount * $share->company->value) / 100,2) }}</td>
                                    <td>{{ $share->updated_at->diffForHumans() }}</td>
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