<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - D-Asset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        body { background-color: #0d1117; color: #c9d1d9; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .login-card { background-color: #161b22; border: 1px solid #30363d; border-radius: 6px; width: 100%; max-width: 350px; padding: 20px; box-shadow: 0 8px 24px rgba(0,0,0,0.2); }
        .form-control { background-color: #0d1117; border: 1px solid #30363d; color: #c9d1d9; }
        .form-control:focus { background-color: #0d1117; border-color: #58a6ff; color: #c9d1d9; box-shadow: none; }
        .btn-login { background-color: #238636; color: #fff; font-weight: 500; width: 100%; border: none; }
        .btn-login:hover { background-color: #2ea043; color: #fff; }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="text-center mb-4">
            <i class="ti ti-box" style="font-size: 3rem; color: #e3b341;"></i>
            <h4 class="mt-2" style="font-weight: 600;">Login ke D-Asset</h4>
        </div>

        @if($errors->any())
        <div class="p-2 mb-3 rounded" style="background:#3a1a1a; border:1px solid #da3633; font-size:.82rem; color:#f85149;">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label" style="font-size:.85rem;">Email address</label>
                <input type="email" name="email" class="form-control form-control-sm" required autofocus value="{{ old('email') }}">
            </div>
            <div class="mb-4">
                <label class="form-label" style="font-size:.85rem;">Password</label>
                <input type="password" name="password" class="form-control form-control-sm" required>
            </div>
            <button type="submit" class="btn btn-sm btn-login py-2">Sign in</button>
        </form>
    </div>

</body>
</html>