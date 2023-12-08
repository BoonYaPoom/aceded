</aside>
<main class="app-main">
    <div class="wrapper">
        <div class="page ">
            <nav class="page-navs w3-hide-small ">
                <div class="nav-scroller">
                    <div class="nav nav-center nav-tabs h3 ">
                        <a class="nav-link    font-weight-bold " href="{{ route('departmentwmspage') }}"><span
                                class="menu-icon fas fa-home "></span>
                            หน้าแรก</a>

                        @if ($data->user_role == 1 )
                            {{-- <a class="nav-link  font-weight-bold {{ Str::startsWith(request()->url(), route('Reportview')) || request()->is('report', 'report/*')
                                ? ' active text-info'
                                : '' }}"
                                href="{{ route('D0100') }}"><span class="menu-icon fas fa-chart-bar  "></span>
                                รายงาน</a> --}}
                            <a class="nav-link  font-weight-bold {{ Str::startsWith(request()->url(), route('UserManage')) || request()->is('ums', 'ums/*')
                                ? ' active text-info'
                                : '' }}"
                                href="{{ route('UserManage') }}"><span class="menu-icon fas fa-users-cog  "></span>
                                จัดการผู้ใช้</a>
                            {{-- <a class="nav-link  font-weight-bold {{ Str::startsWith(request()->url(), route('requestSchool')) || request()->is('rad', 'rad/*')
                                    ? ' active text-info'
                                    : '' }}"
                                    href="{{ route('requestSchool') }}"><span class="menu-icon fas fa-users-cog  "></span>
                                    คำขอสมัคร Admin </a> --}}
                        @endif
                        <!-- End Account Sidebar Toggle Button -->
                        </li>
                    </div>
                </div>
            </nav>
