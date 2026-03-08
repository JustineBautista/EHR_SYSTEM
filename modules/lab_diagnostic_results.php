<?php
$page_title = "Lab & Diagnostic Results";
require_once __DIR__ . '/../includes/init.php';
include "../includes/db.php";

if (!isset($_SESSION['admin'])) {
    header("Location: ../pages/index.php");
    exit();
}

include "../includes/header.php";

$search_query = isset($_GET['search_query']) ? trim($_GET['search_query']) : '';

$patient = null;
$lab_results = null;
$diag_results = null;

if ($search_query !== '') {
    // Determine if search query is numeric (patient ID) or string (patient name)
    if (ctype_digit($search_query)) {
        // Search by patient ID
        $patient_id = intval($search_query);
        $patient_stmt = $conn->prepare("SELECT id, fullname, dob, gender, contact, address FROM patients WHERE id=?");
        $patient_stmt->bind_param("i", $patient_id);
    } else {
        // Search by patient name (partial match)
        $like_query = "%".$search_query."%";
        $patient_stmt = $conn->prepare("SELECT id, fullname, dob, gender, contact, address FROM patients WHERE fullname LIKE ? LIMIT 1");
        $patient_stmt->bind_param("s", $like_query);
    }
    $patient_stmt->execute();
    $patient_result = $patient_stmt->get_result();
    $patient = $patient_result->fetch_assoc();
    $patient_stmt->close();

    if (!$patient) {
        // Patient not found
        $patient_not_found = true;
    } else {
        $patient_id = $patient['id'];

        // Fetch lab results
        $lab_sql = "SELECT test_name, test_result, date_taken FROM lab_results WHERE patient_id=? ORDER BY date_taken DESC";
        $lab_stmt = $conn->prepare($lab_sql);
        $lab_stmt->bind_param("i", $patient_id);
        $lab_stmt->execute();
        $lab_results = $lab_stmt->get_result();
        $lab_stmt->close();

        // Fetch diagnostics (based on current table schema)
        $diag_sql = "SELECT study_type, study_description, impression_conclusion, date_diagnosed FROM diagnostics WHERE patient_id=? ORDER BY date_diagnosed DESC";
        $diag_stmt = $conn->prepare($diag_sql);
        $diag_stmt->bind_param("i", $patient_id);
        $diag_stmt->execute();
        $diag_results = $diag_stmt->get_result();
        $diag_stmt->close();
    }
}
?>

<div class="app-surface p-3 p-md-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <div class="h4 fw-bold mb-0">
                <i class="bi bi-clipboard2-pulse me-2 text-success"></i>Laboratory & Diagnostic Results
            </div>
            <div class="text-muted">Search a patient to view lab and diagnostic history.</div>
        </div>
    </div>

    <div class="card p-3 mb-3">
        <form method="get" class="row g-2">
            <div class="col-md-6 d-flex align-items-center">
                    <label for="search_query" class="form-label fw-bold me-2 mb-0 flex-shrink-0">Search Patient by ID or Name: </label>
                    <input type="text" id="search_query" name="search_query" class="form-control me-2" placeholder="Enter patient ID or name" value="<?= htmlspecialchars($search_query); ?>" autocomplete="off" required />
                
                <button type="submit" class="btn btn-primary btn-search" aria-label="Search">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>

    <?php if ($search_query === ''): ?>
        <div class="alert alert-info">Please search for a patient to view their results.</div>
    <?php elseif (isset($patient_not_found) && $patient_not_found): ?>
        <div class="alert alert-danger">The patient does not exist!</div>
    <?php else: ?>
        <!-- Patient Info -->
        <div class="card p-3 mb-3">
            <h6 class="fw-bold text-success mb-3">Patient Details</h6>
            <div class="row">
                <div class="col-md-6"><strong>Name:</strong> <?= htmlspecialchars($patient['fullname']); ?></div>
                <div class="col-md-6"><strong>Gender:</strong> <?= htmlspecialchars($patient['gender'] ?? ''); ?></div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6"><strong>Date of Birth:</strong> <?= htmlspecialchars($patient['dob']); ?></div>
                <div class="col-md-6"><strong>Contact:</strong> <?= htmlspecialchars($patient['contact'] ?? ''); ?></div>
            </div>
            <div class="row mt-2">
                <div class="col-12"><strong>Address:</strong> <?= htmlspecialchars($patient['address']); ?></div>
            </div>
        </div>

        <div class="row">
            <!-- Lab Results -->
            <div class="col-md-6">
                <div class="card p-3">
                    <h6 class="fw-bold text-success mb-3">
                        <i class="bi bi-flask me-2"></i> Lab Results
                    </h6>
                    <?php if ($lab_results->num_rows > 0): ?>
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Test Name</th>
                                    <th>Result</th>
                                    <th>Date Taken</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $lab_results->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['test_name']); ?></td>
                                    <td><?= htmlspecialchars($row['test_result']); ?></td>
                                    <td><?= htmlspecialchars($row['date_taken']); ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="text-muted">No lab results found.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Diagnostic Results -->
            <div class="col-md-6">
                <div class="card p-3">
                    <h6 class="fw-bold text-success mb-3">
                        <i class="bi bi-activity me-2"></i> Diagnostics
                    </h6>
                    <?php if ($diag_results->num_rows > 0): ?>
                        <?php while ($diag = $diag_results->fetch_assoc()): ?>
                            <div class="border-bottom pb-2 mb-2">
                                <div class="fw-bold text-success"><?= htmlspecialchars($diag['date_diagnosed'] ?? ''); ?></div>
                                <div><strong>Study type:</strong> <?= htmlspecialchars($diag['study_type'] ?? ''); ?></div>
                                <div><strong>Description:</strong> <?= nl2br(htmlspecialchars($diag['study_description'] ?? '')); ?></div>
                                <div><strong>Impression / Conclusion:</strong> <?= nl2br(htmlspecialchars($diag['impression_conclusion'] ?? '')); ?></div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-muted">No diagnostic results found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include "../includes/footer.php"; ?>
