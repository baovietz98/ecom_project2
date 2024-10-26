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
        input[type="text"], textarea {
            width: 350px;
            height: 50px;
        }
        textarea {
            height: 100px;
        }
        .input_deg {
            padding: 15px;
        }
    </style>
  </head>
  <body>
    @include('admin.header')
    @include('admin.sidebar')
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <h1 style="color:white">Thêm tin tức</h1>
            <div class="div_deg">
                <form action="{{ route('admin.uploadnews') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input_deg">
                        <label for="title">Tiêu đề:</label>
                        <input type="text" id="title" name="title" required>
                    </div>

                    <div class="input_deg">
                        <label for="href_param">Liên kết bài viết:</label>
                        <input type="text" id="href_param" name="href_param" required>
                    </div>

                    <div class="input_deg">
                        <label for="thumbnail">Hình ảnh:</label>
                        <input type="file" id="thumbnail" name="thumbnail" required>
                    </div>

                    <div class="input_deg">
                        <label for="content">Nội dung:</label>
                        <textarea id="content" name="content" required></textarea>
                    </div>


                    <div class="input_deg">
                        <input class="btn btn-success" type="submit" value="Thêm tin tức">
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>

    <!-- JavaScript files -->
    <script src="{{ asset('admincss/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/popper.js/umd/popper.min.js') }}"> </script>
    <script src="{{ asset('admincss/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admincss/vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
    <script src="{{ asset('admincss/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('admincss/js/charts-home.js') }}"></script>
    <script src="{{ asset('admincss/js/front.js') }}"></script>
  </body>
</html>
