<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Team Members — StudentBase</title>
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
    <a href="add_student.php">
      <span class="nav-icon">➕</span><span>Add Student</span>
    </a>
    <a href="member.php" class="active">
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
<div class="form-page-wrapper" style="align-items:flex-start; padding-top:40px;">
  <div style="width:100%; max-width:800px;">

    <div class="page-header" style="margin-bottom:24px;">
      <h1>Team Members</h1>
      <p>Members involved in this project</p>
    </div>

    <div class="team-container" style="margin:0; padding:0;">

      <div class="member-card">
        <h2>Ridho</h2>
        <p>Responsibility: Connect application to MySQL database</p>
      </div>

      <div class="member-card">
        <h2>Fray</h2>
        <p>Responsibility: Display student list</p>
      </div>

      <div class="member-card">
        <h2>Soul</h2>
        <p>Responsibility: Edit existing student information</p>
      </div>

          <div class="member-card">
        <h2>Luyanda</h2>
        <p>Responsibility: Delete student records</p>
      </div>

          <div class="member-card">
        <h2>Morgan</h2>
        <p>Responsibility: Add new student records</p>
      </div>

          <div class="member-card">
        <h2>Livi</h2>
        <p>Responsibility: Website styling</p>
      </div>

    </div>
  </div>
</div>

</body>
</html>