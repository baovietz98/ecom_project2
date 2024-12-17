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
    <!-- header section starts -->
    @include('home.header')
    <!-- end header section -->
    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumbs])
  </div>
  <!-- end hero area -->

  <!-- shop section -->
  <section class="shop_section layout_padding">
  <div class="container my-4">
    <h2 class="text-center mb-4">Kết quả tìm kiếm cho "{{ $search }}"</h2>

    @if($products->count() > 0)
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
    <div class="pagination justify-content-center">
      {{ $products->appends(request()->input())->links() }}
    </div>
    @else
    <p>Không tìm thấy sản phẩm phù hợp.</p>
    @endif
  </div>
</section>

  <!-- info section -->
  @include('home.footer')

</body>

</html>