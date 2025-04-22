<nav id="navmenu" class="navmenu">
    <ul>
      <li><a href="#hero" class="active">Home<br></a></li>
      <li><a href="#about">Residents Recordsp</a></li>
      <li><a href="#services">Services</a></li>
      <li><a href="#portfolio">Portfolio</a></li>
      <li><a href="#team">Team</a></li>
      <li><a href="blog.html">Blog</a></li>
      <li class="dropdown"><a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
        <ul>
          <li><a href="#">Dropdown 1</a></li>
          <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Deep Dropdown 1</a></li>
              <li><a href="#">Deep Dropdown 2</a></li>
              <li><a href="#">Deep Dropdown 3</a></li>
              <li><a href="#">Deep Dropdown 4</a></li>
              <li><a href="#">Deep Dropdown 5</a></li>
            </ul>
          </li>
          <li><a href="#">Dropdown 2</a></li>
          <li><a href="#">Dropdown 3</a></li>
          <li><a href="#">Dropdown 4</a></li>
        </ul>
      </li>
      <li><a href="#contact">Contact</a></li>
        <li class="dropdown user-menu"><a href="#"><span>{{ Auth::user()->name }} <i class="far fa-user-circle"></i></span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
        <ul class="dropdown-menu">
            <li><a href="{{ route('profile.edit') }}" ><i class="bi bi-person-circle"></i> Profile</a></li>
            <li>
            <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="dropdown-item logout-button"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </form>
            </li>
        </ul>
        </li>
        </ul>
      </li>
    </ul>
    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
  </nav>
