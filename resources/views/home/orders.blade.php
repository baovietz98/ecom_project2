<!DOCTYPE html>
<html>

<head>
  @include('home.css')
  <style type="text/css">
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 20px;
    }

    .order-history {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      max-width: 800px;
      margin: 20px auto;
    }

    h2 {
      text-align: center;
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #007bff;
      color: white;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    a {
      color: #007bff;
      text-decoration: none;
      transition: color 0.3s;
    }

    a:hover {
      color: #0056b3;
    }

    /* Responsive design */
    @media (max-width: 600px) {
      .order-history {
        padding: 10px;
      }

      th, td {
        padding: 8px;
        font-size: 14px;
      }

      h2 {
        font-size: 20px;
      }
    }
    .nav-item a {
        color: #000; /* Màu chữ ban đầu */
        padding: 10px;
        transition: background-color 0.3s ease, color 0.3s ease; /* Hiệu ứng chuyển */
    }

    .nav-item a:hover {
        background-color: #eeeeee; /* Màu nền khi hover */
        color: #fff; /* Màu chữ khi hover */
        border-radius: 5px; /* Làm góc tròn */
    }
    .pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    }
  </style>
</head>

<body>
  <div class="hero_area">
    <!-- header section starts -->
    <header class="header_section">
      <nav class="navbar navbar-expand-lg custom_nav-container ">
        <a class="navbar-brand" href="/">
          <span>
            Gear Shop
          </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class=""></span>
        </button>
  
        <div class="collapse navbar-collapse innerpage_navbar" id="navbarSupportedContent">
          <ul class="navbar-nav  ">
            <li class="nav-item ">
              <a class="nav-link" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('shop') }}">
                Shop
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('why-us') }}">
                Why Us
              </a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="{{ route('my.orders') }}">
                Lịch sử đặt hàng
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('feedback') }}">CSKH</a>
            </li>
          </ul>
          <div class="user_option">
              @if (Route::has('login'))
                  @auth
                      <a href="{{ url('mycart') }}" class="icon-link">
                          <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                          [{{ $count }}]
                      </a>
          
                      <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          {{ Auth::user()->name }}
                      </button>
                          <div class="dropdown-menu" aria-labelledby="userDropdown">
                              <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                              <form method="POST" action="{{ route('logout') }}">
                                  @csrf
                                  <button type="submit" class="dropdown-item">Đăng xuất</button>
                              </form>
                          </div>
                      </div>
          
                  @else
                      <a href="{{ url('/login') }}">
                          <i class="fa fa-user" aria-hidden="true"></i>
                          <span>Đăng nhập</span>
                      </a>
                      <a href="{{ url('/register') }}">
                          <i class="fa fa-vcard" aria-hidden="true"></i>
                          <span>Đăng kí</span>
                      </a>
                  @endauth
              @endif
          </div>
        </div>
      </nav>
    </header>
    <!-- end header section -->
  </div>
  <!-- end hero area -->
  @include('components.breadcrumb', ['breadcrumbs' => $breadcrumbs])
  <div class="order-history">
    <h2>Lịch Sử Đặt Hàng</h2>
    <div class="table-responsive"> <!-- Sử dụng lớp table-responsive để làm bảng phản hồi -->
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID Đơn Hàng</th>
          <th>Ngày Đặt</th>
          <th>Họ Tên</th>
          <th>Email</th>
          <th>Trạng Thái</th>
          <th>Chi Tiết</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($orders as $order)
        <tr>
          <td>{{ $order->id }}</td>
          <td>{{ $order->order_date }}</td>
          <td>{{ $order->fullname }}</td>
          <td>{{ $order->email }}</td>
          <td>
            @if($order->status == 'pending')
              <span class="badge bg-warning">Đang xử lý</span>
            @else($order->status == 'completed')
              <span class="badge bg-success">Đã xử lý</span>
            @endif
          </td>
          <td>
            <a href="{{ route('order.details', $order->id) }}">Xem Chi Tiết</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    </div>
       <!-- Hiển thị liên kết phân trang -->
        <div class="pagination">
          {{ $orders->links() }}
      </div>
  </div>

  <!-- info section -->
  @include('home.footer')
</body>

</html>
