<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Login - Badan Bank Tanah</title>

    <!-- Google Fonts - Load lebih cepat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome - Load dari CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* =========================================================
           RESET & BASE - Ringan
        ========================================================= */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            background: #f0fdf4;
            min-height: 100vh;
        }

        /* =========================================================
           BACKGROUND - Sederhana, Tanpa Animasi Berat
        ========================================================= */
        .bg-container {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        .bg-gradient-base {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 50%, #fef3c7 100%);
        }

        /* =========================================================
           LOGIN WRAPPER
        ========================================================= */
        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 400px;
            animation: fadeUp 0.3s ease forwards;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* =========================================================
           LOGO
        ========================================================= */
        .login-header {
            text-align: center;
            margin-bottom: 24px;
        }

        .login-header .logo-wrap img {
            height: 64px;
            width: auto;
            object-fit: contain;
        }

        .login-header .title {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin-top: 8px;
        }

        .login-header .subtitle {
            font-size: 13px;
            color: #64748b;
            margin-top: 2px;
        }

        .login-header .divider-line {
            width: 36px;
            height: 3px;
            background: #16a34a;
            border-radius: 10px;
            margin: 10px auto 0;
        }

        /* =========================================================
           LOGIN CARD
        ========================================================= */
        .login-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 16px;
            padding: 28px 24px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        }

        /* =========================================================
           FORM
        ========================================================= */
        .form-group {
            margin-bottom: 14px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .form-group .input-wrap {
            position: relative;
        }

        .form-group .input-wrap .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 13px;
            pointer-events: none;
        }

        .form-group .input-wrap input {
            width: 100%;
            padding: 10px 12px 10px 38px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 13px;
            color: #0f172a;
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.15s ease;
            font-family: 'Inter', sans-serif;
        }

        .form-group .input-wrap input:focus {
            border-color: #22c55e;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.08);
            outline: none;
        }

        .form-group .input-wrap input::placeholder {
            color: #94a3b8;
            font-weight: 400;
            font-size: 12px;
        }

        .form-group .input-wrap .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            font-size: 13px;
            padding: 4px;
            transition: color 0.15s ease;
        }

        .form-group .input-wrap .toggle-password:hover {
            color: #475569;
        }

        .form-error {
            font-size: 11px;
            color: #ef4444;
            margin-top: 3px;
            display: block;
        }

        /* =========================================================
           FORM FOOTER
        ========================================================= */
        .form-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 4px;
            margin-bottom: 18px;
            flex-wrap: wrap;
            gap: 4px;
        }

        .form-footer .remember-me {
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            font-size: 12px;
            color: #475569;
        }

        .form-footer .remember-me input[type="checkbox"] {
            width: 14px;
            height: 14px;
            accent-color: #16a34a;
            cursor: pointer;
        }

        .form-footer .forgot-link {
            font-size: 12px;
            color: #16a34a;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .form-footer .forgot-link:hover {
            color: #15803d;
            text-decoration: underline;
        }

        /* =========================================================
           SUBMIT BUTTON
        ========================================================= */
        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #16a34a;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
        }

        .btn-submit:hover {
            background: #15803d;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(22, 163, 74, 0.25);
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        /* =========================================================
           ALERT
        ========================================================= */
        .alert {
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 12px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-bottom: 16px;
            border: 1px solid;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.08);
            border-color: rgba(34, 197, 94, 0.15);
            color: #166534;
        }

        .alert-success i {
            color: #22c55e;
            font-size: 13px;
            margin-top: 1px;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.06);
            border-color: rgba(239, 68, 68, 0.12);
            color: #991b1b;
        }

        .alert-error i {
            color: #ef4444;
            font-size: 13px;
            margin-top: 1px;
        }

        .alert-error .alert-title {
            font-weight: 600;
        }

        .alert-error .alert-message {
            font-size: 11px;
            opacity: 0.85;
        }

        /* =========================================================
           DIVIDER
        ========================================================= */
        .divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 18px 0 14px;
        }

        .divider .line {
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .divider .text {
            font-size: 9px;
            color: #94a3b8;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* =========================================================
           FOOTER
        ========================================================= */
        .login-footer {
            text-align: center;
            margin-top: 10px;
        }

        .login-footer p {
            font-size: 11px;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .login-footer p i {
            color: #16a34a;
            opacity: 0.6;
            font-size: 11px;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */
        @media (max-width: 480px) {
            body {
                padding: 12px;
            }

            .login-card {
                padding: 20px 16px;
                border-radius: 14px;
            }

            .login-header .logo-wrap img {
                height: 50px;
            }

            .login-header .title {
                font-size: 17px;
            }

            .login-header .subtitle {
                font-size: 12px;
            }

            .form-group .input-wrap input {
                padding: 9px 10px 9px 34px;
                font-size: 12px;
            }

            .btn-submit {
                padding: 11px;
                font-size: 12px;
            }
        }

        @media (max-height: 650px) {
            body {
                padding: 10px;
            }

            .login-header .logo-wrap img {
                height: 40px;
            }

            .login-header .title {
                font-size: 16px;
                margin-top: 4px;
            }

            .login-header .subtitle {
                font-size: 11px;
            }

            .login-header {
                margin-bottom: 16px;
            }

            .login-card {
                padding: 16px 14px;
            }

            .form-group {
                margin-bottom: 10px;
            }

            .form-group .input-wrap input {
                padding: 8px 10px 8px 34px;
                font-size: 12px;
            }

            .form-footer {
                margin-bottom: 12px;
            }

            .btn-submit {
                padding: 9px;
                font-size: 12px;
            }

            .alert {
                padding: 6px 10px;
                font-size: 11px;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- Background Sederhana -->
    <div class="bg-container">
        <div class="bg-gradient-base"></div>
    </div>

    <!-- ========================================================= -->
    <!-- LOGIN FORM -->
    <!-- ========================================================= -->
    <div class="login-wrapper">

        <!-- Header -->
        <div class="login-header">
            <div class="logo-wrap">
                <img src="<?php echo e(asset('images/Logo-badan-bank-tanah.png')); ?>" alt="Badan Bank Tanah">
            </div>
            <h2 class="title">Admin Panel</h2>
            <p class="subtitle">Masuk ke dashboard administrator</p>
            <div class="divider-line"></div>
        </div>

        <!-- Card -->
        <div class="login-card">

            <!-- Session Status -->
            <?php if(session('status')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span><?php echo e(session('status')); ?></span>
                </div>
            <?php endif; ?>

            <!-- Error -->
            <?php if($errors->any()): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <div class="alert-title">Login gagal</div>
                        <div class="alert-message"><?php echo e($errors->first()); ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Form -->
            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <div class="input-wrap">
                        <span class="input-icon"><i class="fas fa-envelope"></i></span>
                        <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" 
                            required autofocus placeholder="admin@banktanah.go.id">
                    </div>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="form-error"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-wrap">
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <input id="password" type="password" name="password" required 
                            placeholder="Masukkan kata sandi Anda">
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <i id="passwordToggleIcon" class="fas fa-eye"></i>
                        </button>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="form-error"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Footer -->
                <div class="form-footer">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" id="remember">
                        <span>Ingat saya</span>
                    </label>

                    <?php if(Route::has('password.request')): ?>
                        <a href="<?php echo e(route('password.request')); ?>" class="forgot-link">
                            Lupa kata sandi?
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit">
                    <i class="fas fa-sign-in-alt"></i>
                    Masuk ke Dashboard
                </button>

                <!-- Divider -->
                <div class="divider">
                    <span class="line"></span>
                    <span class="text">Akses Terbatas</span>
                    <span class="line"></span>
                </div>

                <!-- Footer -->
                <div class="login-footer">
                    <p>
                        <i class="fas fa-shield-alt"></i>
                        Hanya untuk administrator yang memiliki akses
                    </p>
                </div>

            </form>

        </div>

    </div>

    <!-- ========================================================= -->
    <!-- SCRIPTS -->
    <!-- ========================================================= -->
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('passwordToggleIcon');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('email')?.focus();
        });
    </script>

</body>
</html><?php /**PATH C:\Users\Lenovo\badan-tanah-ui-new\resources\views/auth/login.blade.php ENDPATH**/ ?>