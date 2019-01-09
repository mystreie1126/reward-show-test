
<header class="main-header">
    <nav class="indigo">
      <div class="container">
        <div class="nav-wrapper">
          @if(Auth::check())
          <a href="#" class="brand-logo">{{Auth::User()->name}}</a>
          @endif
          <a href="#" data-activates="mobile-nav" class="button-collapse">
            <i class="fa fa-bars"></i>
          </a>
          <ul class="right hide-on-med-and-down">
            {{-- <li>
              <a class="active-link" href="index.html">Home</a>
            </li> --}}
            <li>
              <a href="solutions.html">Order History</a>
            </li>
           {{--  <li>
              <a href="signup.html">Sign Up</a>
            </li> --}}
             <li>
              <a href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                  Logout
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>

            </li>

          </ul>
          <ul class="side-nav" id="mobile-nav">
            <h4 class="purple-text text-darken-4 center">Quazzu</h4>
            <li>
              <div class="divider"></div>
            </li>
            <li>
              <a href="Home">
                <i class="fa fa-home grey-text text-darken-4"></i> Home</a>
            </li>
            <li>
              <a href="solutions.html">
                <i class="fa fa-cog grey-text text-darken-4"></i> Search</a>
            </li>
           {{--  <li>
              <a href="signup.html">
                <i class="fa fa-users grey-text text-darken-4"></i> Sign Up</a>
            </li> --}}
            <li>
              <div class="divider"></div>
            </li>
             <li>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>

              </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Showcase -->
  {{--   <div class="showcase container">
      <div class="row">
        <div class="col s12 m10 offset-m1 center">
          <p class="flow-text">Annocement</p>
          <p class="broadcast">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sit fugit deserunt quos provident aliquam inventore.</p>
          <br>
        </div>
      </div>
    </div> --}}
  </header>
