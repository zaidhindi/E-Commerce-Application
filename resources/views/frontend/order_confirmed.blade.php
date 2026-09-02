@extends('frontend.master')
@section('title','Order Confirmed')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body p-5">

                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-success bg-opacity-10"
                             style="width: 90px; height: 90px;">
                            <i class="fas fa-check text-success" style="font-size: 40px;"></i>
                        </div>
                    </div>

                    <h1 class="h3 fw-bold mb-3">
                        Order Confirmed!
                    </h1>

                    <p class="text-muted mb-4">
                        Thank you for your purchase. Your order has been confirmed
                        and is now on its way to be shipped. We'll notify you once
                        it has been dispatched.
                    </p>

                    <a href="{{ route('home') }}" class="btn btn-primary px-4 py-2">
                        Back to Home
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
