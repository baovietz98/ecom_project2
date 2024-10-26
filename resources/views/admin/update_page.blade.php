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
    label{
        display: inline-block;
        width: 200px;
        padding: 20px;
        color: white!important;
    }
    textarea{
        width: 500px;
        height: 100px;
    }
    input[type="text"]{
        width: 500px;
        height: 50px;
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

            <h2 style="color: white">Cập nhật sản phẩm</h2>

            <div class="div_deg">

                <form action="{{ route('admin.editproduct',$data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label>Tên sản phẩm</label>
                        <input type="text" name="title" value="{{ $data->title }}">
                    </div>

                    <div>
                        <label>Giá</label>
                        <input type="number" name="price" value="{{ $data->price }}">
                    </div>

                    <div>
                        <label>Số lượng</label>
                        <input type="number" name="quantity" value="{{ $data->quantity }}">
                    </div>

                    <div>
                        <label>Mô tả</label>
                        <textarea name="description">{{ $data->description }}</textarea>
                    </div>

                    <div>
                        <label>Ảnh sản phẩm</label>
                        <img width="150" src="/products/{{ $data->thumbnail }}" >
                    </div>

                    <div>

                        <label>Thay đổi ảnh sản phẩm</label>
                        <input type="file" name="thumbnail">

                    </div>

                    <div>
                        <input class="btn btn-success" type="submit" value="Cập nhật sản phẩm">
                    </div>

                </form>

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

