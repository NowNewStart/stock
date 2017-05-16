@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Credit</th>
                            <th>Shares owned</th>
                            <th>Date joined</th>
                            <th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td><a href="/user/{{ $user->name }}">{{ $user->name }}</a></td>
                                <td>${{ $user->getBalance() }}</td>
                                <td>{{ $user->sharesOwned() }}</td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection