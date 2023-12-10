<nav id="main-menu" class="col-md-3 col-lg-2 d-md-block sidebar collapse bg-nav">
    <img width="100%" src="{{ asset('img/lti1p3-logo.png') }}" />
    <ul class="nav flex-column">
      <li class="nav-item nav-item">
        <a class="nav-link d-flex align-items-center text-white" href="{{route('lti1p3.platforms.index')}}">
          <span class="material-icons me-3 nav-icon">apps</span>
          <span>{{trans('lti1p3::lti1p3.navbar_platforms')}}</span>
      </a>
      </li>
      <li class="nav-item mt-4">
        <a class="nav-link px-3 text-white d-flex" href="{{route('lti1p3.auth.logout')}}">
          <span class="material-icons me-3 nav-icon">logout</span>
          <span>{{trans('lti1p3::lti1p3.navbar_logout')}}</span>
        </a>
      </li>
    </ul>
</nav>