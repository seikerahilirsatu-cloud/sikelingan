<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <style>
        .login-title{font-size:20px;font-weight:600;color:#2c3e50;text-align:center;margin-bottom:1px}
        .login-subtitle{color:#6c757d;text-align:center;margin-bottom:2px;font-size:14px;line-height:1.5}
        .login-location{color:#6c757d;text-align:center;font-size:13px;margin-top:0;margin-bottom:4px}
        .form-group{margin-bottom:20px}
        .form-control{border:1px solid #e9ecef;border-radius:8px;padding:12px 16px;font-size:14px;background:#f8f9fa;width:100%;box-sizing:border-box}
        .form-control:focus{background:#fff;border:2px solid #007bff;box-shadow:none;outline:0}
        .input-with-icon{position:relative;width:100%}
        .input-icon{position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#6c757d;z-index:10}
        .input-with-icon .form-control{padding-left:45px;padding-right:45px}
        .password-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);color:#6c757d;cursor:pointer;z-index:10;background:transparent;border:0;padding:0;line-height:0}
        .btn-get-started{background:#2c3e50;color:#fff;border:0;border-radius:8px;padding:12px;font-weight:500;width:100%}
        .btn-get-started:hover{background:#1a252f;color:#fff}
    </style>

    <div class="text-center mb-6">
        <img src="{{ asset('images/kelurahan-logo.png') }}" class="h-16 mx-auto" alt="Logo Kelurahan" />
        <div class="login-title">SIKELINGAN</div>
        <div class="login-subtitle">Sistem Informasi Kelurahan dan Lingkungan</div>
        <div class="login-location">Sei Kera Hilir I</div>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <div class="input-with-icon">
                <span class="input-icon" aria-hidden="true">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4V4zm2 4l6 4 6-4"/></svg>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-control" placeholder="Email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <div class="form-group">
            <div class="input-with-icon">
                <span class="input-icon" aria-hidden="true">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17a2 2 0 002-2v-3a2 2 0 10-4 0v3a2 2 0 002 2zm6-8V7a6 6 0 10-12 0v2H4v10h16V9h-2z"/></svg>
                </span>
                <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control" placeholder="Password" />
                <button type="button" id="togglePassword" class="password-toggle" aria-label="Toggle password visibility">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7zm9.542-3a3 3 0 110 6 3 3 0 010-6z"/></svg>
                </button>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn-get-started">Login</button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="mt-4 text-center text-sm text-gray-700">Belum memiliki akun? <a href="{{ route('register') }}" class="text-indigo-600">Daftar disini</a></div>
    @endif

    <script>
    (function(){var b=document.getElementById('togglePassword');var i=document.getElementById('password');if(b&&i){b.addEventListener('click',function(){i.type=i.type==='password'?'text':'password';});}})();
    </script>
</x-guest-layout>
