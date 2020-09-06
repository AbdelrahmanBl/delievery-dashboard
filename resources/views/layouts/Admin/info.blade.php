@if(Auth::guard('admin')->check())
<div class="user-account">
                <div class="user_div">
                    @if(Auth::guard('admin')->User()->picture == NULL)
                    <img src="{{ asset('assets/images/user.png') }}" class="user-photo" alt="User Profile Picture">
                    @else
                    <img src="{{Auth::guard('admin')->User()->picture}}" class="user-photo" alt="User Profile Picture">
                    @endif
                </div>
                <div class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><span>Welcome,</span> <strong>{{Auth::guard('admin')->User()->name}}</strong></a>
                    <ul class="dropdown-menu dropdown-menu-right account vivify flipInY">
                        <li><a href="profile.html"><i class="icon-user"></i>My Profile</a></li>
                        <li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li>
                        <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="{{asset('logout')}}"><i class="icon-power"></i>Logout</a></li>
                    </ul>
                </div>                
        </div>  
@endif            