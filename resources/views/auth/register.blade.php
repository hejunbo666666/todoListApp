<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .auth-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            padding: 2.5rem;
            max-width: 400px;
            width: 100%;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            font-size: 0.875rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-error {
            margin-top: 0.25rem;
            font-size: 0.75rem;
            color: #ef4444;
        }

        .btn {
            width: 100%;
            padding: 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: white;
            background-color: #6366f1;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn:hover {
            background-color: #4f46e5;
        }

        .auth-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
        }

        .auth-link a {
            color: #6366f1;
            text-decoration: none;
        }

        .auth-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h1 class="auth-title">Register</h1>
        </div>
        <form method="POST" action="/register">
            @csrf
            <div class="form-group">
                <label class="form-label" for="name">Name</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required>
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-input" required minlength="8">
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Register</button>
            </div>
            <div class="auth-link">
                <a href="/login">Already have an account? Log in now</a>
            </div>
        </form>
    </div>
</body>
</html>