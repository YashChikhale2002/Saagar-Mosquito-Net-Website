<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__) . '/include/config.php';

if (!empty($_SESSION['admin_id'])) {
    header('Location: ' . SITE_URL . '/admin/index.php');
    exit;
}

function generateCaptcha(): array {
    $a   = rand(2, 19);
    $b   = rand(1, 15);
    $ops = ['+', '-', '*'];
    $op  = $ops[array_rand($ops)];
    switch ($op) {
        case '+': $ans = $a + $b; break;
        case '-': $ans = $a - $b; break;
        case '*': $ans = $a * $b; break;
        default:  $ans = $a + $b;
    }
    return ['a' => $a, 'b' => $b, 'op' => $op, 'answer' => $ans];
}

if (empty($_SESSION['captcha'])) {
    $_SESSION['captcha'] = generateCaptcha();
}

$error        = '';
$show2fa      = false;
$captchaError = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $formStep = $_POST['form_step'] ?? 'credentials';

    if ($formStep === 'credentials') {
        $email    = trim($_POST['email']    ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            $error = 'Email and password are required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email address.';
        } else {
            $stmt = $conn->prepare('SELECT id, name, email, password, role, status, two_fa_enabled FROM admin_users WHERE email = ? LIMIT 1');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $admin = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if (!$admin || !password_verify($password, $admin['password'])) {
                $error = 'Invalid email or password. Please check and try again.';
                $_SESSION['captcha'] = generateCaptcha();
            } elseif (!(int)$admin['status']) {
                $error = 'Your account has been deactivated. Contact a super admin.';
            } elseif ((int)$admin['two_fa_enabled']) {
                $_SESSION['pending_admin_id'] = (int)$admin['id'];
                $_SESSION['captcha']          = generateCaptcha();
                $show2fa = true;
            } else {
                session_regenerate_id(true);
                $_SESSION['admin_id']    = $admin['id'];
                $_SESSION['admin_name']  = $admin['name'];
                $_SESSION['admin_email'] = $admin['email'];
                $_SESSION['admin_role']  = $admin['role'];

                $ip = $conn->real_escape_string($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
                $conn->query("UPDATE admin_users SET last_login = NOW(), last_login_ip = '$ip', login_count = login_count + 1 WHERE id = {$admin['id']}");
                $conn->query("INSERT INTO admin_activity_log (user_id, action, detail, ip, created_at) VALUES ({$admin['id']}, 'login', 'Standard login', '$ip', NOW())");

                session_write_close();
                header('Location: ' . SITE_URL . '/admin/index.php');
                exit;
            }
        }

    } elseif ($formStep === 'captcha') {
        if (empty($_SESSION['pending_admin_id'])) {
            $error = 'Session expired. Please log in again.';
            unset($_SESSION['captcha']);
        } else {
            $captchaAnswer = trim($_POST['captcha_answer'] ?? '');

            if ($captchaAnswer === '') {
                $error   = 'Please enter the answer to the security question.';
                $show2fa = true;
            } elseif ((int)$captchaAnswer !== (int)($_SESSION['captcha']['answer'] ?? PHP_INT_MAX)) {
                $error        = 'Incorrect answer. A new question has been generated.';
                $captchaError = true;
                $show2fa      = true;
                $_SESSION['captcha'] = generateCaptcha();
            } else {
                $pendingId = (int)$_SESSION['pending_admin_id'];
                $stmt = $conn->prepare('SELECT id, name, email, role, status FROM admin_users WHERE id = ? AND status = 1 LIMIT 1');
                $stmt->bind_param('i', $pendingId);
                $stmt->execute();
                $admin = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                if (!$admin) {
                    $error = 'Account not found or deactivated.';
                    unset($_SESSION['pending_admin_id'], $_SESSION['captcha']);
                } else {
                    unset($_SESSION['pending_admin_id'], $_SESSION['captcha']);
                    session_regenerate_id(true);
                    $_SESSION['admin_id']    = $admin['id'];
                    $_SESSION['admin_name']  = $admin['name'];
                    $_SESSION['admin_email'] = $admin['email'];
                    $_SESSION['admin_role']  = $admin['role'];

                    $ip = $conn->real_escape_string($_SERVER['REMOTE_ADDR'] ?? '0.0.0.0');
                    $conn->query("UPDATE admin_users SET last_login = NOW(), last_login_ip = '$ip', login_count = login_count + 1 WHERE id = {$admin['id']}");
                    $conn->query("INSERT INTO admin_activity_log (user_id, action, detail, ip, created_at) VALUES ({$admin['id']}, 'login', 'Login with 2FA captcha', '$ip', NOW())");

                    session_write_close();
                    header('Location: ' . SITE_URL . '/admin/index.php');
                    exit;
                }
            }
        }
    }
}

if (!empty($_SESSION['pending_admin_id'])) {
    $show2fa = true;
}

$captcha   = $_SESSION['captcha'] ?? generateCaptcha();
$opDisplay = ['+' => '+', '-' => '−', '*' => '×'];
$opSym     = $opDisplay[$captcha['op']] ?? $captcha['op'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login – Niraj Industries</title>
    <link rel="stylesheet" href="<?= SITE_URL ?>/admin/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/admin/assets/plugins/fontawesome/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            background: #f5f5f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        /* ── Page background pattern ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                radial-gradient(circle at 20% 20%, rgba(245,197,24,.18) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(245,197,24,.12) 0%, transparent 50%);
            z-index: 0;
        }

        .login-wrapper {
            position: relative;
            z-index: 1;
            display: flex;
            width: 900px;
            max-width: 96vw;
            min-height: 540px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,.12), 0 4px 16px rgba(0,0,0,.08);
        }

        /* ── LEFT SIDEBAR ── */
        .login-sidebar {
            background: #1a1a1a;
            color: #fff;
            width: 300px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 44px 28px;
            position: relative;
            overflow: hidden;
        }

        .login-sidebar::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(245,197,24,.08);
        }

        .login-sidebar::after {
            content: '';
            position: absolute;
            bottom: -40px; left: -40px;
            width: 160px; height: 160px;
            border-radius: 50%;
            background: rgba(245,197,24,.06);
        }

        .brand-logo {
            width: 76px; height: 76px;
            border-radius: 20px;
            background: #f5c518;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: #1a1a1a;
            margin-bottom: 18px;
            position: relative;
            z-index: 1;
        }

        .brand-name {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0 0 4px;
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .brand-sub {
            font-size: .78rem;
            color: #9ca3af;
            margin-bottom: 32px;
            position: relative;
            z-index: 1;
            text-align: center;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .feat {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 8px;
            width: 100%;
            font-size: .82rem;
            color: #d1d5db;
            position: relative;
            z-index: 1;
        }

        .feat-dot {
            width: 28px; height: 28px;
            border-radius: 8px;
            background: #f5c518;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a1a1a;
            font-size: .75rem;
            flex-shrink: 0;
        }

        .year-badge {
            position: absolute;
            bottom: 28px;
            font-size: .68rem;
            color: #6b7280;
            z-index: 1;
            letter-spacing: .06em;
        }

        /* ── RIGHT MAIN ── */
        .login-main {
            background: #ffffff;
            flex: 1;
            padding: 52px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* ── Steps ── */
        .steps { display: flex; align-items: flex-start; margin-bottom: 36px; }
        .step  { display: flex; flex-direction: column; align-items: center; }

        .step-circle {
            width: 36px; height: 36px;
            border-radius: 50%;
            border: 2px solid #e5e7eb;
            color: #9ca3af;
            display: flex; align-items: center; justify-content: center;
            font-size: .82rem; font-weight: 700;
            background: #fff;
            transition: all .3s;
        }

        .step-circle.active {
            background: #f5c518;
            border-color: #f5c518;
            color: #1a1a1a;
        }

        .step-circle.done {
            background: #22c55e;
            border-color: #22c55e;
            color: #fff;
        }

        .step-label { font-size: .68rem; color: #9ca3af; margin-top: 5px; letter-spacing: .03em; }
        .step-line  { flex: 1; height: 2px; background: #e5e7eb; margin: 18px 10px 0; transition: background .3s; }
        .step-line.done { background: #22c55e; }

        /* ── Form ── */
        .page-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 4px;
            line-height: 1.2;
        }

        .page-sub {
            font-size: .88rem;
            color: #6b7280;
            margin-bottom: 28px;
        }

        .form-label {
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .08em;
            color: #374151;
            margin-bottom: 6px;
            text-transform: uppercase;
            display: block;
        }

        .input-group-text {
            background: #fafafa;
            border: 1px solid #e5e7eb;
            border-right: none;
            color: #9ca3af;
            padding: 0 14px;
        }

        .form-control {
            border: 1px solid #e5e7eb;
            border-left: none;
            border-radius: 0;
            padding: 11px 14px;
            font-size: .88rem;
            color: #111;
            background: #fafafa;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #f5c518;
            background: #fff;
        }

        .input-group {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .input-group .input-group-text { border: none; }
        .input-group .form-control     { border: none; background: #fafafa; }
        .input-group .form-control:focus { background: #fff; }

        .btn-eye {
            background: #fafafa;
            border: none;
            border-left: 1px solid #e5e7eb;
            color: #9ca3af;
            padding: 0 14px;
        }

        .btn-eye:hover { background: #f0f0f0; color: #374151; }

        .forgot-link {
            font-size: .8rem;
            color: #d4a017;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-link:hover { color: #b8860b; }

        .btn-submit {
            background: #f5c518;
            color: #1a1a1a;
            border: none;
            padding: 13px;
            font-weight: 700;
            font-size: .95rem;
            border-radius: 10px;
            width: 100%;
            cursor: pointer;
            letter-spacing: .02em;
            transition: background .2s, transform .1s;
        }

        .btn-submit:hover  { background: #e6b800; }
        .btn-submit:active { transform: scale(.99); }

        /* ── Captcha ── */
        .captcha-box {
            background: #fffbeb;
            border: 2px dashed #f5c518;
            border-radius: 14px;
            padding: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        .captcha-eq {
            font-size: 2rem;
            font-weight: 800;
            color: #1a1a1a;
            letter-spacing: .12em;
        }

        .captcha-label {
            font-size: .78rem;
            color: #9ca3af;
            margin-bottom: 10px;
        }

        /* ── Error ── */
        .alert-err {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            color: #991b1b;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: .85rem;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-txt {
            text-align: center;
            font-size: .73rem;
            color: #d1d5db;
            margin-top: 32px;
        }

        /* ── Divider ── */
        .ni-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
        }

        .ni-divider::before,
        .ni-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #f0f0f0;
        }

        .ni-divider span {
            font-size: .7rem;
            color: #d1d5db;
            letter-spacing: .05em;
        }

        @media (max-width: 640px) {
            .login-sidebar { display: none; }
            .login-main { padding: 32px 24px; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <!-- ── SIDEBAR ── -->
    <div class="login-sidebar">
        <div class="brand-logo">
            <i class="fas fa-industry"></i>
        </div>
        <h2 class="brand-name">Niraj Industries</h2>
        <p class="brand-sub">Admin Control Panel</p>

        <div class="feat">
            <div class="feat-dot"><i class="fas fa-lock" style="font-size:.7rem;"></i></div>
            256-bit Encrypted
        </div>
        <div class="feat">
            <div class="feat-dot"><i class="fas fa-shield-alt" style="font-size:.7rem;"></i></div>
            2FA Protection
        </div>
        <div class="feat">
            <div class="feat-dot"><i class="fas fa-user-shield" style="font-size:.7rem;"></i></div>
            Role-Based Access
        </div>
        <div class="feat">
            <div class="feat-dot"><i class="fas fa-history" style="font-size:.7rem;"></i></div>
            Activity Logged
        </div>

        <span class="year-badge">&copy; <?= date('Y') ?> Niraj Industries</span>
    </div>

    <!-- ── MAIN ── -->
    <div class="login-main">

        <!-- Steps -->
        <div class="steps">
            <div class="step">
                <div class="step-circle <?= $show2fa ? 'done' : 'active' ?>">
                    <?php if ($show2fa): ?>
                        <i class="fas fa-check" style="font-size:.7rem;"></i>
                    <?php else: ?>1<?php endif; ?>
                </div>
                <div class="step-label">Credentials</div>
            </div>
            <div class="step-line <?= $show2fa ? 'done' : '' ?>"></div>
            <div class="step">
                <div class="step-circle <?= $show2fa ? 'active' : '' ?>">2</div>
                <div class="step-label">Verification</div>
            </div>
        </div>

        <!-- Error -->
        <?php if ($error): ?>
        <div class="alert-err">
            <i class="fas fa-exclamation-circle"></i>
            <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <?php if (!$show2fa): ?>
        <!-- ══ STEP 1 ══ -->
        <div class="page-title">Welcome Back 👋</div>
        <p class="page-sub">Sign in to your admin account</p>

        <form method="POST" action="" autocomplete="off">
            <input type="hidden" name="form_step" value="credentials">

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" class="form-control"
                           placeholder="admin@nirajindustries.com"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                           required autofocus>
                </div>
            </div>

            <div class="mb-2">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="pwdInput"
                           class="form-control" placeholder="Enter your password" required>
                    <button type="button" class="btn-eye" id="togglePwd" tabindex="-1">
                        <i class="fas fa-eye" id="eyeIco"></i>
                    </button>
                </div>
            </div>

            <div class="text-end mb-4">
                <a href="<?= SITE_URL ?>/admin/forgot-password.php" class="forgot-link">
                    <i class="fas fa-key me-1"></i>Forgot Password?
                </a>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-arrow-right me-2"></i>Continue to Dashboard
            </button>
        </form>

        <?php else: ?>
        <!-- ══ STEP 2 ══ -->
        <div class="page-title">Verify It's You 🔐</div>
        <p class="page-sub">Solve the equation to complete sign-in</p>

        <div class="captcha-box">
            <p class="captcha-label">What is the answer to this equation?</p>
            <div class="captcha-eq">
                <?= $captcha['a'] ?> <?= $opSym ?> <?= $captcha['b'] ?> = ?
            </div>
        </div>

        <form method="POST" action="">
            <input type="hidden" name="form_step" value="captcha">

            <div class="mb-4">
                <label class="form-label">Your Answer</label>
                <input type="number" name="captcha_answer"
                       class="form-control rounded-3 <?= $captchaError ? 'is-invalid' : '' ?>"
                       style="border: 1px solid #e5e7eb; border-left: 1px solid #e5e7eb; padding: 11px 14px; font-size:.88rem;"
                       placeholder="Enter the result" autofocus required>
                <?php if ($captchaError): ?>
                <div class="invalid-feedback">Wrong answer — a new question has been generated.</div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-sign-in-alt me-2"></i>Login to Dashboard
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="<?= SITE_URL ?>/admin/login.php" class="forgot-link">
                <i class="fas fa-arrow-left me-1"></i>Back to Login
            </a>
        </div>
        <?php endif; ?>

        <div class="ni-divider"><span>NIRAJ INDUSTRIES</span></div>
        <p class="footer-txt">&copy; <?= date('Y') ?> Niraj Industries. All rights reserved.</p>

    </div>
</div>

<script src="<?= SITE_URL ?>/admin/assets/js/jquery-3.7.1.min.js"></script>
<script src="<?= SITE_URL ?>/admin/assets/js/bootstrap.bundle.min.js"></script>
<script>
    const pwdInput = document.getElementById('pwdInput');
    const eyeIco   = document.getElementById('eyeIco');
    document.getElementById('togglePwd')?.addEventListener('click', function () {
        if (pwdInput.type === 'password') {
            pwdInput.type = 'text';
            eyeIco.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            pwdInput.type = 'password';
            eyeIco.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
</script>
</body>
</html>