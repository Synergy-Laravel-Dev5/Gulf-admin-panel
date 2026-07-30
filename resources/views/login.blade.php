<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In | GULF HAJJ</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --teal: #0d7a8a;
            --teal-dark: #095f6d;
            --teal-mid: #1a9aad;
            --teal-light: #e0f4f7;
            --orange: #f07c1c;
            --orange-dark: #d4690f;
            --orange-light: #fff0e0;
            --dark: #07222b;
            --dark2: #0d2f3a;
            --text: #243e46;
            --muted: #5f8a95;
            --border: #c8dde3;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--dark);
        }

        .ep-login-wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 20px;
        }

        .ep-login-wrap::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 80% 60% at 70% 40%, rgba(13, 122, 138, 0.22) 0%, transparent 70%),
                radial-gradient(ellipse 50% 40% at 20% 80%, rgba(240, 124, 28, 0.10) 0%, transparent 60%);
        }

        .ep-login-wrap::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.06) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        .ep-card {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 20px;
            padding: 44px 38px 36px;
            box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.06), 0 24px 70px rgba(0, 0, 0, 0.45), 0 8px 24px rgba(13, 122, 138, 0.25);
        }

        .ep-logo {
            text-align: center;
            margin-bottom: 22px;
        }

        .ep-logo img {
            height: 62px;
            width: auto;
        }

        .ep-title {
            text-align: center;
            margin-bottom: 28px;
        }

        .ep-title h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 22px;
            font-weight: 800;
            color: var(--dark);
            margin: 0 0 6px;
        }

        .ep-title p {
            font-size: 13.5px;
            color: var(--muted);
            margin: 0;
        }

        .ep-alert {
            background: #fdeaea;
            border: 1px solid #f3b9b9;
            color: #b42318;
            font-size: 13px;
            padding: 10px 14px;
            border-radius: 10px;
            margin-bottom: 18px;
        }

        .ep-group {
            margin-bottom: 18px;
        }

        .ep-group label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 7px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .ep-input-wrap {
            position: relative;
        }

        .ep-input-wrap .ep-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 15px;
            pointer-events: none;
        }

        .ep-group input {
            width: 100%;
            padding: 12px 16px 12px 40px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            color: var(--dark);
            background: #f4f8fa;
            outline: none;
            transition: all 0.2s;
        }

        .ep-group input:focus {
            border-color: var(--teal);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(13, 122, 138, 0.10);
        }

        .ep-group .ep-error {
            color: #d4690f;
            font-size: 12px;
            margin-top: 6px;
        }

        .ep-toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            font-size: 14px;
            padding: 0;
        }

        .ep-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .ep-remember {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text);
        }

        .ep-remember input {
            width: 16px;
            height: 16px;
            accent-color: var(--teal);
            cursor: pointer;
        }

        .ep-forgot {
            font-size: 13px;
            color: var(--teal);
            text-decoration: none;
            font-weight: 600;
        }

        .ep-forgot:hover {
            text-decoration: underline;
        }

        .ep-submit {
            width: 100%;
            background: linear-gradient(135deg, var(--orange), #e8680a);
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: 12px;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 6px 22px rgba(240, 124, 28, 0.35);
        }

        .ep-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(240, 124, 28, 0.45);
        }

        .ep-footer {
            text-align: center;
            margin-top: 26px;
            font-size: 12.5px;
            color: var(--muted);
        }
    </style>
</head>

<body>

    <div class="ep-login-wrap">
        <div class="ep-card">

            <div class="ep-logo">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('assets/images/logo1.png') }}" alt="GULF Logo"
                        style="height: 100px; width: auto;">
                </a>
            </div>

            <div class="ep-title">
                <h3>Welcome back</h3>
                <p> GULF HAJJ & UMRAH SERVICES.</p>
            </div>

            @if (session('success'))
                <div class="ep-alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="ep-alert">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="ep-alert">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="ep-group">
                    <label for="email">Email address</label>
                    <div class="ep-input-wrap">
                        <span class="ep-icon">✉</span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="you@school.edu.pk" required autofocus>
                    </div>
                    @error('email')
                        <div class="ep-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="ep-group">
                    <label for="password">Password</label>
                    <div class="ep-input-wrap">
                        <span class="ep-icon">🔒</span>
                        <input type="password" id="password" name="password" placeholder="Enter your password"
                            required>
                        <button type="button" class="ep-toggle-pw" onclick="epTogglePassword()">👁</button>
                    </div>
                    @error('password')
                        <div class="ep-error">{{ $message }}</div>
                    @enderror
                </div>


                <button type="submit" class="ep-submit">Log In</button>
            </form>

            <div class="ep-footer">
                &copy; {{ date('Y') }} GULF HAJJ & UMRAH SERVICES. All Rights Reserved.
            </div>

        </div>
    </div>

    <script>
        function epTogglePassword() {
            const pw = document.getElementById('password');
            pw.type = pw.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>

</html>
