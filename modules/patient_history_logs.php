<?php
require_once __DIR__ . '/../includes/init.php';
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../pages/index.php");
    exit();
}

$page_title = "Patient History Logs";

// Get filter parameters
$patient_id = $_GET['patient_id'] ?? '';
$action_type = $_GET['action_type'] ?? '';
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';

// Build query dynamically
$query = "SELECT * FROM audit_trail WHERE patient_id IS NOT NULL";
$params = [];
$types = '';

if ($patient_id !== '') {
    $query .= " AND patient_id = ?";
    $params[] = $patient_id;
    $types .= 's';
}

if ($action_type !== '') {
    $query .= " AND action_type = ?";
    $params[] = $action_type;
    $types .= 's';
}

if ($date_from !== '') {
    $query .= " AND action_date >= ?";
    $params[] = $date_from . ' 00:00:00';
    $types .= 's';
}

if ($date_to !== '') {
    $query .= " AND action_date <= ?";
    $params[] = $date_to . ' 23:59:59';
    $types .= 's';
}

$query .= " ORDER BY action_date DESC";

function format_values($json_values): string
{
    if (!$json_values || $json_values === 'null') {
        return 'N/A';
    }
    $values = json_decode($json_values, true);
    if (!$values || !is_array($values)) {
        return htmlspecialchars((string)$json_values);
    }

    $html = '<table class="table table-sm table-borderless mb-0">';
    $count = 0;
    foreach ($values as $key => $val) {
        if ($count % 3 === 0) {
            if ($count > 0) {
                $html .= '</tr>';
            }
            $html .= '<tr>';
        }
        $display_key = ucfirst(str_replace('_', ' ', (string)$key));
        $html .= '<td><strong>' . htmlspecialchars($display_key) . ':</strong> ' . htmlspecialchars((string)($val ?: 'N/A')) . '</td>';
        $count++;
    }
    if ($count % 3 !== 0) {
        while ($count % 3 !== 0) {
            $html .= '<td></td>';
            $count++;
        }
    }
    $html .= '</tr></table>';
    return $html;
}

// Fetch rows
$rows = [];
$stmt = $conn->prepare($query);
if ($stmt) {
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        while ($r = $result->fetch_assoc()) {
            $rows[] = $r;
        }
    }
    $stmt->close();
}

include "../includes/header.php";
?>

<div class="app-surface p-3 p-md-4">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
        <div>
            <div class="h4 fw-bold mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Patient History Logs</div>
            <div class="text-muted">Filter and review patient-related audit trail entries.</div>
        </div>
        <a class="btn btn-outline-secondary" href="../pages/dashboard.php"><i class="bi bi-arrow-left me-1"></i>Back</a>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="patient_id" class="form-label">Patient ID</label>
                    <input type="text" class="form-control" id="patient_id" name="patient_id" value="<?php echo htmlspecialchars($patient_id); ?>" placeholder="Enter Patient ID">
                </div>
                <div class="col-md-3">
                    <label for="action_type" class="form-label">Action Type</label>
                    <select class="form-select" id="action_type" name="action_type">
                        <option value="">All Actions</option>
                        <option value="INSERT" <?php echo $action_type === 'INSERT' ? 'selected' : ''; ?>>INSERT</option>
                        <option value="UPDATE" <?php echo $action_type === 'UPDATE' ? 'selected' : ''; ?>>UPDATE</option>
                        <option value="DELETE" <?php echo $action_type === 'DELETE' ? 'selected' : ''; ?>>DELETE</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="date_from" class="form-label">From Date</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="<?php echo htmlspecialchars($date_from); ?>">
                </div>
                <div class="col-md-2">
                    <label for="date_to" class="form-label">To Date</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="<?php echo htmlspecialchars($date_to); ?>">
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">Filter</button>
                    <a href="../modules/patient_history_logs.php" class="btn btn-outline-secondary">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Table</th>
                        <th>Patient ID</th>
                        <th>Username</th>
                        <th>Date &amp; Time</th>
                        <th>Old Values</th>
                        <th>New Values</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rows)): ?>
                        <tr><td colspan="7" class="text-center text-muted py-4">No logs found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($rows as $row): ?>
                            <?php
                                $action_class = '';
                                if (($row['action_type'] ?? '') === 'INSERT') $action_class = 'log-insert';
                                if (($row['action_type'] ?? '') === 'UPDATE') $action_class = 'log-update';
                                if (($row['action_type'] ?? '') === 'DELETE') $action_class = 'log-delete';
                            ?>
                            <tr class="<?php echo $action_class; ?>">
                                <td class="fw-semibold"><?php echo htmlspecialchars((string)($row['action_type'] ?? '')); ?></td>
                                <td><?php echo htmlspecialchars((string)($row['table_name'] ?? '')); ?></td>
                                <td><?php echo htmlspecialchars((string)($row['patient_id'] ?? '')); ?></td>
                                <td><?php echo htmlspecialchars((string)($row['username'] ?? '')); ?></td>
                                <td><?php echo htmlspecialchars((string)($row['action_date'] ?? '')); ?></td>
                                <td><?php echo format_values($row['old_values'] ?? null); ?></td>
                                <td><?php echo format_values($row['new_values'] ?? null); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../includes/footer.php"; ?>

