<section class="shop_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Latest Products
        </h2>
      </div>
      <div class="row">

       
           @foreach ($products as $product)
        <div class="col-sm-6 col-md-4 col-lg-3">
          <div class="box">
            
              <div class="img-box">
                <img src="products/{{ $product->thumbnail }}" alt="">
              </div>
              <div class="detail-box">
                <a href="{{ url('product_details', $product->id) }}">
                  <h6>{{ Str::limit($product->title, 40) }}</h6>
              </a>
                <!-- Hiển thị thương hiệu sản phẩm -->
                <h6 class="price">Thương hiệu: <span>{{ $product->brand->name }}</span></h6> 
                <h6 class="price">Giá: <span>{{ number_format($product->price, 0, ',', '.') }}đ</span></h6> <!-- Giá tiền -->
            </div>
            
            <div>
              <a class="btn btn-danger" href="{{ url('product_details',$product->id) }}" style="padding: 10px 20px; font-size: 16px;">Details</a>

              <a href="{{ url('add_cart',$product->id) }}" class="btn btn-success" style="padding: 10px 20px; font-size: 16px;">Add to Cart</a>

            </div>

          </div>
        </div>
        @endforeach 



      </div>
    </div>
  </section>
  <style type="text/css">
    a:hover h6 {
    color: #3498db; /* Thay đổi màu khi hover */
    text-decoration: underline; /* Gạch chân khi hover */
  } 
  </style>