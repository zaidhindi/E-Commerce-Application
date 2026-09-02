@extends('frontend.master')
@section('content')
<div class="ship-wrap">
    <div class="ship-card">
        <h2>Shipping Details</h2>
        <p class="ship-sub">We'll use this to deliver your order.</p>

        <form action="{{ route('order.shipping.store') }}" method="POST" class="ship-form">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id ?? '' }}">

            <div class="field">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" placeholder="John Doe" required>
            </div>

            <div class="field">
                <label for="country">Country</label>
                <select id="country" name="country" required>
                    <option value="" disabled selected>Select your country</option>
                </select>
            </div>

            <div class="field">
                <label for="phone">Phone Number</label>
                <div class="phone-input">
                    <span class="phone-flag" id="phoneFlag">🏳️</span>
                    <span class="phone-code" id="phoneCode">+</span>
                    <input type="tel" id="phone" name="phone" placeholder="7X XXX XXXX" required>
                </div>
            </div>

            <div class="field">
                <label for="city">City</label>
                <input type="text" id="city" name="city" placeholder="Amman" required>
            </div>

            <div class="field">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" placeholder="Street, building, apartment" required>
            </div>

            <button type="submit" class="btn btn-primary">Save Shipping Details</button>
        </form>
    </div>
</div>
<style>
.ship-wrap {
    display: flex;
    justify-content: center;
    padding: 0 16px 40px;
    background: #f7f8fa;
}

.ship-card {
    background: #fff;
    max-width: 460px;
    width: 100%;
    padding: 40px 32px;
    border-radius: 12px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
}

.ship-card h2 {
    font-size: 20px;
    font-weight: 700;
    margin: 0 0 4px;
    color: #111827;
}

.ship-sub {
    color: #6b7280;
    font-size: 14px;
    margin: 0 0 24px;
}

.field {
    margin-bottom: 18px;
    text-align: left;
}

.field label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
}

.field input,
.field select {
    width: 100%;
    padding: 11px 14px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    color: #111827;
    background: #fff;
    box-sizing: border-box;
    transition: border-color 0.15s ease;
}

.field input:focus,
.field select:focus {
    outline: none;
    border-color: #111827;
}

.phone-input {
    display: flex;
    align-items: center;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    overflow: hidden;
    transition: border-color 0.15s ease;
}

.phone-input:focus-within {
    border-color: #111827;
}

.phone-flag {
    font-size: 18px;
    padding: 0 6px 0 12px;
    display: flex;
    align-items: center;
}

.phone-code {
    font-size: 14px;
    color: #6b7280;
    padding-right: 8px;
    border-right: 1px solid #e5e7eb;
    white-space: nowrap;
}

.phone-input input {
    border: none;
    border-radius: 0;
    flex: 1;
    min-width: 0;
}

.phone-input input:focus {
    outline: none;
}

.btn {
    width: 100%;
    padding: 13px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    margin-top: 6px;
}

.btn-primary {
    background: #111827;
    color: #fff;
}
.btn-primary:hover { background: #1f2937; }
</style>

@endsection
@section('js')

<script>
document.addEventListener('DOMContentLoaded', function () {
    // iso2 code, country name, dial code
    const countries = [
        ["JO","Jordan","962"],["SA","Saudi Arabia","966"],["AE","United Arab Emirates","971"],
        ["EG","Egypt","20"],["QA","Qatar","974"],["KW","Kuwait","965"],["BH","Bahrain","973"],
        ["OM","Oman","968"],["LB","Lebanon","961"],["IQ","Iraq","964"],["PS","Palestine","970"],
        ["SY","Syria","963"],["YE","Yemen","967"],["US","United States","1"],["GB","United Kingdom","44"],
        ["CA","Canada","1"],["DE","Germany","49"],["FR","France","33"],["TR","Turkey","90"],
        ["IN","India","91"],["CN","China","86"],["JP","Japan","81"]
    ];

    const countrySelect = document.getElementById('country');
    const phoneInput = document.getElementById('phone');
    const phoneFlag = document.getElementById('phoneFlag');
    const phoneCode = document.getElementById('phoneCode');

    // populate country dropdown
    countries.forEach(([iso, name, dial]) => {
        const opt = document.createElement('option');
        opt.value = name;        // store full country name as the value now
        opt.dataset.iso = iso;   // keep iso2 around for flag lookups
        opt.dataset.dial = dial;
        opt.textContent = `${name} (+${dial})`;
        countrySelect.appendChild(opt);
    });

    function flagUrl(iso) {
        return `https://flagcdn.com/24x18/${iso.toLowerCase()}.png`;
    }

    function setFlagAndCode(iso, dial) {
        phoneFlag.innerHTML = `<img src="${flagUrl(iso)}" width="20" height="15" alt="${iso}" style="border-radius:2px;">`;
        phoneCode.textContent = `+${dial}`;
    }

    // when country is picked from dropdown -> update flag + code
    countrySelect.addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        const iso = opt.dataset.iso;
        const dial = opt.dataset.dial;
        if (iso) setFlagAndCode(iso, dial);
    });

    // when user types into phone field -> detect dial code and switch flag/select
    phoneInput.addEventListener('input', function () {
        let digits = this.value.replace(/\D/g, '');
        if (!digits) return;

        // try to match the longest dial code first (e.g. avoid 1 matching before 962)
        const sorted = [...countries].sort((a, b) => b[2].length - a[2].length);
        const match = sorted.find(([iso, name, dial]) => digits.startsWith(dial));

        if (match) {
            const [iso, name, dial] = match;
            setFlagAndCode(iso, dial);
            countrySelect.value = name;   // match by full name now
            // strip the typed dial code from the visible input so it's just the local number
            this.value = digits.slice(dial.length);
        }
    });
});
</script>

@endsection
