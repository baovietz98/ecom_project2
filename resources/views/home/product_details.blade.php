<!DOCTYPE html>
<html>

<head>
  @include('home.css')
  <style type="text/css">
    .div_center {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 30px;
    }
    .detail-box {
      padding: 15px;
    }
    .slideshow-container {
      position: relative;
      max-width: 80%; /* Giữ kích thước tổng thể của slideshow */
      margin: auto;
    }
    .mySlides {
      display: none;
      text-align: center; /* Căn giữa hình ảnh */
    }
    
    img {
      max-width: 100%; /* Giữ kích thước hình ảnh không vượt quá 100% */
      height: auto; /* Để giữ tỷ lệ khung hình */
    }
    .prev, .next {
      cursor: pointer;
      position: absolute;
      top: 50%; /* Đặt nút ở giữa hình ảnh */
      width: auto;
      padding: 16px;
      color: white;
      font-weight: bold;
      font-size: 18px;
      transition: 0.6s ease;
      border-radius: 0 3px 3px 0;
      user-select: none;
    }
    .next {
      right: 0; /* Đặt nút next ở bên phải */
      border-radius: 3px 0 0 3px; /* Để hình dạng đẹp hơn */
    }
    .prev:hover, .next:hover {
      background-color: rgba(0, 0, 0, 0.8); /* Nền tối khi hover */
    }

    .price-section {
    padding: 15px;
    }

    .price-section .original-price {
        margin-bottom: 5px;
        font-size: 14px;
        text-decoration: line-through; /* Gạch chân giá cũ */
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
    @include('home.header')
  </div>
  
  @include('components.breadcrumb', ['breadcrumbs' => $breadcrumbs])

  <!-- product details starts -->
  <section class="shop_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>Chi tiết sản phẩm</h2>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="slideshow-container">
              <!-- Hình ảnh thumbnail chính -->
              <div class="mySlides">
                <img src="/products/{{ $product->thumbnail }}" alt="Thumbnail">
              </div>

              <!-- Hình ảnh liên quan -->
              @foreach($product->images as $image)
                <div class="mySlides">
                  <img src="{{ asset($image->image_path) }}" alt="Product Image">
                </div>
              @endforeach

              <!-- Các nút điều khiển slideshow -->
              <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
              <a class="next" onclick="plusSlides(1)">&#10095;</a>
            </div>

            <div class="detail-box">
              <h6>{{ $product->title }}</h6>
            </div>

            <div class="detail-box">
              <h6 class="price">Thương hiệu: <span>{{ $product->brand->name }}</span></h6> 
            </div>

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

            <div class="detail-box">
              <h6>Tình Trạng: 
                @if($product->quantity >= 1)
                <span class="badge bg-success" style="color: white;">Còn hàng</span>
                @else
                <span class="badge bg-danger" style="color: white;">Hết hàng</span>
                @endif
              </h6> 
            </div>

            <div class="d-flex justify-content-between mt-3">
              <!-- Nút Add to Cart -->
              <a href="{{ url('add_cart', $product->id) }}" class="btn btn-add-to-cart" id="addtocart">
                <i class="fas fa-shopping-cart"></i> Add to Cart
              </a>
          </div>
            
            <div class="detail-box">
              <p>{!! $product->description !!}</p>
            </div>
          </div>
        </div>
      </div>
      <!-- Phần sản phẩm gợi ý -->
      <div class="related-products mt-5">
        <h3 class="text-center mb-4">Sản phẩm liên quan</h3>
        <div class="row">
          @foreach($relatedProducts as $related)
          <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="box">
              
                <div class="img-box">
                  <img src="{{ asset('products/' . $related->thumbnail) }}" alt="{{ $related->title }}" class="img-fluid">
                </div>
                <div class="detail-box">
                  <a href="{{ url('product_details', $related->id) }}">
                    <h6>{{ Str::limit($related->title, 40) }}</h6>
                </a>
                  <!-- Hiển thị thương hiệu sản phẩm -->
                  <h6 class="price">Thương hiệu: <span>{{ $related->brand->name }}</span></h6> 
                  <!-- Hiển thị giá và giảm giá -->
                  <div class="price-section">
                    @if($related->discount > 0)
                        <!-- Giá gốc -->
                        <h6 class="original-price text-muted text-decoration-line-through">
                            {{ number_format($related->price, 0, ',', '.') }}đ
                        </h6>
                        <!-- Giá sau khi giảm và phần trăm giảm giá -->
                        <h5 class="discounted-price text-danger fw-bold">
                          {{ number_format($related->price * (1 - $related->discount), 0, ',', '.') }}đ
                          <span class="discount-badge">-{{ $related->discount * 100 }}%</span>
                        </h5>
                    @else
                        <!-- Giá không giảm -->
                        <h5 class="normal-price text-dark fw-bold">
                            {{ number_format($related->price, 0, ',', '.') }}đ
                        </h5>
                    @endif
                </div>
              </div>
              
              <div class="d-flex justify-content-between mt-3">
                <!-- Nút Details -->
                <a href="{{ url('product_details', $related->id) }}" class="btn btn-details">
                    <i class="fas fa-info-circle"></i> View Details
                </a>
            
                <!-- Nút Add to Cart -->
                <a href="{{ url('add_cart', $related->id) }}" class="btn btn-add-to-cart">
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                </a>
            </div>
  
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>
  <!-- end product details -->

  <!-- JavaScript cho slideshow -->
  <script>
    let slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
      showSlides(slideIndex += n);
    }

    function showSlides(n) {
      let i;
      let slides = document.getElementsByClassName("mySlides");
      if (n > slides.length) { slideIndex = 1 }
      if (n < 1) { slideIndex = slides.length }
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
      }
      slides[slideIndex - 1].style.display = "block";  
    }
  </script>

  @include('home.footer')
</body>

</html>
