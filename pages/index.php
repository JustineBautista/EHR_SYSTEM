<?php
require_once __DIR__ . '/../includes/init.php';
include "../includes/db.php";

if (isset($_SESSION['admin'])) {
    header("Location: ../pages/dashboard.php");
    exit();
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, password, session_id FROM admin WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $user = $res->fetch_assoc();

        // Check if user is already logged in from another device
        if (!empty($user['session_id']) && $user['session_id'] !== session_id()) {
            $error = "User is currently active on another device.";
        } else {
            // Check if password matches hashed version
            if (password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                // Update session_id to current session
                $update_stmt = $conn->prepare("UPDATE admin SET session_id=? WHERE id=?");
                $update_stmt->bind_param("si", session_id(), $user['id']);
                $update_stmt->execute();
                $update_stmt->close();

                // Set session and redirect
                $_SESSION['admin'] = $username;
                $_SESSION['admin_id'] = $user['id'];
                header("Location: dashboard.php");
                exit();
            } elseif ($password === $user['password']) {
                // Password is in plain text (for backward compatibility), hash it and update
                session_regenerate_id(true);
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $update_stmt = $conn->prepare("UPDATE admin SET password=?, session_id=? WHERE id=?");
                $update_stmt->bind_param("ssi", $hashed_password, session_id(), $user['id']);
                $update_stmt->execute();
                $update_stmt->close();

                // Set session and redirect
                $_SESSION['admin'] = $username;
                $_SESSION['admin_id'] = $user['id'];
                header("Location: ../pages/dashboard.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        }
    } else {
        $error = "Invalid username or password.";
    }
    $stmt->close();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/IMAGES/aurora.png" type="image/png">
    <title>AURORA | Admin Login</title>
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/vendor/bootstrap/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body class="auth-page">
    <div class="container py-5">
        <div class="row align-items-center g-4">
            <div class="col-lg-6 auth-hero">
                <div class="auth-brand mb-4">
                    <img src="../assets/IMAGES/aurora.png" alt="AURORA logo">
                    <div>
                        <div class="fw-bold fs-4 text-white">AURORA</div>
                        <div class="small text-white-50">Electronic Health Records System</div>
                    </div>
                </div>

                <h1 class="display-6 mb-3">Secure admin access</h1>
                <p class="lead mb-4">Manage patients, medical summaries, and services in one place with a cleaner, faster interface.</p>

                <div class="d-flex align-items-center gap-3 mt-4">
                    <img src="../assets/IMAGES/OCT_LOGO.png" alt="Olivarez College Tagaytay" class="partner-logo">
                    <img src="../assets/IMAGES/NURSING_LOGO.png" alt="College of Nursing" class="partner-logo">
                </div>
            </div>

            <div class="col-lg-5 offset-lg-1">
                <div class="auth-card p-4 p-md-5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <div class="h4 fw-bold mb-0">Sign in</div>
                            <div class="text-muted">Admin portal</div>
                        </div>
                        <span class="badge rounded-pill text-bg-primary">Secure</span>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <div><?php echo htmlspecialchars($error); ?></div>
                        </div>
                    <?php endif; ?>

                    <form method="post" class="vstack gap-3" autocomplete="on" novalidate>
                        <div>
                            <label for="username" class="form-label fw-semibold">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required autocomplete="username">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required autocomplete="current-password">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword" aria-label="Toggle password visibility">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                        </button>
                    </form>

                    <hr class="my-4">
                    <div class="small text-muted">
                        Having trouble logging in? Contact the system administrator.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            const btn = document.getElementById('togglePassword');
            const input = document.getElementById('password');
            if (!btn || !input) return;

            btn.addEventListener('click', function () {
                const isHidden = input.getAttribute('type') === 'password';
                input.setAttribute('type', isHidden ? 'text' : 'password');
                const icon = btn.querySelector('i');
                if (icon) icon.className = isHidden ? 'bi bi-eye-slash' : 'bi bi-eye';
            });
        })();
    </script>
</body>
</html>