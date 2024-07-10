<div class="app has-fullwidth">
    <header class="app-header app-header-dark">
        <div class="top-bar bg-infohead ">
            <div class="top-bar-brand bg-transparent">

                <button class="hamburger hamburger-squeeze mr-2 d-lg-none d-xl-none" type="button" data-toggle="aside"
                    aria-label="toggle menu"><span class="hamburger-box"><span
                            class="hamburger-inner"></span></span></button>
                <a href=""><img src="{{ env('URL_FILE_SFTP') . $logoDep->detail }}"
                        alt="" style="height: 50px;" class="bg-white border mt-3 mb-3"></a>
            </div>
            <div class="top-bar-list">
                <div class="top-bar-item px-2 d-md-none d-lg-none d-xl-none">
                    <button class="hamburger hamburger-squeeze" type="button" data-toggle="aside"
                        aria-label="toggle menu"><span class="hamburger-box"><span
                                class="hamburger-inner"></span></span></button>
                </div>
                <div class="top-bar-item top-bar-item-right px-0 d-none d-sm-flex">
                    <div class="dropdown">
                        <button class="btn-account d-none d-md-flex" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"><span class="user-avatar user-avatar-md"> <img
                                    src="{{ $data->avatar }}" alt="{{  $data->avatar }}"></span>
                            <span class="account-summary pr-lg-4 d-none d-lg-block">
                                <span class="account-name">
                                    {{ $data->firstname }}
                                </span> <span class="account-description"></span></span></button>
                        <div class="dropdown-arrow dropdown-arrow-left"></div>
                        <div class="dropdown-menu">
                            <h6 class="dropdown-header d-none d-md-block d-lg-none"> {{ $data->firstname }} </h6>
                            <a class="dropdown-item" href="{{ route('edit-profile') }}">
                                <span class="dropdown-icon oi oi-person"></span> Profile</a>
                            <a class="dropdown-item" href="{{ url('https://aced.nacc.go.th/' . $depart->name_short_en . '/?clang=th')}}"><span class="dropdown-icon fas fa-share"></span>
                                Fontend</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"><span
                                    class="dropdown-icon oi oi-account-logout"></span> Logout</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>

    <aside class="app-aside  app-aside-light">
        <div class="aside-content">
            <header class="aside-header">
                <button class="hamburger hamburger-squeeze" type="button" data-toggle="aside" aria-label="Menu"><span
                        class="hamburger-box"><span class="hamburger-inner"></span></span></button>
                <button class="btn-account" type="button" data-toggle="collapse" data-target="#dropdown-aside"><span
                        class="user-avatar user-avatar-lg">
                        <img src="{{  $data->avatar }}" alt="{{  $data->avatar }}"></span>
                    <span class="account-icon"><span class="fa fa-caret-down fa-lg"></span></span>
                    <span class="account-summary"><span class="account-name"> {{ $data->firstname }}</span>
                        <span class="account-description">ผู้ดูแลระบบ</span></span></button>
                <div id="dropdown-aside" class="dropdown-aside collapse">
                    <div class="pb-3">
                        <a class="dropdown-item" href="{{ route('edit-profile') }}"><span
                                class="dropdown-icon oi oi-person"></span> Profile</a>
                        <a class="dropdown-item" href="{{ url('https://aced-lb.nacc.go.th/' . $depart->name_short_en )}}"><span class="dropdown-icon 	fas fa-share"></span>
                            Fontend</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"><span
                                class="dropdown-icon oi oi-account-logout"></span> ออกจากระบบ</a>
                    </div>
                </div>

            </header>


        </div>

        <aside class="app-aside app-aside-light ">
            <div class="aside-content">
                <header class="aside-header">
                    <button class="hamburger hamburger-squeeze active" type="button" data-toggle="aside"
                        aria-label="Menu"><span class="hamburger-box"><span
                                class="hamburger-inner"></span></span></button>
                    <button class="btn-account collapsed" type="button" data-toggle="collapse"
                        data-target="#dropdown-aside" aria-expanded="false"><span class="user-avatar user-avatar-lg">
                            <img src="{{  $data->avatar }}"
                                alt="{{  $data->avatar }}"></span>
                        <span class="account-icon"><span class="fa fa-caret-down fa-lg"></span></span>
                        <span class="account-summary"><span class="account-name">{{ $data->firstname }}</span>
                            <span class="account-description">ผู้ดูแลระบบ</span></span></button>
                    <div id="dropdown-aside" class="dropdown-aside collapse" style="">
                        <div class="pb-3">
                            <a class="dropdown-item"
                                href="{{ route('edit-profile') }}"><span
                                    class="dropdown-icon oi oi-person"></span> Profile</a>
                            <a class="dropdown-item" href="{{ url('https://aced-lb.nacc.go.th/' . $depart->name_short_en )}}"><span
                                    class="dropdown-icon 	fas fa-share"></span> Fontend</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"><span
                                    class="dropdown-icon oi oi-account-logout"></span> ออกจากระบบ</a>
                        </div>
                    </div>
                </header>
                <div class="aside-menu overflow-hidden ps">
                    <nav id="stacked-menu" class="stacked-menu stacked-menu-has-collapsible">
                        <ul class="menu">
                            <li class="menu-item ">
                                <a href="{{ route('departmentdlspage') }}" class="menu-link "><span class="menu-icon fas fa-home"></span>
                                    <span class="menu-text">หน้าแรก</span></a>
                            </li>
                            <li class="menu-item {{ Str::startsWith(request()->url(), route('departmentwmspage')) || request()->is('wms', 'wms/*') ? ' has-active text-info' : '' }}">
                                <a href="{{ route('manage', ['department_id' => $depart->department_id]) }}" class="menu-link "><span class="menu-icon fas fa-globe"></span>
                                    <span class="menu-text">จัดการเว็บ</span></a>
                            </li>
                            <li class="menu-item {{ Str::startsWith(request()->url(), route('departmentdlspage')) || request()->is('dls', 'dls/*') ? ' has-active text-info' : '' }} ">
                                <a href="{{ route('dls', ['department_id' => $depart->department_id]) }}" class="menu-link "><span class="menu-icon fas fa-book"></span>
                                    <span class="menu-text">จัดการข้อมูลและความรู้</span></a>
                            </li>
                           <!-- <li class="menu-item ">
                                <a href="/" class="menu-link "><span class="menu-icon fas fa fa-users"></span>
                                    <span class="menu-text">กิจกรรม</span></a>
                            </li> -->
                   
                            <li class="menu-item {{ Str::startsWith(request()->url(), route('departmentLearnpage')) || request()->is('learn', 'learn/*') ? 'has-active text-info' : '' }}">
                                <a href="{{ route('learn', ['department_id' => $depart->department_id]) }}" class="menu-link"><span
                                        class="menu-icon fas fa-chalkboard-teacher"></span> <span
                                        class="menu-text">จัดการเรียนรู้</span></a>
                            </li>
                          
                            <li class="menu-item ">
                                <a href="{{ route('logout') }}" class="menu-link"><span class="menu-icon fas fa-power-off"></span>
                                    <span class="menu-text"> ออกจากระบบ</span></a>
                            </li>
                        </ul>
                    </nav>
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__rail-y" style="top: 0px; right: 0px;">
                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                    </div>
                </div>
                <footer class="aside-footer border-top p-3 align-items-center">
                    <button class="btn btn-light btn-block text-primary"><span
                            class="btn btn-sm btn-icon btn-secondary"><i class="fas fas fa-clock"></i> </span> <span
                            id="SessionTimeOut" class="text-red">29นาที 59วินาที</span></button>
                </footer>
            </div>
        </aside>
