<div class="col-lg-4">
          <div class="user-profile-info-area">
            <ul class="links">
                @php 

                  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
                  {
                    $link = "https"; 
                  }
                  else
                  {
                    $link = "http"; 
                      
                    // Here append the common URL characters. 
                    $link .= "://"; 
                      
                    // Append the host(domain name, ip) to the URL. 
                    $link .= $_SERVER['HTTP_HOST']; 
                      
                    // Append the requested resource location to the URL 
                    $link .= $_SERVER['REQUEST_URI']; 
                  }      

                @endphp
              <li class="{{ $link == route('user-dashboard') ? 'active':'' }}">
                <a href="{{ route('user-dashboard') }}">
                  Dashboard
                </a>
              </li>
              
              @if(Auth::user()->IsVendor())
                <li>
                  <a href="{{ route('vendor-dashboard') }}">
                    Vendor Panel
                  </a>
                </li>
              @endif

              <li class="{{ $link == route('user-orders') ? 'active':'' }}">
                <a href="{{ route('user-orders') }}">
                  Purchased Items
                </a>
              </li>

              @if($gs->is_affilate == 1)

                <li class="{{ $link == route('user-affilate-code') ? 'active':'' }}">
                    <a href="{{ route('user-affilate-code') }}">Affiliate Code</a>
                </li>

              @endif


              <li class="{{ $link == route('user-order-track') ? 'active':'' }}">
                  <a href="{{route('user-order-track')}}">Order Tracking</a>
              </li>

              <li class="{{ $link == route('user-favorites') ? 'active':'' }}">
                  <a href="{{route('user-favorites')}}">Favorite Sellers</a>
              </li>

              <li class="{{ $link == route('user-messages') ? 'active':'' }}">
                  <a href="{{route('user-messages')}}">Messages</a>
              </li>

              <li class="{{ $link == route('user-profile') ? 'active':'' }}">
                <a href="{{ route('user-profile') }}">
                  Edit Profile
                </a>
              </li>

              <li class="{{ $link == route('user-reset') ? 'active':'' }}">
                <a href="{{ route('user-reset') }}">
                 Reset Password
                </a>
              </li>

              <li>
                <a href="{{ route('user-logout') }}">
                  Logout
                </a>
              </li>

            </ul>
          </div>
          @if($gs->reg_vendor == 1)
            <div class="row mt-4">
              <div class="col-lg-12 text-center">
                <a href="{{ route('user-package') }}" class="mybtn1 lg">
                  <i class="fas fa-dollar-sign"></i> {{ Auth::user()->is_vendor == 1 ? 'Start Selling' : (Auth::user()->is_vendor == 0 ? 'Start Selling' : $langg->lang237) }}
                </a>
              </div>
            </div>
          @endif
        </div>