<header class="header_section">
    <nav class="navbar navbar-expand-lg custom_nav-container ">
      <a class="navbar-brand" href="/">
        <span>
          Gear Shop
        </span>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class=""></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent" style="background-color: #E3F2FD;">
        <ul class="navbar-nav  ">
          <li class="nav-item active">
            <a class="nav-link" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('shop') }}">
              Shop
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('why-us') }}">
              Why Us
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('my.orders') }}">
              Lịch sử đặt hàng
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('feedback') }}">CSKH</a>
          </li>
        </ul>
        <div class="user_option">
          @if (Route::has('login'))
              @auth
                  <a href="{{ url('mycart') }}" class="icon-link">
                      <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                      [{{ $count }}]
                  </a>
      
                  <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      {{ Auth::user()->name }}
                  </button>
                      <div class="dropdown-menu" aria-labelledby="userDropdown">
                          <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                          <form method="POST" action="{{ route('logout') }}">
                              @csrf
                              <button type="submit" class="dropdown-item">Đăng xuất</button>
                          </form>
                      </div>
                  </div>
      
              @else
                  <a href="{{ url('/login') }}">
                      <i class="fa fa-user" aria-hidden="true"></i>
                      <span>Đăng nhập</span>
                  </a>
                  <a href="{{ url('/register') }}">
                      <i class="fa fa-vcard" aria-hidden="true"></i>
                      <span>Đăng kí</span>
                  </a>
              @endauth
          @endif
      </div>
      
      </div>
    </nav>
  </header>
  