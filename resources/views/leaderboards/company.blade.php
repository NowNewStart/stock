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
                            <th>Company</th>
                            <th>Value</th>
                            <th>Shares sold</th>
                            <th>Date joined</th>
                            <th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <td><a href="/company/{{ $company->identifier }}">{{ $company->name }}</a></td>
                                <td>${{ $company->getValue() }}</td>
                                <td>{{ $company->getSoldShares() }}</td>
                                <td>{{ $company->created_at->diffForHumans() }}</td>
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