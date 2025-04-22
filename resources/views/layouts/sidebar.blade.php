<!-- Sidebar Menu -->

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    
      <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link  ">
          <i class="nav-icon fas fa-th"></i>
          <p>Dashboard</p>
        </a>
      </li>
      
       
      
      <li class="nav-item">
        <a href="" class="nav-link ">
          <i class="nav-icon fas fa-users"></i>
          <p>Precinct Leader</p>
        </a>
      </li>
      
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-users"></i>
          <p>All Members</p>
        </a>
      </li>
     
      <li class="nav-item">
        <a href="" class="nav-link ">
          <i class="nav-icon fa fa-database"></i>
          <p>Comelec Data</p>
        </a>
      </li>
       
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-chart-bar"></i>
          <p>Generate Reports</p>
        </a>
      </li>
    
      <li class="nav-header">System</li>
      <li class="nav-item">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-book"></i>
          <p>
            Settings
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('users.list') }}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>Users</p>
            </a>
          </li>
         
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>Barangay List</p>
            </a>
          </li>
         
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>Purok List</p>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
  