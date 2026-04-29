<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php($loginRole = request('role', 'admin'))
    @php($loginLabel = [
        'admin' => 'Admin',
        'guru' => 'Guru',
        'siswa' => 'Siswa',
        'pengurus' => 'Pengurus',
    ][$loginRole] ?? 'Admin')
    <title>Login {{ $loginLabel }}</title>
    <link href="{{ asset('template/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: grid;
            place-items: center;
            background: radial-gradient(circle at top right, #22d3ee 0%, transparent 45%),
                        radial-gradient(circle at bottom left, #93c5fd 0%, transparent 35%),
                        #0f172a;
        }
        .login-card {
            width: 100%;
            max-width: 430px;
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 18px 45px rgba(2, 6, 23, 0.45);
        }
    </style>
</head>
<body>
<div class="card login-card">
    <div class="card-body p-4">
        <h3 class="mb-1">Login {{ $loginLabel }}</h3>
        <p class="text-secondary mb-4">Gunakan akun Gmail dan sandi untuk masuk dashboard {{ $loginLabel }}.</p>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.attempt') }}">
            @csrf
            <input type="hidden" name="role" value="{{ $loginRole }}">
            <div class="mb-3">
                <label class="form-label">Email Gmail</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="contoh@gmail.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kata Sandi</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <button class="btn btn-primary w-100" type="submit">Masuk</button>
        </form>
    </div>
</div>
</body>
</html>
