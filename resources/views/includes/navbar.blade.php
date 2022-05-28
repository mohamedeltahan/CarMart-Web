<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      <a class="navbar-brand brand-logo" href="index.html"><img src="{{asset("assets/images/logo.svg")}}" alt="logo" /></a>
      <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{asset("assets/images/logo.svg")}}" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="mdi mdi-menu"></span>
      </button>
      <div class="search-field d-none d-md-block">
        <form class="d-flex align-items-center h-100" action="#">
          <div class="input-group">
            <div class="input-group-prepend bg-transparent">
              <i class="input-group-text border-0 mdi mdi-magnify d-none"></i>
            </div>
            <input type="text" class="form-control bg-transparent border-0 d-none" placeholder="Search projects">
          </div>
        </form>
      </div>
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
            <div class="nav-profile-img">
              <img src="{{asset("users-photos")."/".Auth::user()->photo_link}}" alt="image">
              <span class="availability-status online"></span>
            </div>
            <div class="nav-profile-text">
                <p class="mb-1 text-black">{{Auth::user()->account_name}}</p> 
            </div>
          </a>
          <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{route("edit_profile")}}">
              <i class="mdi mdi-logout mr-2 text-primary"></i> Edit Profile 
            </a>

            <a class="dropdown-item" href="{{route("logout")}}">
              <i class="mdi mdi-logout mr-2 text-primary"></i> Signout 
            </a>
          </div>
        </li>
        <li class="nav-item d-none d-lg-block full-screen-link">
          <a class="nav-link">
            <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
            <i class="mdi mdi-bell-outline"></i>
            <span class="count-symbol bg-danger"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
            <h6 class="p-3 mb-0">Notifications</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item preview-item">
              <div class="preview-thumbnail">
                <div class="preview-icon bg-warning">
                  <i class="mdi mdi-settings"></i>
                </div>
              </div>
              <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
              </div>
            </a>
            <div class="dropdown-divider"></div>
           
          </div>
        </li>
        
       
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
      </button>
    </div>
  </nav>


  <script src="https://www.gstatic.com/firebasejs/8.3.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.3.0/firebase-messaging.js"></script>


<script>
  

  var firebaseConfig = {
      apiKey: "AIzaSyALLAuGSoArXKWBykvAjpEa2puOuAMu4tQ",
      authDomain: "carmart-16ac3.firebaseapp.com",
      projectId: "carmart-16ac3",
      storageBucket: "carmart-16ac3.appspot.com",
      messagingSenderId: "131663415489",
      appId: "1:131663415489:web:e49398955f5eef973cec40",
      measurementId: "G-BH87RKHPN3"
    };
  
    
  firebase.initializeApp(firebaseConfig);
  const messaging = firebase.messaging();

   {
          messaging
          .requestPermission()
          .then(function () {
              return messaging.getToken()
          })
          .then(function(token) {
              console.log(token);
 
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });

              $.ajax({
                  url: '{{ route("save-token") }}',
                  type: 'POST',
                  data: {
                      token: token
                  },
                  dataType: 'JSON',
                  success: function (response) {
                      alert('Token saved successfully.');
                  },
                  error: function (err) {
                      console.log('User Chat Token Error'+ err);
                  },
              });

          }).catch(function (err) {
              console.log('User Chat Token Error'+ err);
          });
   }  
    
  messaging.onMessage(function(payload) {
      const noteTitle = payload.notification.title;
      const noteOptions = {
          body: payload.notification.body,
          icon: payload.notification.icon,
      };
      new Notification(noteTitle, noteOptions);
  });
 
</script>
