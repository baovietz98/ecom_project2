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
            @csrf
            <input type="search" name="search" placeholder="Tìm kiếm đơn hàng">
            <input type="submit" class="btn btn-success" value="Tìm kiếm" >
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
                <td class="{{ $order->status == 'pending' ? 'status-pending' : 'status-shipped' }}">
                  {{ $order->status == 'pending' ? 'Đang chờ xử lý' : 'Đã chuyển hàng' }}
                </td>
                <td>{{ $order->order_date }}</td>
                <td>
                  @if($order->status == 'pending')
                  <form action="{{ route('admin.updateOrderStatus', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Xử Lý</button>
                  </form>
                  @else
                  <span>Đã xử lý</span>
                  @endif
                </td>
              </tr>
              <tr>
                <td colspan="8">
                  <div class="order-details">
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
