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
            display:inline-block;
            width: 250px;
            font-size: 18px!important;
            color: white!important;
        }
        input[type="file"]{
            width: 350px;
            height: 50px;
        }
        .input_deg{
            padding: 15px;
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

            <h1 style="color:white">Thêm sản phẩm từ Excel</h1>

            <div class="div_deg">
                <form action="{{ route('admin.importProduct') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input_deg">
                        <label for="file">Chọn file Excel</label>
                        <input type="file" name="file" required accept=".xls,.xlsx,.csv">
                    </div>

                    <div class="input_deg">
                        <input class="btn btn-success" type="submit" value="Import Sản Phẩm">
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
   
    <script src="{{ asset('admincss/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    
    <script src="{{ asset('admincss/js/front.js') }}"></script>
  </body>
</html>
