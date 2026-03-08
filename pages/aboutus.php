<?php
require_once __DIR__ . '/../includes/init.php';

$page_title = "About Us";
include "../includes/header.php";
?>


<div class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title">AURORA EHR SYSTEM</h1>
        <p class="hero-subtitle">Revolutionizing Healthcare Management with Innovative Technology</p>
        <p class="hero-text">
            AURORA is a comprehensive Electronic Health Records (EHR) system designed to streamline healthcare operations,
            enhance patient care, and empower medical professionals with cutting-edge tools for efficient data management.
        </p>
    </div>
</div>

<div class="features-section">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="section-title">Key Features</h2>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h4>Patient Management</h4>
                    <p>Comprehensive patient profiles with detailed medical histories, demographics, and contact information for personalized care.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                    <h4>Vital Signs Tracking</h4>
                    <p>Real-time monitoring and recording of vital signs, enabling healthcare providers to make informed decisions quickly.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-capsule"></i>
                    </div>
                    <h4>Medication Management</h4>
                    <p>Efficient tracking of prescriptions, dosages, and medication history to ensure safe and effective treatment plans.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-clipboard-data"></i>
                    </div>
                    <h4>Lab Results Integration</h4>
                    <p>Seamless integration of laboratory results and diagnostic reports for comprehensive patient care coordination.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4>Data Security</h4>
                    <p>Advanced security measures including encryption, access controls, and audit trails to protect sensitive patient information.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <h4>Analytics & Reporting</h4>
                    <p>Powerful analytics tools for generating insights, tracking performance metrics, and improving healthcare outcomes.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-format">
    <div class="overlay"></div>
    <div class="mission-section">
        <div class="container">
            <div class="mission-content">
                <h2 class="section-title">Mission</h2>
                <p>Automated Unified Records for Optimized Retrieval and Archiving AURORA's mission is to revolutionize healthcare documentation through seamless record integration, rapid and reliable data retrieval, and uncompromising data security—enabling healthcare professionals to focus on what matters most: delivering quality, compassionate, and efficient care.</p>
            </div>
        </div>
    </div>
    
    <div class="mission-section">
        <div class="container">
            <div class="mission-content">
                <h2 class="section-title">Vision</h2>
                <p>
                To set the standard for next generation electronic health records by delivering a unified, intelligent, and secure platform that drives excellence in healthcare, empowers providers, and enhances patient outcomes.
                </p>
            </div>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
