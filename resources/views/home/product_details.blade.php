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
  </style>
</head>

<body>
  <div class="hero_area">
    @include('home.header')
  </div>
  
  <!-- product details starts -->
  <section class="shop_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>Latest Products</h2>
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

            <div class="detail-box">
              <h6 class="price">Giá: <span>{{ number_format($product->price, 0, ',', '.') }}đ</span></h6>
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
            
            <div class="detail-box">
              <p>{{ $product->description }}</p>
            </div>
          </div>
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
