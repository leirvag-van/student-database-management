<?php
include 'config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$student) { header('Location: index.php'); exit; }

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name       = trim($_POST['name'] ?? '');
    $student_id = trim($_POST['student_id'] ?? '');
    $department = trim($_POST['department'] ?? '');
    $gpa        = (float)($_POST['gpa'] ?? 0);

    if (!$name || !$student_id || !$department || $gpa < 0 || $gpa > 4.0) {
        $error = 'Please fill in all fields correctly. GPA must be between 0.00 and 4.00.';
    } else {
        // Auto-determine status
        if ($gpa >= 3.5)      $status = 'Excellent';
        elseif ($gpa >= 3.0)  $status = 'Good';
        else                   $status = 'Warning';

        $upd = $pdo->prepare("UPDATE students SET name=?, student_id=?, department=?, gpa=?, status=? WHERE id=?");
        $upd->execute([$name, $student_id, $department, $gpa, $status, $id]);
        $success = 'Student data has been updated successfully!';

        // Refresh local data
        $student = array_merge($student, compact('name','student_id','department','gpa','status'));
    }
}

$departments = ['Computer Science','Information Technology','Mathematics','Physics',
                'Engineering','Business Administration','International Relationship','ca','compscie'];
sort($departments);

function initials(string $name): string {
    $parts = explode(' ', trim($name));
    $i = strtoupper(substr($parts[0], 0, 1));
    if (isset($parts[1])) $i .= strtoupper(substr($parts[1], 0, 1));
    return $i;
}

$avatarColors = ['#3b82f6','#8b5cf6','#ec4899','#f59e0b','#10b981','#06b6d4','#f43f5e','#6366f1'];
$avatarColor  = $avatarColors[$id % count($avatarColors)];
$init         = initials($student['name']);

$badgeClass = 'status-' . strtolower($student['status']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Student — Student DataBase</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* ── Edit page extras ── */
    .edit-layout {
      display: grid;
      grid-template-columns: 300px 1fr;
      gap: 24px;
      max-width: 1000px;
      width: 100%;
    }

    /* Profile card (left) */
    .profile-card {
      background: white;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.07);
      overflow: hidden;
      height: fit-content;
    }

    .profile-banner {
      height: 90px;
      background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
      position: relative;
    }

    .profile-avatar-wrap {
      position: absolute;
      bottom: -36px;
      left: 50%;
      transform: translateX(-50%);
    }

    .profile-avatar-lg {
      width: 72px;
      height: 72px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
      font-weight: 700;
      color: white;
      border: 4px solid white;
      box-shadow: 0 4px 14px rgba(0,0,0,0.15);
      transition: transform 0.3s ease;
    }

    .profile-avatar-lg:hover {
      transform: scale(1.06);
    }

    .profile-body {
      padding: 50px 24px 28px;
      text-align: center;
    }

    .profile-name {
      font-size: 17px;
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 4px;
    }

    .profile-sid {
      font-size: 12px;
      color: #64748b;
      margin-bottom: 14px;
    }

    .profile-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 5px 14px;
      border-radius: 99px;
      font-size: 12.5px;
      font-weight: 600;
      margin-bottom: 22px;
    }

    .profile-badge::before {
      content: '';
      width: 7px;
      height: 7px;
      border-radius: 50%;
    }

    .profile-stats {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
      margin-top: 4px;
    }

    .profile-stat {
      background: #f8fafc;
      border-radius: 10px;
      padding: 12px 8px;
    }

    .profile-stat-val {
      display: block;
      font-size: 18px;
      font-weight: 700;
      color: #0f172a;
    }

    .profile-stat-label {
      display: block;
      font-size: 10.5px;
      color: #64748b;
      margin-top: 2px;
    }

    .profile-dept {
      margin-top: 14px;
      padding-top: 14px;
      border-top: 1px solid #e2e8f0;
      font-size: 12.5px;
      color: #64748b;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
    }

    /* Form card (right) */
    .edit-form-card {
      background: white;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.07);
      overflow: hidden;
    }

    .edit-form-header {
      padding: 26px 30px 22px;
      border-bottom: 1px solid #e2e8f0;
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .edit-form-icon {
      width: 44px;
      height: 44px;
      background: #eff6ff;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      flex-shrink: 0;
    }

    .edit-form-header h1 {
      font-size: 17px;
      font-weight: 700;
      color: #0f172a;
      margin-bottom: 2px;
    }

    .edit-form-header p {
      font-size: 12px;
      color: #64748b;
    }

    .edit-form-body {
      padding: 28px 30px;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    /* GPA live indicator */
    .gpa-indicator {
      margin-top: 8px;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .gpa-track {
      flex: 1;
      height: 8px;
      background: #e2e8f0;
      border-radius: 99px;
      overflow: hidden;
      position: relative;
    }

    .gpa-fill {
      height: 100%;
      border-radius: 99px;
      transition: width 0.3s ease, background 0.3s ease;
    }

    .gpa-status-tag {
      font-size: 11.5px;
      font-weight: 600;
      padding: 3px 10px;
      border-radius: 99px;
      white-space: nowrap;
      transition: all 0.2s;
    }

    /* Alert */
    .alert {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 13px 16px;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 500;
      animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
      from { opacity: 0; transform: translateY(-8px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .alert-success {
      background: #dcfce7;
      color: #15803d;
      border: 1px solid #bbf7d0;
    }

    .alert-error {
      background: #fee2e2;
      color: #b91c1c;
      border: 1px solid #fecaca;
    }

    .edit-form-footer {
      padding: 18px 30px 26px;
      display: flex;
      align-items: center;
      gap: 12px;
      border-top: 1px solid #e2e8f0;
    }

    .btn-save {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #2563eb;
      color: white;
      padding: 11px 24px;
      border-radius: 9px;
      font-size: 13.5px;
      font-weight: 600;
      font-family: inherit;
      border: none;
      cursor: pointer;
      text-decoration: none;
      transition: background 0.15s, transform 0.1s, box-shadow 0.15s;
      box-shadow: 0 4px 12px rgba(37,99,235,0.25);
    }

    .btn-save:hover {
      background: #1d4ed8;
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(37,99,235,0.35);
    }

    .btn-save:active {
      transform: translateY(0);
    }

    .btn-cancel {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      background: white;
      color: #64748b;
      padding: 11px 18px;
      border-radius: 9px;
      font-size: 13.5px;
      font-weight: 600;
      font-family: inherit;
      border: 1.5px solid #e2e8f0;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.15s;
    }

    .btn-cancel:hover {
      color: #0f172a;
      border-color: #94a3b8;
      background: #f8fafc;
    }

    /* Breadcrumb */
    .breadcrumb {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 12.5px;
      color: #94a3b8;
      margin-bottom: 22px;
    }

    .breadcrumb a {
      color: #64748b;
      text-decoration: none;
      font-weight: 500;
    }

    .breadcrumb a:hover { color: #2563eb; }

    .breadcrumb span { font-size: 11px; }

    /* Input focus ring */
    .form-group input:focus,
    .form-group select:focus {
      border-color: #2563eb;
      box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }

    /* Responsive */
    @media (max-width: 820px) {
      .edit-layout {
        grid-template-columns: 1fr;
      }
    }
  </style>
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
    <a href="index.php#dashboard">
      <span class="nav-icon">🏠</span><span>Dashboard</span>
    </a>
    <a href="index.php#students" class="active">
      <span class="nav-icon">👨‍🎓</span><span>Students</span>
    </a>
    <a href="index.php#analytics">
      <span class="nav-icon">📊</span><span>Analytics</span>
    </a>
    <a href="index.php#add-student">
      <span class="nav-icon">➕</span><span>Add Student</span>
    </a>
    <a href="index.php#team-members">
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

<!-- ── MAIN ── -->
<main class="main">

  <div class="breadcrumb">
    <a href="index.php">🏠 Dashboard</a>
    <span>›</span>
    <a href="index.php#students">Students</a>
    <span>›</span>
    <span>Edit Student</span>
  </div>

  <div class="edit-layout">

    <!-- Left: Profile preview card -->
    <div class="profile-card" id="profileCard">
      <div class="profile-banner"></div>
      <div class="profile-avatar-wrap">
        <div class="profile-avatar-lg" id="previewAvatar" style="background:<?= $avatarColor ?>">
          <?= $init ?>
        </div>
      </div>
      <div class="profile-body">
        <div class="profile-name" id="previewName"><?= htmlspecialchars($student['name']) ?></div>
        <div class="profile-sid" id="previewSid"><?= htmlspecialchars($student['student_id']) ?></div>

        <div class="profile-badge <?= $badgeClass ?>" id="previewBadge">
          <?= htmlspecialchars($student['status']) ?>
        </div>

        <div class="profile-stats">
          <div class="profile-stat">
            <span class="profile-stat-val" id="previewGpa"><?= number_format($student['gpa'], 2) ?></span>
            <span class="profile-stat-label">GPA Score</span>
          </div>
          <div class="profile-stat">
            <span class="profile-stat-val">4.00</span>
            <span class="profile-stat-label">Max GPA</span>
          </div>
        </div>

        <div class="profile-dept">
          🏛️ <span id="previewDept"><?= htmlspecialchars($student['department']) ?></span>
        </div>
      </div>
    </div>

    <!-- Right: Edit form -->
    <div class="edit-form-card">
      <div class="edit-form-header">
        <div class="edit-form-icon">✏️</div>
        <div>
          <h1>Edit Student</h1>
          <p>Update the student's academic information below</p>
        </div>
      </div>

      <form method="POST" action="">
        <div class="edit-form-body">

          <?php if ($success): ?>
          <div class="alert alert-success">✅ <?= htmlspecialchars($success) ?></div>
          <?php endif; ?>
          <?php if ($error): ?>
          <div class="alert alert-error">⚠️ <?= htmlspecialchars($error) ?></div>
          <?php endif; ?>

          <div class="form-row">
            <div class="form-group">
              <label>Full Name <span class="required">*</span></label>
              <input type="text" name="name" id="inputName"
                     value="<?= htmlspecialchars($student['name']) ?>"
                     placeholder="e.g. John Doe" required>
            </div>
            <div class="form-group">
              <label>Student ID <span class="required">*</span></label>
              <input type="text" name="student_id" id="inputSid"
                     value="<?= htmlspecialchars($student['student_id']) ?>"
                     placeholder="e.g. STU-2024-001" required>
            </div>
          </div>

          <div class="form-group">
            <label>Department <span class="required">*</span></label>
            <select name="department" id="inputDept" required>
              <option value="">— Select Department —</option>
              <?php foreach ($departments as $dept): ?>
              <option value="<?= htmlspecialchars($dept) ?>"
                <?= $student['department'] === $dept ? 'selected' : '' ?>>
                <?= htmlspecialchars($dept) ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>GPA Score <span class="required">*</span></label>
            <input type="number" name="gpa" id="inputGpa"
                   value="<?= htmlspecialchars($student['gpa']) ?>"
                   min="0" max="4.0" step="0.01"
                   placeholder="0.00 – 4.00" required>
            <div class="gpa-indicator">
              <div class="gpa-track">
                <div class="gpa-fill" id="gpaFill"></div>
              </div>
              <span class="gpa-status-tag" id="gpaTag"></span>
            </div>
            <span class="form-hint">Status is set automatically based on GPA value</span>
          </div>

        </div>

        <div class="edit-form-footer">
          <button type="submit" class="btn-save">💾 Save Changes</button>
          <a href="index.php#students" class="btn-cancel">✕ Cancel</a>
        </div>
      </form>
    </div>

  </div>
</main>

<script>
// ── Live preview helpers ──
const inputName  = document.getElementById('inputName');
const inputSid   = document.getElementById('inputSid');
const inputDept  = document.getElementById('inputDept');
const inputGpa   = document.getElementById('inputGpa');

const previewName   = document.getElementById('previewName');
const previewSid    = document.getElementById('previewSid');
const previewDept   = document.getElementById('previewDept');
const previewGpa    = document.getElementById('previewGpa');
const previewAvatar = document.getElementById('previewAvatar');
const previewBadge  = document.getElementById('previewBadge');
const gpaFill       = document.getElementById('gpaFill');
const gpaTag        = document.getElementById('gpaTag');

function getInitials(name) {
  const parts = name.trim().split(/\s+/);
  let i = (parts[0] || '').charAt(0).toUpperCase();
  if (parts[1]) i += parts[1].charAt(0).toUpperCase();
  return i || '?';
}

function getStatus(gpa) {
  if (gpa >= 3.5) return { label: 'Excellent', cls: 'status-excellent', color: '#22c55e', bg: '#dcfce7', text: '#15803d' };
  if (gpa >= 3.0) return { label: 'Good',      cls: 'status-good',      color: '#3b82f6', bg: '#dbeafe', text: '#1d4ed8' };
  return           { label: 'Warning',          cls: 'status-warning',   color: '#ef4444', bg: '#fee2e2', text: '#b91c1c' };
}

function updateGpaBar(val) {
  const pct = Math.min(Math.max(val / 4.0, 0), 1) * 100;
  const st  = getStatus(val);
  gpaFill.style.width      = pct + '%';
  gpaFill.style.background = st.color;
  gpaTag.textContent        = st.label;
  gpaTag.style.background   = st.bg;
  gpaTag.style.color         = st.text;
}

function updateBadge(val) {
  const st = getStatus(val);
  previewBadge.className    = 'profile-badge ' + st.cls;
  previewBadge.textContent  = st.label;
}

// Init
updateGpaBar(parseFloat(inputGpa.value) || 0);
updateBadge(parseFloat(inputGpa.value) || 0);

// Listeners
inputName.addEventListener('input', () => {
  previewName.textContent    = inputName.value || '—';
  previewAvatar.textContent  = getInitials(inputName.value);
});

inputSid.addEventListener('input', () => {
  previewSid.textContent = inputSid.value || '—';
});

inputDept.addEventListener('change', () => {
  previewDept.textContent = inputDept.value || '—';
});

inputGpa.addEventListener('input', () => {
  const v = parseFloat(inputGpa.value);
  if (!isNaN(v) && v >= 0 && v <= 4) {
    previewGpa.textContent = v.toFixed(2);
    updateGpaBar(v);
    updateBadge(v);
  }
});
</script>

</body>
</html>