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


                    @if(Auth::check())
                        <a href="#" class="btn btn-primary">Buy Shares</a>
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
                    @if($stocks->count() > 0)
                        @foreach($stocks->get() as $stock)
                            <li>{{ $stock->value }}</li>
                        @endforeach
                    @else
                    No Stock Changes today.
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Latest Transactions</h4>
                    @if($shares->count() > 0)
                        @foreach($shares->get() as $share)
                            <li>{{ $stock->amount }}</li>
                        @endforeach
                    @else
                    No Transactions today.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
