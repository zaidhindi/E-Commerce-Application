<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
     <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Starlight">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/starlight/img/starlight-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/starlight">
    <meta property="og:title" content="Starlight">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/starlight/img/starlight-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/starlight/img/starlight-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>My Store-@yield('title')</title>

    <!-- vendor css -->
    <link href="{{asset('/backend/lib/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('/backend/lib/Ionicons/css/ionicons.css')}}" rel="stylesheet">
    <link href="{{asset('/backend/lib/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet">
    <link href="{{asset('/backend/lib/rickshaw/rickshaw.min.css')}}" rel="stylesheet">

    <!-- Starlight CSS -->
    <link rel="stylesheet" href="{{asset('/backend/css/starlight.css')}}">
    @yield('css')
  </head>

  <body>
    @if(session('error') || session('success'))
<div class="toast-flash {{ session('success') ? 'toast-success' : 'toast-error' }}" id="flashToast">
    <div class="toast-icon">
        @if(session('success'))
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none">
                <circle cx="12" cy="12" r="10" fill="#22c55e"/>
                <path d="M8 12l3 3 5-5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        @else
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none">
                <circle cx="12" cy="12" r="10" fill="#ef4444"/>
                <path d="M15 9l-6 6M9 9l6 6" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
            </svg>
        @endif
    </div>

    <span class="toast-text">{{ session('success') ?? session('error') }}</span>

    <button type="button" class="toast-close" onclick="dismissToast()">&times;</button>

    <div class="toast-progress"></div>
</div>

<style>
.toast-flash {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 9999;
    display: flex;
    align-items: center;
    gap: 12px;
    background: #fff;
    padding: 14px 16px;
    border-radius: 10px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    min-width: 280px;
    max-width: 380px;
    overflow: hidden;
    animation: toast-in 0.35s ease-out forwards;
}

.toast-success { border-left: 4px solid #22c55e; }
.toast-error { border-left: 4px solid #ef4444; }

.toast-icon { flex-shrink: 0; display: flex; }

.toast-text {
    flex: 1;
    font-size: 14px;
    font-weight: 500;
    color: #111827;
    line-height: 1.4;
}

.toast-close {
    background: none;
    border: none;
    font-size: 18px;
    line-height: 1;
    color: #9ca3af;
    cursor: pointer;
    padding: 0 0 0 8px;
    flex-shrink: 0;
}
.toast-close:hover { color: #374151; }

.toast-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    background: currentColor;
    animation: toast-progress 3s linear forwards;
}

.toast-success .toast-progress { background: #22c55e; }
.toast-error .toast-progress { background: #ef4444; }

@keyframes toast-in {
    from { transform: translateX(120%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes toast-out {
    from { transform: translateX(0); opacity: 1; }
    to { transform: translateX(120%); opacity: 0; }
}

@keyframes toast-progress {
    from { width: 100%; }
    to { width: 0%; }
}

@media (max-width: 480px) {
    .toast-flash {
        left: 16px;
        right: 16px;
        top: 16px;
        min-width: unset;
        max-width: unset;
    }
}
</style>
@endif

    <!-- ########## START: LEFT PANEL ########## -->
     @include('backend.layout.sidebar')
    <!-- sl-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    @include('backend.layout.header')
    <!-- sl-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: RIGHT PANEL ########## -->
        @include('backend.layout.sideRight')
<!-- sl-sideright -->
    <!-- ########## END: RIGHT PANEL ########## --->

    <!-- ########## START: MAIN PANEL ########## -->
   @yield('content')
    <!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

    <script src="{{asset('/backend/lib/jquery/jquery.js')}}"></script>
    <script src="{{asset('/backend/lib/popper.js/popper.js')}}"></script>
    <script src="{{asset('/backend/lib/bootstrap/bootstrap.js')}}"></script>
    <script src="{{asset('/backend/lib/jquery-ui/jquery-ui.js')}}"></script>
    <script src="{{asset('/backend/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js')}}"></script>
    <script src="{{asset('/backend/lib/jquery.sparkline.bower/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('/backend/lib/d3/d3.js')}}"></script>
    <script src="{{asset('/backend/lib/rickshaw/rickshaw.min.js')}}"></script>
    <script src="{{asset('/backend/lib/chart.js/Chart.js')}}"></script>
    <script src="{{asset('/backend/lib/Flot/jquery.flot.js')}}"></script>
    <script src="{{asset('/backend/lib/Flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('/backend/lib/Flot/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('/backend/lib/flot-spline/jquery.flot.spline.js')}}"></script>

    <script src="{{asset('/backend/js/starlight.js')}}"></script>
    <script src="{{asset('/backend/js/ResizeSensor.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
function dismissToast() {
    const toast = document.getElementById('flashToast');
    if (!toast) return;
    toast.style.animation = 'toast-out 0.3s ease-in forwards';
    setTimeout(() => toast.remove(), 300);
}

document.addEventListener('DOMContentLoaded', function () {
    setTimeout(dismissToast, 3000);
});
</script>
    @yield('js')
  </body>
</html>
