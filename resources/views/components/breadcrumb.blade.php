<div class="breadcrumb-container">
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach($breadcrumbs as $breadcrumb)
        @if($loop->last) 
            <!-- Breadcrumb cuối không có link -->
            <li class="breadcrumb-item active" aria-current="page">
                {{ $breadcrumb['name'] }}
            </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ $breadcrumb['url'] }}"></i>{{ $breadcrumb['name'] }}</a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>
</div>
<style>
    /* CSS cho breadcrumb */
    .breadcrumb-container {
    display: flex;
    justify-content: center; /* Căn giữa theo chiều ngang */
    align-items: center; /* Căn giữa theo chiều dọc (nếu cần) */
    margin-top: 20px; /* Khoảng cách phía trên */
    margin-bottom: 20px; /* Khoảng cách phía dưới */
}
    .breadcrumb {
    background-color: transparent; /* Xóa màu nền */
    padding: 10px 0; /* Thêm khoảng cách trên dưới */
    margin-bottom: 20px;
    list-style: none;
    display: flex;
    align-items: center; /* Căn giữa theo chiều dọc */
    font-size: 14px;
    color: #6c757d; /* Màu chữ nhạt */
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "/"; /* Biểu tượng phân cách */
    padding: 0 8px; /* Khoảng cách hai bên */
    color: #6c757d; /* Màu nhạt cho phân cách */
}

.breadcrumb-item a {
    color: #007bff; /* Màu xanh tiêu chuẩn */
    text-decoration: none; /* Xóa gạch chân */
    font-weight: 500; /* Đậm nhẹ */
}

.breadcrumb-item a:hover {
    color: #0056b3; /* Đổi màu khi hover */
    text-decoration: underline; /* Gạch chân khi hover */
}

.breadcrumb-item.active {
    color: #495057; /* Màu xám đậm */
    font-weight: bold; /* Đậm hơn */
}

.breadcrumb-item i {
    margin-right: 5px; /* Khoảng cách giữa icon và text */
    font-size: 16px; /* Kích thước icon */
    color: #007bff; /* Màu xanh đồng bộ */
}

</style>