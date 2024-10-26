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
        }
        th{
          background-color: skyblue;
          color: white;
          font-size: 19px;
          font-weight: bold;
          padding: 15px;
        }
        td{
          border: 1px solid skyblue;
          text-align: center;
          color: white;
        }
        input[type="search"]{
          width: 300px;
          height: 39px;
          border-radius: 5px;
          border: 1px solid skyblue;
          padding: 5px;
          margin-top: 20px;
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

            <form action="{{ route('admin.searchproduct') }}" method="GET" >
              @csrf
              <input type="search"name="search">
              <input type="submit" class="btn btn-success" value="Tìm kiếm" >
            </form>

            <div class="div_deg">

              <table class="table_deg">

                <tr>
                  <th>Tên sản phẩm</th>

                  <th>Tên hãng</th> <!-- Thêm cột cho tên hãng -->

                  <th>Mã sản phẩm</th> <!-- Thêm cột cho mã sản phẩm -->
                  
                  <th>Giá</th>

                  <th>Số lượng</th>

                  <th>Mô tả</th>

                  <th>Hình ảnh</th>

                  <th>Sửa</th>

                  <th>Xóa</th>
                </tr>
                  @foreach ($data as $product)
                  <tr>
                    <td>{{ $product->title }}</td>

                    <td>{{ $product->brand ? $product->brand->name : 'Không có' }}</td> <!-- Hiển thị tên hãng -->
                    
                    <td>{{ $product->product_code }}</td> <!-- Hiển thị mã sản phẩm -->
  
                    <td>{{ $product->price }}</td>
  
                    <td>{{ $product->quantity }}</td>
  
                    <td>{!!Str::limit($product->description,50)!!}</td>
  
                    <td>
                      <img height="150" width="150" src="{{ asset('products/' . $product->thumbnail) }}">
                    </td>

                    <td>
                      <a href="{{ route('admin.updateproduct',$product->id) }}" class="btn btn-success">Sửa</a>
                    </td>

                    <td>
                      <a href="{{ route('admin.deleteproduct',$product->id) }}" class="btn btn-danger">Xóa</a>
                    </td>

                  </tr>
                  @endforeach
                
              </table>
            </div>

              <div class="div_deg">
                {{ $data->onEachSide(1)->links() }}
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
