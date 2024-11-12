<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')
    <style type="text/css">
        .div_deg{
          display: flex;
          justify-content: center;
          align-items: center;
          margin-top: 60px;
        }
        .table_deg{
          border: 2px solid greenyellow;
          width: 100%;
        }
        th{
          background-color:#007bff;
          color: white;
          font-size: 19px;
          font-weight: bold;
          padding: 15px;
        }
        td{
          border: 1px solid #007bff;
          text-align: center;
          color: white;
        }
        input[type="search"]{
          width: 300px;
          height: 39px;
          border-radius: 5px;
          border: 1px solid #007bff;
          padding: 5px;
          margin-top: 20px;
        }
        .status-pending{
          background-color: orange;
          color: white;
        }
        .status-shipped{
          background-color: green;
          color: white;
        }
        .order-details {
          background-color: #2d2d2d;
          padding: 10px;
          margin-top: 10px;
        }
        .order-details th, .order-details td {
          color: #ddd;
          padding: 5px;
        }
        .order-details {
          background-color: #2d2d2d;
          padding: 10px;
          margin-top: 10px;
          display: none;
        }

        .btn-info {
          margin-left: 5px;
      }

      .btn {
          width: 150px; /* Thiết lập chiều rộng cho cả hai nút */
          height: 40px; /* Thiết lập chiều cao cho cả hai nút */
          padding: 0; /* Loại bỏ padding để đảm bảo kích thước chính xác */
          margin-top: 5px; /* Khoảng cách giữa các nút */
      }

      .form-group {
         margin: 20px 0;
      }

      .custom-select {
          width: 250px; /* Điều chỉnh chiều rộng dropdown */
          height: 40px; /* Điều chỉnh chiều cao */
          font-size: 16px; /* Thay đổi kích thước font */
          border: 1px solid #007bff; /* Đường viền màu xanh */
          border-radius: 5px; /* Viền bo tròn */
          padding: 0 10px; /* Thêm khoảng cách trong */
          background-color: #f8f9fa; /* Màu nền sáng */
          transition: border-color 0.3s ease; /* Hiệu ứng chuyển đổi khi focus */
      }

      .custom-select:focus {
          border-color: #28a745; /* Màu viền khi focus */
          box-shadow: 0 0 5px rgba(40, 167, 69, 0.5); /* Hiệu ứng shadow khi focus */
      }

      label {
          font-size: 18px; /* Kích thước chữ label */
          color: #343a40; /* Màu chữ đen */
          font-weight: bold; /* Chữ đậm */
      }
      
    </style>
  </head>
  <body>
    @include('admin.header')
    @include('admin.sidebar')
    <!-- Sidebar Navigation end-->
    <div class="page-content">
      <div class="page-header">
        <div class="container-fluid">

          <form action="{{ route('admin.searchOrder') }}" method="GET">
            <input type="search" name="search" placeholder="Tìm kiếm đơn hàng">
            <input type="submit" class="btn btn-success" value="Tìm kiếm">
        </form>

          <form action="{{ route('admin.orders') }}" method="GET">
            <div class="form-group">
                <label for="status" class="font-weight-bold">Trạng thái đơn hàng</label>
                <select name="status" id="status" class="custom-select" onchange="this.form.submit()">
                    <option value="">Tất cả</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Đang chờ xử lý</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Đã xử lý</option>
                </select>
            </div>
        </form>

          <div class="div_deg">
            <table class="table_deg">
              <tr>
                <th>ID Đơn Hàng</th>
                <th>Tên Khách Hàng</th>
                <th>Email</th>
                <th>Số Điện Thoại</th>
                <th>Địa Chỉ</th>
                <th>Trạng Thái</th>
                <th>Ngày Đặt</th>
                <th>Hành Động</th>
              </tr>
              @foreach ($orders as $order)
              <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->fullname }}</td>
                <td>{{ $order->email }}</td>
                <td>{{ $order->phone }}</td>
                <td>{{ $order->address }}</td>
                <td>
                  @if($order->status == 'pending')
                  <span class="badge bg-warning" style="font-size: 1rem; font-weight: bold;">Đang chờ xử lý</span>
                  @else
                  <span class="badge bg-success" style="font-size: 1rem; font-weight: bold;">Đã xử lý</span>
                  @endif
                </td>
                <td>{{ $order->order_date }}</td>
                <td>
                  @if($order->status == 'pending')
                  <form action="{{ route('admin.updateOrderStatus', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Xử Lý</button>
                  </form>
                  @else
                  <span class="badge bg-success ">Đã xử lý</span>
                  @endif
                  <button class="btn btn-info btn-sm view-details" data-order-id="{{ $order->id }}">Xem chi tiết</button>
                </td>
              </tr>
              <tr>
                <td colspan="8">
                  <div id="order-details-{{ $order->id }}" class="order-details">
                    <table class="table table-sm">
                      <tr>
                        <th>Tên Sản Phẩm</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                      </tr>
                      @foreach ($order->orderDetails as $detail)
                        <tr>
                            <td>{{ $detail->product->title }}</td> <!-- Tên sản phẩm -->
                            <td>{{ $detail->num }}</td> <!-- Số lượng -->
                            <td>{{ number_format($detail->price, 0, ',', '.') }} VND</td> <!-- Giá -->
                            <td>{{ number_format($detail->total_money, 0, ',', '.') }} VND</td> <!-- Tổng -->
                        </tr>
                        @endforeach
                    </table>
                  </div>
                </td>
              </tr>
              @endforeach
            </table>
          </div>

                <!-- Bao gồm jQuery và script của bạn -->
                <script src="{{ asset('admincss/vendor/jquery/jquery.min.js') }}"></script>
                <script>
                  $(document).ready(function() {
                      $('.view-details').click(function() {
                          var orderId = $(this).data('order-id');
                          $('#order-details-' + orderId).toggle();
                  
                          // Thay đổi chữ trên nút
                          if ($('#order-details-' + orderId).is(':visible')) {
                              $(this).text('Ẩn chi tiết');
                          } else {
                              $(this).text('Xem chi tiết');
                          }
                      });
                  });
                  </script>

          <div class="div_deg">
            {{ $orders->onEachSide(1)->links() }}
          </div>

        </div>
      </div>
    </div>
    
    <!-- JavaScript files-->
    <script src="{{ asset('admincss/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/popper.js/umd/popper.min.js') }}"> </script>
    <script src="{{ asset('admincss/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
    <script src="{{ asset('admincss/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admincss/js/charts-home.js') }}"></script>
    <script src="{{ asset('admincss/js/front.js') }}"></script>
  </body>
</html>
