
  <header id="header" class="fixed-top bg-secondary">
    <div class="container d-flex">

      <div class="logo mr-auto">
        <img src="{{asset('assets/img/uml.png')}}" alt="">
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/uml.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="active"><a href="#hero" class=" text-white ml-2">Home</a></li>
          
          <li><a href="#pricing"class=" text-white ml-2">Pricing</a></li>
          
          
          @auth
          <li><a href="{{ route('dashboard') }}" class="btn btn-primary text-white ml-2">Inicio</a></li>
          @else
          <li><a href="{{ route('login') }}" class="btn bg-info text-white ml-2">Login</a></li>
          <li><a href="{{ route('register') }}" class="btn bg-danger text-white ml-2">Registrar</a></li>
          @endauth

        </ul>
      </nav><!-- .nav-menu -->
      

    </div>
  </header>