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
        input[type="text"]{
            width: 350px;
            height: 50px;
        }
        textarea{
            width: 450px;
            height: 80px;
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

            <h1 style="color:white">Thêm sản phẩm</h1>

            <div class="div_deg">
                <form action="{{ route('admin.uploadproduct') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input_deg">
                        <label for="category_id">Danh mục</label>
                        <select id="category_id" name="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input_deg">
                        <label for="brands_id">Thương hiệu</label>
                        <select id="brands_id" name="brands_id" required>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="input_deg">
                        <label>Tên sản phẩm</label>
                        <input type="text" name="title" required>
                    </div>

                    <div class="input_deg">
                        <label>Giá</label>
                        <input type="number" name="price" min="0" required>
                    </div>

                    <div class="input_deg">
                        <label>Giảm giá</label>
                        <input type="number" name="discount" id="discount" step="0.01" min="0" placeholder="Nhập giá trị giảm giá">
                    </div>

                    <div class="input_deg">
                        <label>Hình ảnh sản phẩm</label>
                        <input type="file" name="thumbnail">
                    </div>

                    <div class="input_deg">
                        <label>Hình ảnh liên quan</label>
                        <input type="file" name="images[]" multiple>
                    </div>

                    <div class="input_deg">
                        <label>Mô tả</label>
                        <textarea name="description" required></textarea>
                    </div>

                    <div class="input_deg">
                        <label>Số lượng</label>
                        <input type="number" name="quantity" min="0" placeholder="Nhập số lượng">
                    </div>

                    <div class="input_deg">
                        <input class="btn btn-success" type="submit" value="Thêm sản phẩm">
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
