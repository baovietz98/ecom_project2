<!DOCTYPE html>
<html>

<head>
  @include('home.css')
  <style type="text/css">
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

    .filter-section {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    }

    .filter-section label {
        margin-right: 10px;
    }

    .filter-section .form-select, .filter-section .btn {
        min-width: 150px;
    }

    .original-price {
        text-decoration: line-through;
        color: #888888;
    }

    .discount-percentage {
        color: #FF0000;
        font-weight: bold;
    }

    .discounted-price {
        color: #FF0000;
        font-weight: bold;
        font-size: 18px;
    }

    .normal-price {
        color: #000000;
    }

    /* CSS cho nhóm nút */
    .btn-group {
        margin-top: 10px;
        display: flex;
        justify-content: space-between;
    }

    .btn-group .btn {
        flex: 1;
        margin-right: 5px;
    }

    .btn-group .btn:last-child {
        margin-right: 0;
    }

    .price-section {
    margin-top: 10px;
    }

    .price-section .original-price {
        margin-bottom: 5px;
        font-size: 14px;
    }

    .price-section .discounted-price {
        display: flex;
        align-items: center;
        font-size: 16px;
    }

    .price-section .normal-price {
        font-size: 16px;
    }

    .price-section .discount-percentage {
        margin-left: 10px;
        font-size: 14px;
    }

    .discount-badge {
      padding: 4px 8px;
      margin-left: 10px;
      font-size: 14px;
      font-weight: bold;
      color: #fff; /* Màu chữ trắng */
      background-color: #ff4d4d; /* Nền đỏ */
      border-radius: 5px; /* Bo góc nhẹ */
      text-align: center;
    }
</style>
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
        {{-- @include('home.header') --}}
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
                  <li class="nav-item active">
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
    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumbs])

    <!-- category section -->
          @include('home.category')
       
  </div>
  <!-- end hero area -->

  <!-- shop section -->

  <section class="shop_section layout_padding">
    <div class="container">
        <h2 class="mb-4">{{ $category->name }}</h2>

        <!-- Bộ lọc theo hãng -->
        <div class="filter-section mb-4">
            <form action="{{ route('category.show', ['name' => $category->name]) }}" method="GET" class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="brand" class="col-form-label fw-bold">Lọc theo hãng:</label>
                </div>
                <div class="col-auto">
                    <select name="brand" id="brand" class="form-select">
                        <option value="">Tất cả</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                </div>
            </form>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="row">

       
            @foreach ($products as $product)
         <div class="col-sm-6 col-md-4 col-lg-3">
           <div class="box">
             
               <div class="img-box">
                <img src="{{ asset('products/' . $product->thumbnail) }}" alt="{{ $product->title }}" class="img-fluid">
               </div>
               <div class="detail-box">
                 <a href="{{ url('product_details', $product->id) }}">
                   <h6>{{ Str::limit($product->title, 40) }}</h6>
               </a>
                 <!-- Hiển thị thương hiệu sản phẩm -->
                 <h6 class="price">Thương hiệu: <span>{{ $product->brand->name }}</span></h6> 
                 <!-- Hiển thị giá và giảm giá -->
                 <div class="price-section">
                   @if($product->discount > 0)
                       <!-- Giá gốc -->
                       <h6 class="original-price text-muted text-decoration-line-through">
                           {{ number_format($product->price, 0, ',', '.') }}đ
                       </h6>
                       <!-- Giá sau khi giảm và phần trăm giảm giá -->
                       <h5 class="discounted-price text-danger fw-bold">
                         {{ number_format($product->price * (1 - $product->discount), 0, ',', '.') }}đ
                         <span class="discount-badge">-{{ $product->discount * 100 }}%</span>
                       </h5>
                   @else
                       <!-- Giá không giảm -->
                       <h5 class="normal-price text-dark fw-bold">
                           {{ number_format($product->price, 0, ',', '.') }}đ
                       </h5>
                   @endif
               </div>
             </div>
             
             <div class="d-flex justify-content-between mt-3">
                <!-- Nút Details -->
                <a href="{{ url('product_details', $product->id) }}" class="btn btn-details">
                    <i class="fas fa-info-circle"></i> View Details
                </a>
            
                <!-- Nút Add to Cart -->
                <a href="{{ url('add_cart', $product->id) }}" class="btn btn-add-to-cart">
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                </a>
            </div>
 
           </div>
         </div>
         @endforeach 
 
 
 
       </div>

        <!-- Phân trang -->
        <div class="pagination">
            {{ $products->links() }}
        </div>
    </div>
</section>
        

  <!-- end shop section -->







  

   

  <!-- info section -->

  @include('home.footer')

  
</body>

</html>