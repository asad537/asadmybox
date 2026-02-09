<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - CRM Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --text-dark: #111827;
            --text-gray: #6b7280;
            --border: #e5e7eb;
            --bg-gray: #f9fafb;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            overflow: hidden;
            background: white;
        }

        /* Left Split - Visual */
        .login-visual {
            flex: 1.2;
            background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem;
            color: white;
            overflow: hidden;
        }

        /* Abstract Patterns */
        .pattern-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
        }
        .c1 { width: 400px; height: 400px; top: -100px; right: -100px; }
        .c2 { width: 300px; height: 300px; bottom: 50px; left: -50px; }
        .c3 { width: 150px; height: 150px; top: 30%; right: 20%; background: rgba(255,255,255,0.05); }

        .visual-content {
            position: relative;
            z-index: 1;
            max-width: 500px;
        }

        .visual-logo {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .visual-logo i { background: rgba(255,255,255,0.2); padding: 0.5rem; border-radius: 8px; }

        .visual-heading {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
        }

        .visual-text {
            font-size: 1.1rem;
            line-height: 1.6;
            opacity: 0.9;
        }

        /* Right Split - Form */
        .login-form-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: white;
        }

        .login-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .form-header {
            margin-bottom: 2.5rem;
        }

        .form-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .form-sub {
            color: var(--text-gray);
            font-size: 0.95rem;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            font-size: 0.9rem;
            color: #374151;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 0.85rem 1rem 0.85rem 2.8rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.2s;
            outline: none;
            color: var(--text-dark);
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .btn-primary {
            width: 100%;
            padding: 0.85rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 1rem;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fee2e2;
            color: #991b1b;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .copyright {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.85rem;
            color: #9ca3af;
        }

        /* Responsive */
        @media (max-width: 900px) {
            body { flex-direction: column; height: auto; min-height: 100vh; }
            .login-visual { min-height: 300px; padding: 2rem; flex: none; }
            .visual-heading { font-size: 2rem; }
            .login-form-container { padding: 2rem; flex: 1; }
        }
    </style>
</head>
<body>

    <!-- Left Side: Visual -->
    <div class="login-visual">
        <div class="pattern-circle c1"></div>
        <div class="pattern-circle c2"></div>
        <div class="pattern-circle c3"></div>
        
        <div class="visual-content">
            <div class="visual-logo">
                <img src="{{ asset('images/mybox.png') }}?v={{ time() }}" alt="MyBox Printing" style="max-height: 120px; max-width: 100%; object-fit: contain;">
            </div>
            <h1 class="visual-heading">Manage your customers efficiently.</h1>
            <p class="visual-text">Access your dashboard to track leads, manage emails, and update logs in real-time. Secure and streamlined for your sales team.</p>
        </div>
    </div>

    <!-- Right Side: Login Form -->
    <div class="login-form-container">
        <div class="login-wrapper">
            <div class="form-header">
                <h2 class="form-title">Welcome back</h2>
                <p class="form-sub">Please enter your details to sign in.</p>
            </div>

            @if(session('error') || $errors->any())
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') ?? $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('crm.login') }}" method="POST">
                {{ csrf_field() }}
                
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-size: 0.9rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; color: #4b5563; cursor: pointer;">
                        <input type="checkbox" name="remember" style="accent-color: var(--primary);"> Remember me
                    </label>
                </div>

                <button type="submit" class="btn-primary">Sign in</button>
            </form>

            <div class="copyright">
                &copy; {{ date('Y') }} MyBox Inc. All rights reserved.
            </div>
        </div>
    </div>

</body>
</html>
