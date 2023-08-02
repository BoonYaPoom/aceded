a</aside>
<main class="app-main">
    <div class="wrapper">
        <div class="page ">
            <nav class="page-navs w3-hide-small ">
                <div class="nav-scroller">
                    <div class="nav nav-center nav-tabs h3 ">
                        <a class="nav-link    font-weight-bold " href="{{ route('departmentpage') }}"><span
                                class="menu-icon fas fa-home "></span>
                            หน้าแรก</a>
                        <a class="nav-link  font-weight-bold {{ Str::startsWith(request()->url(), route('manage')) || request()->is('wms', 'wms/*')
                            ? ' active text-info'
                            : '' }} "
                            href="{{ route('manage') }}"><span class="menu-icon fas fa-globe  "></span>
                            จัดการเว็บ</a>
                        <a class="nav-link  font-weight-bold {{ Str::startsWith(request()->url(), route('dls')) || request()->is('dls', 'dls/*') ? ' active text-info' : '' }}"
                            href="{{ route('dls') }}"><span class="menu-icon fas fa-book  "></span>
                            จัดการข้อมูลและความรู้</a>
                        <a class="nav-link  font-weight-bold d-none" href=""><span
                                class="menu-icon fas fa-users  "></span> กิจกรรม</a>
                        <a class="nav-link  font-weight-bold {{ Str::startsWith(request()->url(), route('learn')) || request()->is('lms', 'lms/*')
                            ? ' active text-info'
                            : '' }}"
                            href="{{ route('learn') }}"><span class="menu-icon fas fa-chalkboard-teacher  "></span>
                            จัดการเรียนรู้</a>
                        <a class="nav-link  font-weight-bold {{ Str::startsWith(request()->url(), route('Reportview')) || request()->is('report', 'report/*')
                            ? ' active text-info'
                            : '' }}"
                            href="{{ route('D0100') }}"><span class="menu-icon fas fa-chart-bar  "></span> รายงาน</a>
                        <a class="nav-link  font-weight-bold {{ Str::startsWith(request()->url(), route('UserManage')) || request()->is('ums', 'ums/*')
                            ? ' active text-info'
                            : '' }}"
                            href="{{ route('UserManage') }}"><span class="menu-icon fas fa-users-cog  "></span>
                            จัดการผู้ใช้</a>


                        <!-- End Account Sidebar Toggle Button -->
                        </li>
                    </div>
                </div>
            </nav>
