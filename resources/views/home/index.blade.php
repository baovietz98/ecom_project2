<!DOCTYPE html>
<html>

<head>
  @include('home.css')
  
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
        @include('home.header')
    <!-- end header section -->
    <!-- slider section -->

        @include('home.slider')

    <!-- end slider section -->
    <!-- category section -->
    @include('home.category') <!-- Đặt phần danh mục ở đây -->
    <!-- end category section -->
  </div>
  <!-- end hero area -->

  <!-- shop section -->

    @include('home.product')

  <!-- end shop section -->


    @include('home.keyboards')


    @include('home.news') 

  <!-- contact section -->

    {{-- @include('home.contact') --}}
    <section class="contact_section layout_padding">
      <div class="container px-0">
        <div class="heading_container ">
          <h2 class="">
            Contact Us
          </h2>
        </div>
      </div>
      <div class="container container-bg">
        <div class="row">
          <div class="col-lg-7 col-md-6 px-0">
            <div class="map_container">
              <div class="map-responsive">
                <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&q=VTC+Academy+Plus+@10.76484118728013,106.65589280952798" width="600" height="300" frameborder="0" style="border:0; width: 100%; height:100%" allowfullscreen></iframe>
              </div>
            </div>
          </div>
      <div class="col-md-6 col-lg-5 px-0">
        
        <form action="{{ route('feedback.submit') }}" method="POST">
          @csrf
          <div>
            <input type="text" id="firstname" name="firstname" placeholder="Họ" required />
          </div>
          <div>
            <input type="text" id="lastname" name="lastname" placeholder="Tên" required />
          </div>
          <div>
            <input type="email" id="email" name="email" placeholder="Email" required />
          </div>
          <div>
            <input type="text" id="phone" name="phone" placeholder="Số Điện Thoại" />
          </div>
          <div>
            <input type="text" id="subject_name" name="subject_name" placeholder="Chủ Đề" required />
          </div>
          <div>
            <input type="text" class="message-box" id="note" name="note"  placeholder="Ghi Chú" required />
          </div>
          <div class="d-flex ">
            <button type="submit">
              Gửi Phản Hồi
            </button>
          </div>
        </form>
      </div>
      </div>
    </div>
    </section>

  <!-- end contact section -->

   

  <!-- info section -->

  @include('home.footer')

  
</body>

</html>