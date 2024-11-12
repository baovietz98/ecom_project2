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
            <div class="container mt-5">
                <h2 class="mb-4">Danh sách Feedbacks</h2>
            
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Subject Name</th>
                            <th>Note</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $feedback)
                            <tr>
                                <td>{{ $feedback->id }}</td>
                                <td>{{ $feedback->firstname }}</td>
                                <td>{{ $feedback->lastname }}</td>
                                <td>{{ $feedback->email }}</td>
                                <td>{{ $feedback->phone }}</td>
                                <td>{{ $feedback->subject_name }}</td>
                                <td>{{ $feedback->note }}</td>
                                <td>
                                    @if ($feedback->status == 0)
                                        <span class="badge bg-danger">Chưa xử lý</span>
                                    @elseif ($feedback->status == 1)
                                        <span class="badge bg-success">Đã xử lý</span>
                                    @endif
                                </td>
                                <td>{{ $feedback->created_at->format('d-m-Y H:i:s') }}</td>
                                <td>
                                    <form action="{{ route('admin.updatefeedback', $feedback->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Xử lý</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
