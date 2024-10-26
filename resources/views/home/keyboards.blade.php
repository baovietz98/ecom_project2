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
                                <h6 class="price">Thương hiệu: <span>{{ $keyboard->brand->name }}</span></h6> 
                                <h6 class="price">Giá: <span>{{ number_format($keyboard->price, 0, ',', '.') }}đ</span></h6>
                            </div>
                            <div>
                                <a class="btn btn-danger" href="{{ url('product_details', $keyboard->id) }}" style="padding: 10px 20px; font-size: 16px;">Details</a>
                                <a href="{{ url('add_cart', $keyboard->id) }}" class="btn btn-success" style="padding: 10px 20px; font-size: 16px;">Add to cart </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Hiện tại không có sản phẩm bàn phím nào.</p>
            @endif
        </div>
        <div class="text-center mt-3">
            <a href="{{ url('category/1') }}" class="btn btn-primary">Xem thêm Bàn Phím</a>
        </div>
    </div>
</section>
