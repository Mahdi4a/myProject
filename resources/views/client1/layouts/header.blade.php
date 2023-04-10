<div class="header-bot_inner_wthreeinfo_header_mid">
    <!-- header-bot-->
    <div class="col-md-4 logo_agile">
        <h1>
            <a href="index.html">
                <span>G</span>rocery
                <span>S</span>hoppy
                <img src="{{asset('client/images/logo2.png')}}" alt=" ">
            </a>
        </h1>
    </div>
    <!-- header-bot -->
    <div class="col-md-8 header">
        <!-- header lists -->
        <ul>
            <li>
                <a class="play-icon popup-with-zoom-anim" href="index.html#small-dialog1">
                    <span class="fa fa-map-marker" aria-hidden="true"></span> Shop Locator</a>
            </li>
            <li>
                <a href="index.html#" data-toggle="modal" data-target="#myModal1">
                    <span class="fa fa-truck" aria-hidden="true"></span>Track Order</a>
            </li>
            <li>
                <span class="fa fa-phone" aria-hidden="true"></span> 001 234 5678
            </li>
            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @endif

                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('profile') }}">profile</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
        <!-- //header lists -->
        <!-- search -->
        <div class="agileits_search">
            <form action="index.html#" method="post">
                <input name="Search" type="search" placeholder="How can we help you today?" required="">
                <button type="submit" class="btn btn-default" aria-label="Left Align">
                    <span class="fa fa-search" aria-hidden="true"> </span>
                </button>
            </form>
        </div>
        <!-- //search -->
        <!-- cart details -->
        <div class="top_nav_right">
            <div class="wthreecartaits wthreecartaits2 cart cart box_1">
                <form action="index.html#" method="post" class="last">
                    <input type="hidden" name="cmd" value="_cart">
                    <input type="hidden" name="display" value="1">
                    <button class="w3view-cart" type="submit" name="submit" value="">
                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
        </div>
        <!-- //cart details -->
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
