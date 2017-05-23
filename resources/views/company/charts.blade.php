@extends('layouts.app')
@section('title', $company->identifier. ' Charts')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-sm-12">    
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">{{ $company->name }}</h4>
                        {!! $stock_chart->render() !!}
                        <a class="btn btn-primary" href="/company/{{ $company->identifier }}">Back</a>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@endsection