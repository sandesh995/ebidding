@extends('front.layouts.app')
@section('title', 'Balance History')
@section('content')
<div class="container py-4" style="max-width: 900px;margin:auto">
    <div class="card mb-2">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <span class="bold">Balance History Information</span>
                <a href="{{ route('front.balance') }}" class="btn btn-primary">Back to Balance</a>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered m-0" style="box-shadow: none!important;border:1px solid #f4f4f4">
                <tr>
                    <td>ID</td>
                    <td>{{ $balance->id }}</td>
                </tr>
                <tr>
                    <th>Type:</th>
                    <td>{{ $balance->type }}</td>
                </tr>
                <tr>
                    <th>Amount</th>
                    <td>Rs. {{ abs($balance->amount) }}</td>
                </tr>
                <tr>
                    <th>Title</th>
                    <td>{{ $balance->title }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $balance->description }}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>{{ $balance->created_at }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection