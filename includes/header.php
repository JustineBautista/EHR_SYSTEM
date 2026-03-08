<?php
require_once __DIR__ . '/init.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../pages/index.php");
    exit();
}

require_once __DIR__ . '/db.php';

$page_title = $page_title ?? 'EHR System';
$current_page = basename($_SERVER['PHP_SELF'] ?? '');

if (!function_exists('ehr_nav_active')) {
    function ehr_nav_active(string $current_page, array $names): string
    {
        return in_array($current_page, $names, true) ? ' active' : '';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/IMAGES/aurora.png" type="image/png">
    <title><?php echo htmlspecialchars($page_title); ?> | AURORA</title>
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/vendor/bootstrap/icons/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/app.css">
</head>
<body class="ehr-body">
    <nav class="navbar ehr-navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../pages/dashboard.php" aria-label="AURORA Dashboard">
                <img src="../assets/IMAGES/aurora.png" width="auto" height="70px" class="d-inline-block align-text-top me-2" alt="EHR Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link<?php echo ehr_nav_active($current_page, ['dashboard.php']); ?>" href="../pages/dashboard.php"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php echo ehr_nav_active($current_page, ['patients.php', 'patient_dashboard.php']); ?>" href="../modules/patients.php"><i class="bi bi-people-fill me-1"></i>Patients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php echo ehr_nav_active($current_page, ['medical_summary.php']); ?>" href="../modules/medical_summary.php"><i class="bi bi-clipboard-data me-1"></i>Medical Summary</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php echo ehr_nav_active($current_page, ['aboutus.php']); ?>" href="../pages/aboutus.php"><i class="bi bi-info-circle me-1"></i>About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php echo ehr_nav_active($current_page, ['services.php']); ?>" href="../modules/services.php"><i class="bi bi-capsule me-1"></i>Services</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i><?php echo htmlspecialchars((string)($_SESSION['admin'] ?? 'Admin')); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="../modules/patient_history_logs.php"><i class="bi bi-clock-history me-1"></i>Patient History Logs</a></li>
                            <li><a class="dropdown-item" href="../pages/logout.php"><i class="bi bi-box-arrow-right me-1"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container-xxl app-shell">
        <div class="py-3">
            <!-- Page content will go here -->