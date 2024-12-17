<section class="shop_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>Bàn Phím Mới Nhất</h2>
        </div>
        <div class="row">
            @if(isset($keyboards) && !$keyboards->isEmpty())
                @foreach ($keyboards as $keyboard)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="box">
                            <div class="img-box">
                                <img src="{{ asset('products/' . $keyboard->thumbnail) }}" alt="{{ $keyboard->title }}">
                            </div>
                            <div class="detail-box">
                                <a href="{{ url('product_details', $keyboard->id) }}">
                                  <h6>{{ Str::limit($keyboard->title, 40) }}</h6>
                              </a>
                                <!-- Hiển thị thương hiệu sản phẩm -->
                                <h6 class="price">Thương hiệu: <span>{{ $keyboard->brand->name }}</span></h6> 
                                <!-- Hiển thị giá và giảm giá -->
                                <div class="price-section">
                                  @if($keyboard->discount > 0)
                                      <!-- Giá gốc -->
                                      <h6 class="original-price text-muted text-decoration-line-through">
                                          {{ number_format($keyboard->price, 0, ',', '.') }}đ
                                      </h6>
                                      <!-- Giá sau khi giảm và phần trăm giảm giá -->
                                      <h5 class="discounted-price text-danger fw-bold">
                                        {{ number_format($keyboard->price * (1 - $keyboard->discount), 0, ',', '.') }}đ
                                        <span class="discount-badge">-{{ $keyboard->discount * 100 }}%</span>
                                      </h5>
                                  @else
                                      <!-- Giá không giảm -->
                                      <h5 class="normal-price text-dark fw-bold">
                                          {{ number_format($keyboard->price, 0, ',', '.') }}đ
                                      </h5>
                                  @endif
                              </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <!-- Nút Details -->
                                <a href="{{ url('product_details', $keyboard->id) }}" class="btn btn-details">
                                    <i class="fas fa-info-circle"></i> View Details
                                </a>
                            
                                <!-- Nút Add to Cart -->
                                <a href="{{ url('add_cart', $keyboard->id) }}" class="btn btn-add-to-cart">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Hiện tại không có sản phẩm bàn phím nào.</p>
            @endif
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('category.show','Bàn phím') }}" class="btn btn-primary">Xem thêm Bàn Phím</a>
        </div>
    </div>
</section>
