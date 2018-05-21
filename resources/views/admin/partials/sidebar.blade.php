<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{url('/dist/img/avatar5.png')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Admin</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <!-- <li class="header">MAIN NAVIGATION</li> -->
        <li class="active treeview">
          <a href="/adminboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            {{-- <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span> --}}
          </a>
        </li>
        <li class="active treeview">
          <a href="/admin/post/list">
            <i class="fa fa-file-text"></i> <span>Posts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="/admin/post/list">
                <i class="fa fa-table"></i>
                <span>List Posts</span>
              </a>
            </li>
            <li>
              <a href="/admin/post/add">
                <i class="fa fa-edit"></i> <span>Add Posts</span>
              </a>
            </li>
            <li>
              <a href="/admin/post/category">
                <i class="fa fa-edit"></i> <span>Category</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="active treeview">
          <a href="/admin/page/list">
            <i class="fa fa-file-text"></i> <span>Pages</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="/admin/page/list">
                <i class="fa fa-table"></i>
                <span>List Pages</span>
              </a>
            </li>
            <li>
              <a href="/admin/page/add">
                <i class="fa fa-edit"></i> <span>Add Pages</span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
