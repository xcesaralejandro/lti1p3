<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarExample01">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="{{route('lti1p3.platforms.index')}}">
              {{trans('lti1p3::strings.navbar_list_platforms')}}
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('lti1p3.platforms.create')}}">
              {{trans('lti1p3::strings.navbar_add_platform')}}
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('lti1p3.auth.logout')}}">
            {{trans('lti1p3::strings.navbar_logout')}}
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>