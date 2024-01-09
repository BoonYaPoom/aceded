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
                        <a class="nav-link  font-weight-bold {{ Str::startsWith(request()->url(), route('DepartReportview')) || request()->is('rpl', 'rpl/*')
                            ? ' active text-info'
                            : '' }}"
                            href="{{ route('A0100') }}"><span class="menu-icon fas fa-chart-bar  "></span>
                            รายงาน</a>
                        @if ($data->user_role == 1)
                            <a class="nav-link  font-weight-bold {{ Str::startsWith(request()->url(), route('UserManage')) || request()->is('ums', 'ums/*')
                                ? ' active text-info'
                                : '' }}"
                                href="{{ route('UserManage') }}"><span class="menu-icon fas fa-users-cog  "></span>
                                จัดการผู้ใช้</a>
                            <a class="nav-link  font-weight-bold {{ Str::startsWith(request()->url(), route('pageRequest')) || request()->is('req', 'req/*')
                                ? ' active text-info'
                                : '' }}"
                                href="{{ route('pageRequest') }}"><span class="menu-icon fas fa-users-cog  "></span>
                                คำขอถึง Admin </a>
                        @endif
                        <!-- End Account Sidebar Toggle Button -->
                        </li>
                    </div>
                </div>
            </nav>
