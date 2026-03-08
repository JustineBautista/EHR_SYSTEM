<?php
require_once __DIR__ . '/../includes/init.php';

$page_title = "Our Services";
include "../includes/header.php";
?>

<div class="hero-section services-hero">
    <div class="hero-content">
        <h1 class="hero-title">Our Services</h1>
        <p class="hero-subtitle">Comprehensive Healthcare Solutions Powered by AURORA EHR System</p>
    </div>
</div>

<div class="services-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title">What We Offer</h2>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h3 class="service-title">Patient Care Coordination</h3>
                    <p class="service-description">Streamline patient onboarding with our advanced EHR system that creates comprehensive digital profiles, including medical histories, demographics, allergies, and contact details. Enable personalized care through instant access to patient data, reducing administrative time and improving clinical outcomes.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                    <h3 class="service-title">Vital Signs Monitoring</h3>
                    <p class="service-description">Monitor and record vital signs in real-time with our integrated EHR platform. Track blood pressure, heart rate, temperature, and more with automated alerts for abnormalities. Visualize health trends over time to support proactive care and early intervention strategies.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-capsule"></i>
                    </div>
                    <h3 class="service-title">Medication Oversight</h3>
                    <p class="service-description">Manage medications seamlessly with our EHR system's prescription tracking, dosage monitoring, and comprehensive medication history. Prevent adverse drug interactions through automated checks, ensure accurate dosing, and maintain detailed records for improved patient safety and compliance.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-clipboard-data"></i>
                    </div>
                    <h3 class="service-title">Laboratory Data Integration</h3>
                    <p class="service-description">Integrate lab results and diagnostic reports directly into patient records with our EHR platform. Access test results instantly, compare historical data, and share findings securely with care teams. Accelerate diagnosis and treatment planning through unified, real-time data access.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h3 class="service-title">Data Protection</h3>
                    <p class="service-description">Protect patient data with enterprise-grade security features in our EHR system, including end-to-end encryption, role-based access controls, and comprehensive audit trails. Ensure HIPAA compliance, prevent unauthorized access, and maintain patient trust through robust data protection protocols.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <h3 class="service-title">Analytics and Insights</h3>
                    <p class="service-description">Leverage powerful analytics and reporting tools within our EHR system to generate actionable insights from patient data. Track key performance metrics, identify trends, create custom reports, and drive evidence-based improvements in healthcare delivery and patient outcomes.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
