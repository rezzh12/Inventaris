  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="home" class="brand-link">
      <img src="{{asset('images/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Sarana Prasarana</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('images/AdminLTELogo.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <p>{{ Auth::user()->username }}</p>
       
        </div>
      </div>

      <!-- SidebarSearch Form -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
                <a href="home" class="nav-link">
                <i class="fas fa-fw fa-tachometer-alt nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li> 
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                <a href="prasarana" class="nav-link ">
                  <i class="fas fa-building nav-icon"></i>
                  <p>Prasarana</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="sarana" class="nav-link ">
                  <i class="fas fa-cart-arrow-down nav-icon"></i>
                  <p>Sarana</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pinjam_prasarana" class="nav-link">
                  <i class="fas fa-share nav-icon"></i>
                  <p>Pinjam Prasarana</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pengembalian_prasarana" class="nav-link">
                  <i class="fas fa-reply nav-icon"></i>
                  <p>Prasarana Kembali</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="peminjaman" class="nav-link ">
                  <i class="fas fa-share nav-icon"></i>
                  <p>Pinjam Sarana</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pengembalian" class="nav-link ">
                  <i class="fas fa-reply nav-icon"></i>
                  <p>Sarana Kermbali</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="riwayat_denda" class="nav-link ">
                  <i class="fas fa-history nav-icon"></i>
                  <p>Riwayat Denda</p>
                </a>
              </li>


              <!-- <li class="nav-item">
                <a href="info" class="nav-link">
                  <i class="fas fa-user nav-icon"></i>
                  <p>Info</p>
                </a>
              </li> -->

              
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    </aside>