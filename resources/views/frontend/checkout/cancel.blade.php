@extends('frontend.master')
@section('title','Payment Cancelled')
@section('content')

<div class="cancel-wrap">
    <div class="cancel-card">
        <div class="cancel-icon">
            <svg viewBox="0 0 52 52" width="64" height="64">
                <circle class="cancel-icon__circle" cx="26" cy="26" r="24" fill="none"/>
                <path class="cancel-icon__line1" fill="none" d="M18 18l16 16"/>
                <path class="cancel-icon__line2" fill="none" d="M34 18l-16 16"/>
            </svg>
        </div>

        <h1>Payment Not Successful</h1>
        <p class="cancel-sub">Your payment was cancelled or didn't go through. No charge was made — you can try again whenever you're ready.</p>

        <div class="cancel-actions">
            <a href="{{ route('cart.view') }}" class="btn btn-outline">Go back to Cart</a>
        </div>
    </div>
</div>

<style>
.cancel-wrap {
    min-height: 60vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 16px;
    background: #f7f8fa;
}

.cancel-card {
    background: #fff;
    max-width: 460px;
    width: 100%;
    text-align: center;
    padding: 48px 32px;
    border-radius: 12px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
}

.cancel-icon { margin-bottom: 20px; }

.cancel-icon__circle {
    stroke: #ef4444;
    stroke-width: 3;
    stroke-dasharray: 151;
    stroke-dashoffset: 151;
    animation: circle-draw 0.6s ease-out forwards;
}

.cancel-icon__line1,
.cancel-icon__line2 {
    stroke: #ef4444;
    stroke-width: 4;
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-dasharray: 23;
    stroke-dashoffset: 23;
    animation: check-draw 0.35s ease-out 0.5s forwards;
}

@keyframes circle-draw { to { stroke-dashoffset: 0; } }
@keyframes check-draw { to { stroke-dashoffset: 0; } }

.cancel-card h1 {
    font-size: 24px;
    font-weight: 700;
    margin: 0 0 8px;
    color: #111827;
}

.cancel-sub {
    color: #6b7280;
    font-size: 15px;
    margin: 0 0 28px;
    line-height: 1.5;
}

.cancel-actions {
    display: flex;
    gap: 12px;
}

.btn {
    flex: 1;
    padding: 12px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.15s ease;
}

.btn-primary {
    background: #111827;
    color: #fff;
}
.btn-primary:hover { background: #1f2937; color: #fff; }

.btn-outline {
    background: #fff;
    color: #111827;
    border: 1px solid #d1d5db;
}
.btn-outline:hover { background: #f9fafb; }

@media (max-width: 480px) {
    .cancel-actions { flex-direction: column; }
}
</style>

@endsection
