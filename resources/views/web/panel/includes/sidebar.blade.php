
<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
              <a href="{{
                    Auth::check() && Auth::user()->hasRole->slug == 'super-admin' ? url('superadmin') :
                    (Auth::check() && Auth::user()->hasRole->slug == 'company-admin' ? url('admin/dashboard') :
                    (Auth::check() && Auth::user()->hasRole->slug == 'manager' ? url('manager/dashboard') :
                    (Auth::check() && Auth::user()->hasRole->slug == 'employee' ? url('employee/dashboard') : '#')))
                }}">
                <img class="img-fluid "src="{{ URL::asset('panel/assets/images/logo/playbook-logo.png') }}" alt="" style="position: relative;bottom:75px">
              </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
        </div>

        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    <li class="pin-title sidebar-main-title">
                        <div>
                            <h6>Pinned</h6>
                        </div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="lan-1">General</h6>
                        </div>
                    </li>
                    @if ($user->hasRole->slug == 'super-admin')
                       <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
                        <label class="badge badge-light-primary"></label>
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ URL::asset('panel/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ URL::asset('panel/assets/svg/icon-sprite.svg#fill-home') }}"></use>
                            </svg><span >Company Management</span></a>
                            <ul class="sidebar-submenu">
                                <li><a  href="{{url('superadmin/company')}}">Companies</a></li>

                            </ul>
                        </li>
                    @elseif ($user->hasRole->slug == 'company-admin')
                      <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
                        <label class="badge badge-light-primary"></label>
                        <a class="sidebar-link sidebar-title" href="#">
                            <svg class="stroke-icon">
                                <use href="{{ URL::asset('panel/assets/svg/icon-sprite.svg#stroke-user') }}"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ URL::asset('panel/assets/svg/icon-sprite.svg#fill-user') }}"></use>
                            </svg><span >User Management</span></a>
                        <ul class="sidebar-submenu">
                            <li><a  href="{{url('admin/manager')}}">Managers</a></li>
                            <li><a  href="{{url('admin/employee')}}">Employees</a></li>

                        </ul>
                    </li>

                    @elseif ($user->hasRole->slug == 'manager')

                    @elseif ($user->hasRole->slug == 'employee')
                    @endif

                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
