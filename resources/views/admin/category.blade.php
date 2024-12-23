<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')
    <style>
        .div_deg {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 30px;
        }
        .table_deg {
            text-align: center;
            margin: auto;
            border: 2px solid yellowgreen;
            margin-top: 50px;
            width: 600px;
        }
        th {
            background-color: #007bff;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            color: white;
        }
        td {
            padding: 10px;
            border: 1px solid #007bff;
            color: white;
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
            <h1 style="color:white">Thêm danh mục</h1>
            <div class="div_deg">
                <form action="{{ route('admin.addcategory') }}" method="POST">
                    @csrf
                    <div>
                        <input type="text" name="name" placeholder="Tên danh mục" required>
                        <input class="btn btn-success" type="submit" value="Thêm danh mục">
                    </div>
                </form>                
            </div>
            <div>
              <table class="table_deg">
                <tr>
                  <th>Tên danh mục</th>

                  <th>Sửa</th>

                  <th>Xóa</th>
                </tr>
                @foreach ($data as $data)  
                <tr>
                  <td>{{ $data->name }}</td>

                  <td>
                    <a href="{{ route('admin.editcategory', ['id' => $data->id]) }}" class="btn btn-warning">Sửa</a>
                  </td>
                    
                    <td>
                      <form action="{{ route('admin.deletecategory', ['id' => $data->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                      </form>
                  </td>
                </tr>
                @endforeach
                
              </table>
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
