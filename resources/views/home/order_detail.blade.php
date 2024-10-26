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

    .order-detail {
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

    h3 {
      color: #007bff;
      border-bottom: 2px solid #007bff;
      padding-bottom: 10px;
    }

    p {
      font-size: 16px;
      color: #333333;
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

    .back-button {
      text-align: center;
      margin-top: 20px;
    }

    .btn {
      background-color: #007bff;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .btn:hover {
      background-color: #0056b3;
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

  <div class="order-detail">
    <h2>Chi Tiết Đơn Hàng</h2>

    <h3>Thông Tin Đơn Hàng</h3>
    <p>ID Đơn Hàng: {{ $order->id }}</p>
    <p>Ngày Đặt: {{ $order->order_date }}</p>
    <p>Họ Tên: {{ $order->fullname }}</p>
    <p>Email: {{ $order->email }}</p>
    <p>Địa Chỉ: {{ $order->address }}</p>
    <p>Ghi Chú: {{ $order->note }}</p>
    <p>Trạng Thái Thanh Toán: {{ $order->payment_status }}</p>
    <p>Trạng Thái: {{ $order->status }}</p>
    <p>Tổng Tiền: {{ number_format($order->total_money, 0, ',', '.') }} VND</p>

    <h3>Chi Tiết Sản Phẩm</h3>
    <table>
      <thead>
        <tr>
          <th>Tên Sản Phẩm</th>
          <th>Số Lượng</th>
          <th>Giá</th>
          <th>Tổng Tiền</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($order->orderDetails as $detail)
        <tr>
          <td>
            <a href="{{ route('product.details', $detail->product->id) }}">
              {{ $detail->product->title }}
            </a>
          </td>
          <td>{{ $detail->num }}</td>
          <td>{{ number_format($detail->price, 0, ',', '.') }} VND</td>
          <td>{{ number_format($detail->total_money, 0, ',', '.') }} VND</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="back-button">
      <a href="{{ route('my.orders') }}" class="btn btn-secondary">Quay Lại Lịch Sử Đặt Hàng</a>
    </div>
  </div>

  <!-- info section -->
  @include('home.footer')
</body>

</html>
