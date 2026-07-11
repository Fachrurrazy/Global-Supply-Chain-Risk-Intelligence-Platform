<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Global Supply Chain</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            font-family: 'Inter', sans-serif;
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 2.5rem;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }
        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        .btn-primary {
            background: #0d6efd;
            border: none;
            padding: 0.75rem;
            font-weight: 600;
        }
        .btn-primary:hover {
            background: #0b5ed7;
        }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="text-center mb-4">
        <h3 class="fw-bold">Create Account</h3>
        <p class="text-white-50">Join Global Supply Chain Platform</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger p-2 text-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/register">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label text-white-50">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label text-white-50">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label text-white-50">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="form-label text-white-50">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn btn-primary w-100 mb-3">Register</button>
        
        <div class="text-center">
            <span class="text-white-50">Already have an account?</span>
            <a href="/login" class="text-white text-decoration-none fw-bold ms-1">Login here</a>
        </div>
    </form>
</div>

</body>
</html>
