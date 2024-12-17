<section class="category_section">
    <div class="container">
        {{-- <div class="heading_container heading_center">
            <h4>Danh Mục Sản Phẩm</h4>
        </div> --}}
        <nav class="navbar navbar-light bg-light">
            <form class="form-inline" action="{{ route('search.results') }}" method="GET">
                @csrf
                <input class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm sản phẩm" aria-label="Search"
                    name="search">
                <input type="submit" class="btn btn-outline-success my-2 my-sm-0" value="Tìm kiếm">
            </form>
        </nav>
        <br>
        <ul class="category_list">
            <li>
                <span class="icon"><i class="fas fa-keyboard"></i></span>
                <a href="{{ route('category.show', 'Bàn phím') }}">Bàn phím</a>
            </li>
            <li>
                <span class="icon"><i class="fas fa-mouse"></i></span>
                <a href="{{ route('category.show', 'Chuột') }}">Chuột</a>
            </li>
            <li>
                <span class="icon"><i class="fas fa-headphones-alt"></i></span>
                <a href="{{ route('category.show', 'Tai nghe') }}">Tai Nghe</a>
            </li>
        </ul>
    </div>
</section>
<style>
    .category_section {
        padding: 20px 0;
        background-color: #f9f9f9;

    }


    .category_section .heading_container {
        text-align: center;
        margin-bottom: 20px;
    }

    .category_list {
        display: flex;
        /* Thay đổi ở đây */
        justify-content: center;
        /* Căn giữa các mục */
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .category_list li {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        border-right: 1px solid #ddd;
        /* Thay đổi cho viền bên phải */
        transition: background-color 0.3s;
    }

    .category_list li:last-child {
        border-right: none;
        /* Loại bỏ viền bên phải cho mục cuối */
    }

    .category_list li:hover {
        background-color: #e9ecef;
    }

    .category_list li a {
        text-decoration: none;
        color: #333;
        font-size: 16px;
        flex-grow: 1;
    }

    .category_list li .icon {
        margin-right: 10px;
        /* Giảm khoảng cách giữa icon và text */
        font-size: 20px;
        color: #007bff;
        /* Màu cho icon */
    }

    .form-inline {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .navbar {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
