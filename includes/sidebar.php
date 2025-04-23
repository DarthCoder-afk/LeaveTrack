<?php include '../function/developers/developers_modal.php'; ?>



<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../pages/index.php" style="background-color: #2e8517;">
        <div class="sidebar-brand-icon">
          <img src="../img/logo.png" style="border-radius: 50%;">
        </div>
        <div class="sidebar-brand-text mx-3">HR Admin</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Features
      </div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
          aria-expanded="true" aria-controls="collapseBootstrap">
          <i class="far fa-fw fa-window-maximize"></i>
          <span>Applications</span>
        </a>
        <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">View</h6>
            <a class="collapse-item" href="../pages/applications.php">Leave Applications</a>
            <a class="collapse-item" href="../pages/travel_order.php">Travel Orders</a>
            <a class="collapse-item" href="../pages/view_calendar.php">Calendar</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../pages/leave_form.php">
          <i class="fas fa-print"></i>
          <span>Leave Form</span>
        </a>
      </li>
      <li class="nav-item">
      <a class="nav-link" href="../pages/employee_list.php">
          <i class="fas fa-users"></i>
          <span>Employee List</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../pages/accountsetting.php">
          <i class="fas fa-cog"></i>
          <span>Account Settings</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="logout-link" href="#">
          <i class="fas fa-sign-out-alt"></i>
          <span>Log-out</span>
        </a>
      </li>

      <!-- Sticky Developers Button at Bottom -->
      <div class="mt-auto px-3 pb-3">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#developersModal">
          <i class="fas fa-users-cog"></i> System Developers
        </a>
      </div>



      <hr class="sidebar-divider">
    </ul>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top" style="background-color: #2e8517;">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <?php
              include 'activity_log.php';
            ?>

            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="../img/profile.jpg" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small">Administrator</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="./accountsetting.php">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Account Settings
                </a>
                <a class="dropdown-item" href="./history.php">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" id="logout-link-2">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->
