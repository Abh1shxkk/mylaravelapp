<a class="nav-link" href="#" data-toggle="dropdown" id="profileDropdown">
  <span class="nav-profile-name">
    {{ Auth::guard('user')->user()->username }}
  </span>
</a>

<br>
<br>

<a class="dropdown-item" href="{{ route('user.logout') }}">
<i class="typcn typcn-eject text-primary"></i>
Logout
</a>