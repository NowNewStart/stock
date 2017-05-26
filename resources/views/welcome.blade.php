@extends('layouts.app')
@section('title', 'Home')

@section('content')

<div class="container">
    @if(!Auth::check())
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Want to join and play in our fake stock market too?</h4>
                    <a href="/login" class="btn btn-primary">Sign In</a> or
                    <a href="/register" class="btn btn-outline-primary">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Most valueable companies</h4>
                        <p class="card-text">
                            <ul class="list-group">
                                @foreach($mvc as $company)
                                    <li class="list-group-item">
                                        <a href="/company/{{ $company->identifier }}">{{ $company->name }}</a>
                                        <sup>${{ $company->getValue() }}</sup>
                                    </li>
                                @endforeach
                            </ul>
                        </p>
                    </div>
                </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">Most valueable users</h4>
                        <p class="card-text">
                            <ul class="list-group">
                                @foreach($users as $user)
                                    <li class="list-group-item">
                                        <a href="/user/{{ $user->name }}">{{ $user->name }}</a>
                                        <sup>${{ $user->getBalance() }}</sup>
                                    </li>
                                @endforeach
                            </ul>
                        </p>
                    </div>
                </div>            
        </div>
    </div>
</div>

@endsection
