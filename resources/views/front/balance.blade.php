@extends('front.layouts.app')
@section('title', 'Balance History')
@section('content')
<div class="container py-4" style="max-width: 900px;margin:auto">
    <div class="card mb-2">
        <div class="card-header bold">Balance</div>
        <div class="card-body">
           <div class="row">
               <div class="col-9">
                    <h1>Rs. {{ $balance }}</h1>
               </div>
               <div class="col-3 d-flex align-items-center justify-content-center">
                   <a href="/topup" class="btn btn-primary">Top Up</a>
               </div>
           </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bold">Balance History</div>
        <div class="card-body p-0">
            <table class="table table-bordered m-0" style="box-shadow: none!important;border:1px solid #f4f4f4">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Type</td>
                        <th>Amount</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $item)
                    @if($item->type == "Credit")
                    <tr style="background: #ecfdf5">
                    @else
                    <tr style="background: #fff7ed">
                    @endif
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $item->type }}</td>
                        <td>Rs. {{ abs($item->amount) }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="{{ route('front.balance.info', $item) }}">
                                Details
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center">You do not have any balance history!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection