  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="home" class="brand-link">
      <img src="{{asset('images/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SI-SARPRAS</span>
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
                <a href="{{ route('sarana.home') }}" class="nav-link">
                <i class="fas fa-fw fa-tachometer-alt nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li> 
              <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-fw fa-share"></i>
              <p>
                Master Data
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('sarana.ruangan') }}"  class="nav-link">
                  <i class="fas fa-calendar-check nav-icon"></i>
                  <p>Ruangan</p>
                </a>
              </li>
            <li class="nav-item">
                <a href="{{ route('sarana.kategori') }}"  class="nav-link">
                  <i class="fas fa-university nav-icon"></i>
                  <p>Kategori</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('sarana.barang') }}"  class="nav-link">
                  <i class="fas fa-school nav-icon"></i>
                  <p>Barang</p>
                </a>
              </li>
              
            </ul>
          </li>
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                <a href="{{ route('sarana.perencanaan') }}" class="nav-link ">
                  <i class="fas fa-building nav-icon"></i>
                  <p>Pengajuan</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('sarana.pengadaan') }}" class="nav-link ">
                  <i class="fas fa-cart-arrow-down nav-icon"></i>
                  <p>Pengadaan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('sarana.pendistribusian') }}" class="nav-link ">
                  <i class="fas fa-university nav-icon"></i>
                  <p>Pendistribusian</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('sarana.inventaris') }}" class="nav-link ">
                  <i class="fas fa-university nav-icon"></i>
                  <p>Inventaris</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('sarana.pemeliharaan') }}" class="nav-link ">
                  <i class="fas fa-university nav-icon"></i>
                  <p>Pemeliharaan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('sarana.stock.gudang') }}" class="nav-link ">
                  <i class="fas fa-university nav-icon"></i>
                  <p>Stok Gudang</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('sarana.laporan') }}" class="nav-link ">
                  <i class="fas fa-university nav-icon"></i>
                  <p>Laporan</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="{{ route('sarana.pengguna') }}" class="nav-link">
                  <i class="fas fa-users nav-icon"></i>
                  <p>Pengguna</p>
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