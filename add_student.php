<?php
include 'config.php';

$success = '';
$error   = '';

if (isset($_POST['add'])) {
    $student_id = trim($_POST['student_id'] ?? '');
    $name       = trim($_POST['name']       ?? '');
    $department = trim($_POST['department'] ?? '');
    $gpa        = trim($_POST['gpa']        ?? '');

    if (!$student_id || !$name || !$department || $gpa === '') {
        $error = 'All fields are required.';
    } elseif (!is_numeric($gpa) || $gpa < 0 || $gpa > 4) {
        $error = 'GPA must be a number between 0.00 and 4.00.';
    } else {
        $gpa = (float) $gpa;
        if ($gpa >= 3.5)     $status = 'Excellent';
        elseif ($gpa >= 2.0) $status = 'Good';
        else                 $status = 'Warning';

        $stmt = $pdo->prepare("INSERT INTO students (student_id, name, department, gpa, status)
                               VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$student_id, $name, $department, $gpa, $status])) {
            $success = "Student <strong>" . htmlspecialchars($name) . "</strong> was successfully added with status <strong>$status</strong>.";
            $student_id = $name = $department = $gpa = '';
        } else {
            $error = 'Failed to save data. The Student ID may already exist.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Student — StudentBase</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- ── SIDEBAR ── -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-icon">🎓</div>
    <div class="logo-text">
      <strong>Student DataBase</strong>
      <span>Academic Management</span>
    </div>
  </div>

  <div class="sidebar-section-label">Menu</div>
  <nav class="sidebar-nav">
    <a href="index.php">
      <span class="nav-icon">🏠</span><span>Dashboard</span>
    </a>
    <a href="index.php#students">
      <span class="nav-icon">👨‍🎓</span><span>Students</span>
    </a>
    <a href="index.php#analytics">
      <span class="nav-icon">📊</span><span>Analytics</span>
    </a>
    <a href="add_student.php" class="active">
      <span class="nav-icon">➕</span><span>Add Student</span>
    </a>
    <a href="member.php">
      <span class="nav-icon">👥</span><span>Team Members</span>
    </a>
  </nav>

  <div class="sidebar-avatar">
    <div class="avatar-circle">AD</div>
    <div class="avatar-info">
      <strong>Admin</strong>
      <span>Administrator</span>
    </div>
  </div>
</aside>

<!-- ── Home Button (fixed top-right) ── -->
<a href="index.php" class="home-btn">🏠 Home</a>

<!-- ── MAIN FORM AREA ── -->
<div class="form-page-wrapper">

  <div class="form-card">

    <!-- Header -->
    <div class="form-card-header">
      <div class="form-card-icon">🎓</div>
      <div>
        <h1>Add New Student</h1>
        <p>Add student information into the system</p>
      </div>
    </div>

    <!-- Alert -->
    <?php if ($success): ?>
    <div style="padding:16px 32px 0;">
      <div class="alert alert-success">
        ✓ <?= $success ?>
        &nbsp;—&nbsp;
        <a href="index.php" style="color:inherit;font-weight:700;text-decoration:underline;">View list</a>
      </div>
    </div>
    <?php elseif ($error): ?>
    <div style="padding:16px 32px 0;">
      <div class="alert alert-error">⚠ <?= htmlspecialchars($error) ?></div>
    </div>
    <?php endif; ?>

    <!-- Form -->
    <form method="POST" action="add_student.php" autocomplete="off">
      <div class="form-body">

        <!-- Row 1: Student ID + Name -->
        <div class="form-row">
          <div class="form-group">
            <label>Student ID <span class="required">*</span></label>
            <input type="text"
                   name="student_id"
                   placeholder="e.g. STD012"
                   value="<?= htmlspecialchars($student_id ?? '') ?>"
                   required>
            <span class="form-hint">Unique student identifier</span>
          </div>
          <div class="form-group">
            <label>Full Name <span class="required">*</span></label>
            <input type="text"
                   name="name"
                   placeholder="Full name of student"
                   value="<?= htmlspecialchars($name ?? '') ?>"
                   required>
          </div>
        </div>

        <!-- Row 2: Department + GPA -->
        <div class="form-row">
          <div class="form-group">
            <label>Department <span class="required">*</span></label>
            <select name="department" required>
              <option value="" disabled <?= empty($department ?? '') ? 'selected' : '' ?>>
                Select department...
              </option>
              <?php
              $depts = ['Computer Science','Information Systems','Informatics','Electrical Engineering','Management','International Relationship'];
              foreach ($depts as $d):
                $sel = (isset($department) && $department === $d) ? 'selected' : '';
              ?>
              <option value="<?= $d ?>" <?= $sel ?>><?= $d ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>GPA <span class="required">*</span></label>
            <input type="number"
                   name="gpa"
                   placeholder="0.00"
                   step="0.01"
                   min="0"
                   max="4"
                   value="<?= htmlspecialchars($gpa ?? '') ?>"
                   required>
            <span class="form-hint">Scale 0.00 – 4.00 &nbsp;|&nbsp; ≥3.5 Excellent · ≥2.0 Good · &lt;2.0 Warning</span>
          </div>
        </div>

      </div><!-- /form-body -->

      <div class="form-footer">
        <button type="submit" name="add" class="btn-primary">
          ➕ Add Student
        </button>
        <a href="index.php" class="btn-secondary">
          Cancel
        </a>
      </div>
    </form>

  </div><!-- /form-card -->
</div><!-- /form-page-wrapper -->

</body>
</html>