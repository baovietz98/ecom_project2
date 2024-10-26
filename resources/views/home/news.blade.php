<section class="shop_section layout_padding">
    <div class="container">
        <h2 class="section-title">Tin Tức Mới Nhất</h2>
        <div class="row">
            @foreach ($news as $item)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="box news-box">
                        <div class="news-item">
                            <div class="news-img-container">
                                <a href="{{ $item->href_param }}" target="_blank">
                                    <img class="news-thumbnail" src="{{ asset($item->thumbnail) }}" alt="{{ $item->title }}">
                                </a>
                            </div>
                            <div class="news-content">
                                <a href="{{ $item->href_param }}" target="_blank">
                                    <h3 class="news-title">{{ $item->title }}</h3>
                                </a>
                                <p class="news-excerpt">{{ Str::limit($item->content, 100) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


<style type="text/css">
    /* News Section Styles */
    .shop_section {
        padding: 50px 0;
        background-color: #f9f9f9;
    }

    .section-title {
        text-align: center;
        font-size: 28px;
        color: #333;
        margin-bottom: 40px;
        font-weight: bold;
        text-transform: uppercase;
        position: relative;
    }

    .section-title::after {
        content: '';
        width: 60px;
        height: 3px;
        background-color: #3498db;
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
    }

    .news-box {
        margin-bottom: 30px;
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .news-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .news-img-container {
        overflow: hidden;
        border-bottom: 1px solid #ddd;
    }

    .news-thumbnail {
        width: 100%;
        height: 200px; /* Có thể điều chỉnh tùy theo thiết kế */
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .news-box:hover .news-thumbnail {
        transform: scale(1.05);
    }

    .news-content {
        padding: 15px; /* Giảm padding để tiêu đề và nội dung gần nhau hơn */
        display: flex; /* Sử dụng flexbox */
        flex-direction: column; /* Căn chiều dọc */
        justify-content: space-between; /* Căn giữa giữa các phần tử */
        height: 100%; /* Để căn đều các box */
    }

    .news-title {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
    height: auto; /* Tự động điều chỉnh chiều cao */
    overflow: hidden;
    transition: color 0.3s ease, text-decoration 0.3s ease; /* Thêm hiệu ứng chuyển màu và gạch chân */
    }

    .news-title:hover {
        color: #3498db; /* Thay đổi màu chữ khi hover */
        text-decoration: underline; /* Thêm gạch chân khi hover */
    }


    .news-excerpt {
        color: #666;
        font-size: 14px;
        margin-bottom: 15px;
        line-height: 1.5;
        height: 60px; /* Có thể tăng giảm tùy theo thiết kế */
        overflow: hidden; /* Ẩn nội dung dài */
    }

    .read-btn {
        background-color: #3498db;
        border-color: #3498db;
        color: #fff;
        padding: 10px 20px;
        font-size: 14px;
        text-transform: uppercase;
        transition: background-color 0.3s ease;
        margin-top: auto; /* Đẩy nút xuống dưới cùng */
    }

    .read-btn:hover {
        background-color: #2980b9;
        border-color: #2980b9;
    }

    @media (max-width: 768px) {
        .news-thumbnail {
            height: 150px; /* Giảm chiều cao ảnh trên màn hình nhỏ */
        }
    }
</style>