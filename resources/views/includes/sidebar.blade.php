 <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="" class="nav-link">
                <div class="nav-profile-image">
                  <img src="{{asset("users-photos")."/".Auth::user()->photo_link}}" alt="image">
                  <span class="login-status online"></span>
                  <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2">{{Auth::user()->account_name}}</span>
                  <span class="text-secondary text-small">{{Auth::user()->full_name}}</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{route("home")}}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            @if(Auth::user()->account_type=="Admin")
            <li class="nav-item">
              <a class="nav-link" href="{{route("photos.index","today")}}">
                <span class="menu-title">photos</span>
                <i class="mdi mdi-vector-combine menu-icon"></i>
                
              </a> 
            </li>
            @endif
            @if(Auth::user()->account_type=="Admin")
            <li class="nav-item">
              <a class="nav-link" href="{{route("cars.index")}}">
                <span class="menu-title">Cars</span>
                <i class="mdi mdi-vector-combine menu-icon"></i>
                
              </a> 
            </li>
            @endif

            @if(Auth::user()->account_type=="Admin")
            <li class="nav-item">
              <a class="nav-link" href="{{route("categories.index")}}">
                <span class="menu-title">Categories</span>
                <i class="mdi mdi-vector-combine menu-icon"></i>
                
              </a> 
            </li>
            @endif

            @if(Auth::user()->account_type=="Admin")
            <li class="nav-item">
              <a class="nav-link" href="{{route("specifications.index")}}">
                <span class="menu-title">Specifications</span>
                <i class="mdi mdi-vector-combine menu-icon"></i>
                
              </a> 
            </li>
            @endif

            

            
            @if(Auth::user()->account_type=="Admin")
            <li class="nav-item">
              <a class="nav-link" href="{{route("requests.index")}}?type=emergency_car">
                <span class="menu-title">Requests</span>
                <i class="mdi mdi-vector-combine menu-icon"></i>
              </a> 
            </li>

            @else
            <li class="nav-item">
              <a class="nav-link" href="{{route("requests.index")}}?state=all">
                <span class="menu-title">Requests</span>
                <i class="mdi mdi-vector-combine menu-icon"></i>
              </a> 
            </li>
            @endif
            


            @if(Auth::user()->account_type=="Admin")
            <li class="nav-item">
              <a class="nav-link" href="{{route("users.index")}}">
                <span class="menu-title">Users</span>
                <i class="mdi mdi-account-multiple-outline  menu-icon"></i>
                
              </a> 
            </li>
            @endif
            

            @if(Auth::user()->account_type=="Admin")
            <li class="nav-item">
              <a class="nav-link" href="{{route("contactus.index")}}">
                <span class="menu-title">Contact Us</span>
                <i class="mdi mdi-message-reply-text menu-icon"></i>
              </a>
              
            </li>
            @endif


            @if(Auth::user()->category_title!="emergency_car" && Auth::user()->category_title!="mechanic")
              <li class="nav-item">
                <a class="nav-link" href="{{route("services.index")}}">
                  <span class="menu-title">Services</span>
                  <i class="mdi mdi-bookmark-check menu-icon"></i>
                </a>
              </li>
            @endif
            <li class="nav-item">
              <a class="nav-link" href="{{route("branches.index")}}">
                <span class="menu-title">Branches</span>
                <i class="mdi mdi-source-branch menu-icon"></i>
              </a>
              
            </li>
            @if(Auth::user()->account_type=="Admin")
            <li class="nav-item">
              <a class="nav-link" href="{{route("notifications.index")}}">
                <span class="menu-title">Notification</span>
                <i class="mdi mdi-snapchat menu-icon"></i>
              </a>
              
            </li>
            @endif

            
            @if(Auth::user()->account_type=="Admin")
            <li class="nav-item">
              <a class="nav-link" href="{{route("appsettings")}}">
                <span class="menu-title">settings</span>
                <i class="mdi mdi-settings menu-icon"></i>
              </a>
            </li>
            @endif      
            
           
          </ul>
        </nav>