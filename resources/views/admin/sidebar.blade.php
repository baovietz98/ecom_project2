<div class="d-flex align-items-stretch">
    <!-- Sidebar Navigation-->
    <nav id="sidebar">
      <!-- Sidebar Header-->
      <div class="sidebar-header d-flex align-items-center">
        <div class="avatar"><img src="{{ asset('admincss/img/avatar-6.jpg') }}" alt="..." class="img-fluid rounded-circle"></div>
        <div class="title">
          <h1 class="h5">{{ Auth::user()->name }}</h1>
          <p>Web Designer</p>
        </div>
      </div>
      <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
      <ul class="list-unstyled">
              <li ><a href="{{ route('admin.dashboard') }}"> <i class="icon-home"></i>Home </a></li>
              <li>
                <a href="{{ route('admin.category') }}"> <i class="icon-grid"></i>Danh mục</a>
              </li>

              <li>
                <a href="{{ route('admin.brands') }}"> <i class="icon-grid"></i>Hãng</a>
              </li>
              
              <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-windows"></i>Sản phẩm</a>
                <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                  <li><a href="{{ route('admin.addproduct') }}">Thêm sản phẩm</a></li>
                  <li><a href="{{ route('admin.viewproduct') }}">Xem/Sửa/Xóa sản phẩm</a></li>
                
                </ul>
              </li>
              <li><a href="{{ route('admin.orders') }}"> <i class="icon-padnote"></i>Đơn hàng </a></li>

              <li><a href="#newsDropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-windows"></i>Tin Tức</a>
                <ul id="newsDropdown" class="collapse list-unstyled ">
                  <li><a href="{{ route('admin.addnews') }}">Thêm Tin</a></li>
                  <li><a href="">Xem/Sửa/Xóa Tin</a></li>
                
                </ul>
              </li>
      </ul>    
    </nav>