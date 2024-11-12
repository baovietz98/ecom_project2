<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')
    <style>
      .div_deg{
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 60px;
      }
      .form-control {
        font-size: 14px;
        color: white;
        border: 1px solid #ddd;
        transition: border-color 0.3s ease;
      }

      .form-control:focus {
          border-color: #007bff;
          outline: none;
          box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
      }

      .btn-primary {
          border: none;
          color: #fff;
          transition: background-color 0.3s ease;
      }

      .table {
        border: 2px solid greenyellow;
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
    </style>
  </head>
  <body>
    @include('admin.header')
    @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">
            <table class="table table-bordered">
              <thead>
              <tr>
                  <th>ID</th>
                  <th>Tên</th>
                  <th>Email</th>
                  <th>Quyền</th>
                  <th>Hành động</th>
              </tr>
              </thead>
              <tbody>
              @foreach ($data as $users)
                  <tr>
                      <td>{{ $users->id }}</td>
                      <td>{{ $users->name }}</td>
                      <td>{{ $users->email }}</td>
                      <td>
                        @if ($users->role_type == 'Admin')
                            <span class="badge bg-danger" style="font-size: 1rem; font-weight: bold; color: white;">
                                Admin
                            </span>
                        @else
                            <span class="badge bg-success" style="font-size: 1rem; font-weight: bold; color: white;">
                                User
                            </span>
                        @endif
                    </td>
                      <td>
                        <form action="{{ route('admin.updateuser', $users->id) }}" method="POST" style="display: flex; align-items: center;">
                          @csrf
                          <div style="display: flex; align-items: center; gap: 10px;">
                              <select name="role_type" class="form-control" style="width: 150px; padding: 5px; border-radius: 5px;">
                                  
                                  <option value="User" {{ $users->role_type == 'User' ? 'selected' : '' }}>User</option>
                                  <option value="Admin" {{ $users->role_type == 'Admin' ? 'selected' : '' }}>Admin</option>
                              </select>
                              <button type="submit" class="btn btn-warning" style="padding: 6px 12px; border-radius: 5px;">Cập nhật</button>
                          </div>
                      </form>
                      </td>
                  </tr>
              @endforeach
              </tbody>
          </table>
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
