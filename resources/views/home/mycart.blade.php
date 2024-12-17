<!DOCTYPE html>
<html>

<head>
  @include('home.css')
  <style type="text/css">
    .hero_area {
      margin-bottom: 60px; /* Thêm khoảng cách dưới hero_area */
    }

    .container {
      display: flex;
      justify-content: center; /* Căn giữa các phần */
      align-items: flex-start; /* Căn các phần lên trên */
      gap: 40px; /* Khoảng cách giữa bảng và form */
      margin: 0 auto;
      max-width: 1200px; /* Giới hạn chiều rộng tối đa */
    }

    .cart_table {
      flex: 1; /* Cho bảng giỏ hàng chiếm không gian tối đa */
      max-width: 800px; /* Giới hạn chiều rộng của bảng */
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table, th, td {
      border: 1px solid black;
    }

    th, td {
      padding: 15px;
      text-align: center;
    }

    th {
      background-color: #f2f2f2;
    }

    /* Thêm phong cách cho order form */
    .order_form {
      width: 400px; /* Đặt chiều rộng của form */
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background-color: #f9f9f9;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .order_form h3 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    .order_form div {
      margin-bottom: 15px;
    }

    .order_form label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
      color: #555;
    }

    .order_form input[type="text"],
    .order_form input[type="email"],
    .order_form textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      transition: border-color 0.3s;
    }

    .order_form input[type="text"]:focus,
    .order_form input[type="email"]:focus,
    .order_form textarea:focus {
      border-color: #007bff; /* Màu khi focus */
      outline: none; /* Bỏ outline mặc định */
    }

    .order_form button {
      width: 100%;
      padding: 10px;
      background-color: #FEC401;
      color: #000; /* Màu chữ đen */
      border: none;
      border-radius: 25px; /* Bo tròn giống nút thanh toán thẻ */
      padding: 10px 20px;
      font-weight: bold;
      text-decoration: none;
      transition: background-color 0.3s ease; /* Hiệu ứng hover */
    }

    .order_form button:hover {
      background-color: #E3AC00; /* Màu hover vàng cam đậm */
      text-decoration: none;
      cursor: pointer;
    }
    .cart_value {
      margin-bottom: 70px;
      text-align: center;
      padding: 20px;

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
    
    .btn-checkout {
      width: 100%; /* Chiều rộng nút */
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background-color: #B2FCE4; /* Màu cam tương tự Amazon */
      color: #000; 
      border: none; /* Bỏ viền */
      border-radius: 25px; /* Bo tròn nút */
      padding: 10px 20px; /* Khoảng cách trong nút */
      font-size: 16px; /* Kích thước chữ */
      font-weight: bold; /* Chữ đậm */
      text-decoration: none; /* Bỏ gạch chân */
      transition: background-color 0.3s ease; /* Hiệu ứng hover */
    }

    .btn-checkout i {
      margin-right: 10px; /* Khoảng cách giữa icon và chữ */
      font-size: 18px; /* Kích thước icon */
    }

    .btn-checkout:hover {
      background-color: #91E5C9; /* Hover màu xanh ngọc đậm hơn */
      text-decoration: none; /* Bỏ gạch chân khi hover */
      cursor: pointer;
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
            <li class="nav-item ">
              <a class="nav-link" href="{{ route('shop') }}">
                Shop
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('why-us') }}">
                Why Us
              </a>
            </li>
            <li class="nav-item">
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

  <div class="container">
    <div class="cart_table">
      <table>
        <tr>
          <th>Tên sản phẩm</th>
          <th>Số lượng</th>
          <th>Giá</th>
          <th>Hình ảnh</th>
          <th>Hành động</th>
        </tr>

        <?php 
        $total = 0; 
        ?>

        @foreach ($cart as $cart)
        <tr>
          <td>{{ $cart->product->title }}</td>
          <td>
            <div style="display: flex; align-items: center;">
                <form action="{{ url('update_cart_quantity', $cart->id) }}" method="POST" style="margin-right: 5px;">
                    @csrf
                    <input type="hidden" name="action" value="decrease">
                    <button type="submit" class="btn btn-secondary">-</button>
                </form>
    
                <span  style="margin: 0 10px;">{{ $cart->quantity }}</span>
    
                <form action="{{ url('update_cart_quantity', $cart->id) }}" method="POST" style="margin-left: 5px;">
                    @csrf
                    <input type="hidden" name="action" value="increase">
                    <button type="submit" class="btn btn-secondary">+</button>
                </form>
            </div>
          </td>
            <td>
              @if($cart->product->discount > 0)
                  <span class="text-danger fw-bold">
                      {{ number_format($cart->product->price * (1 - $cart->product->discount), 0, ',', '.') }}đ
                  </span>
              @else
                  {{ number_format($cart->product->price, 0, ',', '.') }}đ
              @endif
          </td>
          <td>
            <img width="150" src="/products/{{ $cart->product->thumbnail }}" alt="">
          </td>
          <td>
            <a href="{{ url('delete_cart',$cart->id) }}" class="btn btn-danger">Xóa</a>
          </td>
        </tr>
        <?php
        $total += $cart->quantity * ($cart->product->discount > 0 
          ? ($cart->product->price * (1 - $cart->product->discount)) 
          : $cart->product->price);
        ?>
        @endforeach
        
      </table>
      <div class="cart_value">
        <h3>Tổng tiền : {{ number_format($total, 0, ',', '.') }} VND</h3>
      </div>
    </div>
    

    <!-- Thêm form đặt hàng -->
    <div class="order_form">
      <h3>Thông tin đặt hàng</h3>
      <form method="POST" action="{{ route('place.order') }}">
        @csrf
        <div>
          <label for="fullname">Họ tên:</label>
          <input type="text" id="fullname" name="fullname" required>
        </div>
        <div>
          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div>
          <label for="phone">Số điện thoại:</label>
          <input type="text" id="phone" name="phone" required>
        </div>
        <div>
          <label for="address">Địa chỉ:</label>
          <input type="text" id="address" name="address" required>
        </div>
        <div>
          <label for="note">Ghi chú:</label>
          <textarea id="note" name="note"></textarea>
        </div>
        <div>
          <button type="submit" {{ $cart->count() === 0 ? 'disabled' : '' }}>THANH TOÁN KHI NHẬN</button>
      </div>
      <a class="btn btn-checkout" href="{{ $cart->count() === 0 ? '#' : url('stripe', $total) }}" 
          onclick="{{ $cart->count() === 0 ? 'event.preventDefault(); alert(\'Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi thanh toán.\');' : '' }}">
          <i class="fas fa-credit-card"></i>THANH TOÁN THẺ
      </a>
      </form>
    </div>
  </div>

  <!-- info section -->
  @include('home.footer')
</body>

</html>
