
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>FYP Monitoring Portal</title>
<!--Style-->
  <link rel="stylesheet" href="/css/app.css">
  
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    
    </ul>

    <!-- SEARCH FORM -->
    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
     
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar bg-theme sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
     
      <span class="brand-text font-weight-light">FYP Monitoring Portal</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <p class="d-block text-white text-capitalize"> {{ Auth::user()->type }}</p>
          <p class="d-block text-white"> {{ Auth::user()->name }}</p>
        </div>
       
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                <router-link to="/dashboard" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt blue"></i>
                  <p>
                    Statistics
                 
                  </p>
                </router-link>
              </li>
              @can('isAdmin')
              
            
          <li class="nav-item has-treeview ">
              
            <a href="#" class="nav-link ">
              <i class="nav-icon fas fa-cogs green"></i>
              <p>
                Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/teachers" class="nav-link">
                  <i class="fas fa-users nav-icon yellow"></i>
                  <p>Teachers</p>
                </router-link >
              </li>
              <li class="nav-item">
                <router-link to="/students" class="nav-link">
                    <i class="fas fa-user-graduate yellow mr-2 ml-1"></i>
                  <p>Students</p>
                </router-link >
              </li>
              <li class="nav-item">
                <router-link to='/pending-requests' class="nav-link">
                  <i class="fas fa-clock nav-icon orange"></i>
                  <p>Pending Requests</p>
                </router-link >
              </li>
            </ul>
          </li>
          @endcan
          @can('isStudent')
 
          <li class="nav-item">
            <router-link to='/student-profile' class="nav-link">
                <i class="fas fa-user nav-icon aqua"></i>
                <p>Profile</p>
              </router-link >
          </li>
          <li class="nav-item">
            <router-link to='/documentsmanage' class="nav-link">
                <i class="fas fa-book nav-icon orange"></i>
                <p>Manage Documents</p>
              </router-link >
          </li>
          @endcan
        
          @cannot('isStudent')
          <li class="nav-item">
            <router-link to='/teacher-profile' class="nav-link">
                <i class="fas fa-user nav-icon aqua"></i>
                <p>Profile</p>
              </router-link >
          </li>
          <li class="nav-item">
            <router-link to='/documentsteacher' class="nav-link">
                <i class="fas fa-book nav-icon orange"></i>
                <p>View Documents</p>
              </router-link >
          </li>
          @endcannot
          @can('isAdminOrExternal')
          <li class="nav-item">
            <router-link to='/all-documents' class="nav-link">
                <i class="fas fa-book nav-icon orange"></i>
                <p>View All Documents</p>
              </router-link >
          </li>
          @endcan
          <li class="nav-item">
            <router-link to='/chat' class="nav-link">
                <i class="fas fa-comment nav-icon indigo"></i>
                <p>Chat Room</p>
              </router-link >
          </li>
          <li class="nav-item">
            <a  class=" nav-link dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
              <i class="nav-icon fas fa-power-off red"></i>
              <p>
                Logout
              
              </p>
              
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper bg-theme-light">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        
          <div class="col-sm-6">
          
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content ">
      <div class="container-fluid">
      <router-view></router-view>
       <!-- set progressbar -->
       <vue-progress-bar></vue-progress-bar>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  
</div>
<!-- ./wrapper -->
@auth
<script>
    window.user=@json(auth()->user())
  </script>

@endauth
<!-- REQUIRED SCRIPTS -->
<script src="/js/app.js"></script>
</body>
</html>
