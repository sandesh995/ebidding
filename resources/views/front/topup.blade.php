@extends('front.layouts.app')
@section('title', 'Top Up Balance')
@section('content')
<div class="container py-4" style="max-width: 900px;margin:auto">
    <div class="card mb-2">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <span class="bold">Top Up Balance</span>
                <a href="{{ route('front.balance') }}" class="btn btn-primary">Back to Balance</a>
            </div>
        </div>
        <div class="card-body">
            <h4 class="mb-0">Current Balance <b>Rs. {{ $balance }}</b></h4>
            <hr>
            <p>You can top-up via various means. Choose any suitable method for you:</p>

            <blockquote style="background: #f4f4f4;color:green;" class="px-4 py-3 bold">
                Please include your email address as "Remarks" when providing payment.
            </blockquote>

            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Pay Online
                    </button>
                  </h2>
                  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      <p>You can send your desired amount to us via your payment provider of choice.</p>

                      <h5>e-Sewa / FonePay / ConnectIPS / Khalti / IME Pay</h5>
                      <ul class="mb-2">
                          <li>Name: E-BIDDING PVT LTD</li>
                          <li>Account: 9811111111</li>
                      </ul>

                      <h5>Paypal</h5>
                      <ul>
                          <li>Name: E-BIDDING PVT LTD</li>
                          <li>Account: payment@ebiddingnp.com.np</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      More Coming Soon...
                    </button>
                  </h2>
                  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                      We are working on automatic payment methods. More Payment providers will also be added soon.
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection