<?php
include 'config.php';

$stmt = $pdo->query("SELECT * FROM students ORDER BY gpa DESC");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total     = count($students);
$excellent = $pdo->query("SELECT COUNT(*) FROM students WHERE status='Excellent'")->fetchColumn();
$good      = $pdo->query("SELECT COUNT(*) FROM students WHERE status='Good'")->fetchColumn();
$warning   = $pdo->query("SELECT COUNT(*) FROM students WHERE status='Warning'")->fetchColumn();

$deptStmt = $pdo->query("SELECT department, AVG(gpa) as avg_gpa FROM students GROUP BY department ORDER BY department");
$deptData = $deptStmt->fetchAll(PDO::FETCH_ASSOC);

function initials(string $name): string {
    $parts = explode(' ', trim($name));
    $i = strtoupper(substr($parts[0], 0, 1));
    if (isset($parts[1])) $i .= strtoupper(substr($parts[1], 0, 1));
    return $i;
}

$avatarColors = ['#3b82f6','#8b5cf6','#ec4899','#f59e0b','#10b981','#06b6d4','#f43f5e','#6366f1'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Database Management System</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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
    <a href="#dashboard" class="active">
      <span class="nav-icon">🏠</span><span>Dashboard</span>
    </a>
    <a href="#students">
      <span class="nav-icon">👨‍🎓</span><span>Students</span>
    </a>
    <a href="#analytics">
      <span class="nav-icon">📊</span><span>Analytics</span>
    </a>
    <a href="add_student.php">
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

<!-- ── MAIN ── -->
<main class="main">

  <!-- Page Header -->
  <div class="page-header" id="dashboard">
    <h1>Dashboard</h1>
    <p>Academic summary for the current active semester</p>
  </div>

  <!-- Stat Cards -->
  <div class="cards">
    <div class="card">
      <div class="card-info">
        <span class="card-label">Total Student</span>
        <strong><?= $total ?></strong>
        <span class="card-sub">This Semester</span>
      </div>
      <div class="card-icon-box blue">👥</div>
    </div>
    <div class="card">
      <div class="card-info">
        <span class="card-label">Excellent</span>
        <strong><?= $excellent ?></strong>
        <span class="card-sub">GPA &ge; 3.5</span>
      </div>
      <div class="card-icon-box green">⭐</div>
    </div>
    <div class="card">
      <div class="card-info">
        <span class="card-label">Good</span>
        <strong><?= $good ?></strong>
        <span class="card-sub">GPA 3.0 &ndash; 3.49</span>
      </div>
      <div class="card-icon-box orange">👍</div>
    </div>
    <div class="card">
      <div class="card-info">
        <span class="card-label">Warning</span>
        <strong><?= $warning ?></strong>
        <span class="card-sub">GPA &lt; 3.0</span>
      </div>
      <div class="card-icon-box red">⚠️</div>
    </div>
  </div>

  <!-- Charts Row -->
  <div class="charts-row" id="analytics">
    <div class="chart-card">
      <h3>GPA Distribution by Department</h3>
      <div class="chart-wrapper">
        <canvas id="barChart"></canvas>
      </div>
    </div>
    <div class="chart-card">
      <h3>Student Status</h3>
      <div class="chart-wrapper">
        <canvas id="donutChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Table Section -->
  <div class="table-section" id="students">
    <div class="table-header">
      <h2>Student List</h2>
      <div class="table-controls">
        <div class="search-box">
          <span class="search-icon">🔍</span>
          <input type="text" id="searchInput" placeholder="Search by name or ID...">
        </div>
        <select class="filter-select" id="statusFilter">
          <option value="">All Status</option>
          <option value="Excellent">Excellent</option>
          <option value="Good">Good</option>
          <option value="Warning">Warning</option>
        </select>
        <a href="add_student.php" class="add-btn">+ Add Student</a>
      </div>
    </div>

    <table id="studentTable">
      <thead>
        <tr>
          <th>Student</th>
          <th>Department</th>
          <th>GPA</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($students as $idx => $s):
          $color    = $avatarColors[$idx % count($avatarColors)];
          $init     = initials($s['name']);
          $gpaPct   = round(($s['gpa'] / 4.0) * 100);
          $barColor = $s['status'] === 'Excellent' ? '#22c55e' : ($s['status'] === 'Good' ? '#3b82f6' : '#ef4444');
          $badgeClass = 'status-' . strtolower($s['status']);
        ?>
        <tr data-status="<?= strtolower($s['status']) ?>">
          <td>
            <div class="student-cell">
              <div class="student-avatar" style="background:<?= $color ?>">
                <?= $init ?>
              </div>
              <div>
                <div class="student-name"><?= htmlspecialchars($s['name']) ?></div>
                <div class="student-id"><?= htmlspecialchars($s['student_id']) ?></div>
              </div>
            </div>
          </td>
          <td><?= htmlspecialchars($s['department']) ?></td>
          <td>
            <div class="gpa-cell">
              <div class="gpa-bar-bg">
                <div class="gpa-bar-fill" style="width:<?= $gpaPct ?>%;background:<?= $barColor ?>"></div>
              </div>
              <span class="gpa-value"><?= number_format($s['gpa'], 2) ?></span>
            </div>
          </td>
          <td>
            <span class="status-badge <?= $badgeClass ?>">
              <?= htmlspecialchars($s['status']) ?>
            </span>
          </td>
          <td>
            <a href="edit_student.php?id=<?= $s['id'] ?>" class="edit">Edit</a>
            <a href="delete_student.php?id=<?= $s['id'] ?>"
               class="delete"
               onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</main>

<script>
// ── Bar Chart ──
const deptLabels = <?= json_encode(array_column($deptData, 'department')) ?>;
const deptGPA    = <?= json_encode(array_map(fn($d) => round($d['avg_gpa'], 2), $deptData)) ?>;

new Chart(document.getElementById('barChart'), {
  type: 'bar',
  data: {
    labels: deptLabels,
    datasets: [{
      data: deptGPA,
      backgroundColor: 'rgba(59,130,246,0.18)',
      borderColor: '#3b82f6',
      borderWidth: 1.5,
      borderRadius: 6,
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
      y: {
        min: 2.0, max: 4.0,
        ticks: { font: { size: 11 } },
        grid: { color: '#f1f5f9' }
      },
      x: {
        ticks: { font: { size: 11 } },
        grid: { display: false }
      }
    }
  }
});

// ── Donut Chart ──
new Chart(document.getElementById('donutChart'), {
  type: 'doughnut',
  data: {
    labels: ['Excellent', 'Good', 'Warning'],
    datasets: [{
      data: [<?= $excellent ?>, <?= $good ?>, <?= $warning ?>],
      backgroundColor: ['#22c55e', '#3b82f6', '#ef4444'],
      borderWidth: 0,
      hoverOffset: 6
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    cutout: '68%',
    plugins: {
      legend: {
        position: 'right',
        labels: {
          font: { size: 12 },
          padding: 16,
          usePointStyle: true,
          pointStyleWidth: 8
        }
      }
    }
  }
});

// ── Search & Filter ──
const searchInput  = document.getElementById('searchInput');
const statusFilter = document.getElementById('statusFilter');

function filterTable() {
  const q      = searchInput.value.trim().toLowerCase();
  const status = statusFilter.value.trim().toLowerCase();

  const rows = document.querySelectorAll('#studentTable tbody tr');

  rows.forEach(row => {
    const cells = row.querySelectorAll('td');
    if (!cells.length) return;

    const rowText = row.textContent.trim().toLowerCase();
    const rowStat = (row.dataset.status || (cells[3] ? cells[3].textContent.trim() : '')).toLowerCase();

    const matchQ = !q || rowText.includes(q);
    const matchS = !status || rowStat === status;

    row.style.display = matchQ && matchS ? '' : 'none';
  });
}

searchInput.addEventListener('input', filterTable);
statusFilter.addEventListener('change', filterTable);
filterTable();

// ── Sidebar active link ──
const allNavLinks = document.querySelectorAll('.sidebar-nav a');

// Map anchor hrefs to their section links (only same-page anchors)
const anchorLinks = {
  '#dashboard': document.querySelector('.sidebar-nav a[href="#dashboard"]'),
  '#analytics': document.querySelector('.sidebar-nav a[href="#analytics"]'),
  '#students':  document.querySelector('.sidebar-nav a[href="#students"]'),
};

const sections = [
  { id: 'dashboard', link: anchorLinks['#dashboard'] },
  { id: 'analytics', link: anchorLinks['#analytics'] },
  { id: 'students',  link: anchorLinks['#students']  },
];

let scrollLockTimer = null;
let isScrollLocked  = false;

function setActive(link) {
  allNavLinks.forEach(a => a.classList.remove('active'));
  if (link) link.classList.add('active');
}

// Click handler: lock scroll updates for 1 second so the active state sticks
allNavLinks.forEach(a => {
  a.addEventListener('click', function() {
    setActive(this);

    // Only lock scroll for same-page anchors; external pages navigate away anyway
    const href = this.getAttribute('href');
    if (href && href.startsWith('#')) {
      isScrollLocked = true;
      clearTimeout(scrollLockTimer);
      scrollLockTimer = setTimeout(() => { isScrollLocked = false; }, 1000);
    }
  });
});

// Scroll: update active only when not locked by a recent click
window.addEventListener('scroll', () => {
  if (isScrollLocked) return;

  const scrollMid = window.scrollY + (window.innerHeight / 2);
  let current = sections[0];

  sections.forEach(s => {
    const el = document.getElementById(s.id);
    if (el && el.getBoundingClientRect().top + window.scrollY <= scrollMid) {
      current = s;
    }
  });

  // Near bottom → activate last section
  const nearBottom = (window.innerHeight + window.scrollY) >= document.body.offsetHeight - 50;
  if (nearBottom) {
    for (let i = sections.length - 1; i >= 0; i--) {
      if (document.getElementById(sections[i].id)) { current = sections[i]; break; }
    }
  }

  setActive(current.link);
}, { passive: true });
</script>

</body>
</html>