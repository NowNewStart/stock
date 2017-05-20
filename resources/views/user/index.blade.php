@extends('layouts.app')
@section('title', $user->name)
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="offset-xl-1 col-xl-5 col-sm-12">
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
                                    <td>${{ $user->getBalance() }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Amount of Shares</strong></td>
                                    <td>{{ $user->sharesOwned() }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>                    
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-sm-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Owned Shares</h4>
                    @if($shares->count() > 0)
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Company</th>
                                    <th>Shares</th>
                                    <th>Value</th>
                                    <th>Time</th>
                                </tr>
                            </thead>           
                        @foreach($shares->get() as $share)
                            <tbody>
                                <tr>
                                    <td><a href="/user/{{ $share->user->name }}">{{ $share->user->name }}</a></td>
                                    <td><a href="/company/{{ $share->company->identifier }}">{{ $share->company->name }}</a></td>
                                    <td>{{ $share->amount }}</td>
                                    <td>${{ $share->getShareValue() }}</td>
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