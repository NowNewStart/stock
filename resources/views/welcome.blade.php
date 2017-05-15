@extends('layouts.app')

@section('content')

<div class="container">
    @if(!Auth::check())
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-sm-12">
            <div class="card">
                <div class="card-block">
                    <h4 class="card-title">Want to join too?</h4>
                    <a href="#" class="btn btn-primary">Sign In</a> or
                    <a href="#" class="btn btn-outline-primary">Sign Up</a>
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
                                        <sup>${{ $company->value }}</sup>
                                    </li>
                                @endforeach
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
                                @foreach($mvu as $u)
                                    <li class="list-group-item">
                                        <a href="/user/{{ $u['user']['name'] }}">{{ $u['user']['name'] }}</a>
                                        <sup>${{ $u['bank']['credit'] }}</sup>
                                    </li>
                                @endforeach
                        </p>
                    </div>
                </div>            

        </div>
    </div>
</div>

@endsection