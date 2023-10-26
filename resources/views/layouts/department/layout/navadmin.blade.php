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
                        @if (($data->department_id == $depart->department_id && $data->user_role == 6) || $data->user_role == 1)
                            <a class="nav-link  font-weight-bold {{ Str::startsWith(request()->url(), route('departmentwmspage')) || request()->is('wms', 'wms/*')
                                ? ' active text-info'
                                : '' }} "
                                href="{{ route('manage', ['department_id' => $depart->department_id]) }}"><span
                                    class="menu-icon fas fa-globe  "></span>
                                จัดการเว็บ</a>
                            <a class="nav-link  font-weight-bold {{ Str::startsWith(request()->url(), route('departmentdlspage')) || request()->is('dls', 'dls/*') ? ' active text-info' : '' }}"
                                href="{{ route('dls', ['department_id' => $depart->department_id]) }}"><span
                                    class="menu-icon fas fa-book  "></span>
                                จัดการข้อมูลและความรู้</a>
                            <a class="nav-link  font-weight-bold d-none" href=""><span
                                    class="menu-icon fas fa-users  "></span> กิจกรรม</a>
                            <a class="nav-link  font-weight-bold {{ Str::startsWith(request()->url(), route('departmentLearnpage')) || request()->is('lms', 'lms/*')
                                ? ' active text-info'
                                : '' }}"
                                href="{{ route('learn', ['department_id' => $depart->department_id]) }}"><span
                                    class="menu-icon fas fa-chalkboard-teacher  "></span>
                                จัดการเรียนรู้</a>
                        @endif

                     <!--     <a class="nav-link  font-weight-bold {{ Str::startsWith(request()->url(), route('DepartReportview', ['department_id' => $depart->department_id])) ||
                        request()->is('homeDepart', 'homeDepart/*')
                            ? ' active text-info'
                            : '' }}"
                                href="{{ route('DepartD0100', ['department_id' => $depart->department_id]) }}">
                                <span class="menu-icon fas fa-chart-bar  "></span> รายงาน</a>
                    

                        <a class="nav-link  font-weight-bold {{ Str::startsWith(request()->url(), route('ManageExam', ['department_id' => $depart->department_id])) ||
                        request()->is('mne', 'mne/*')
                            ? ' active text-info'
                            : '' }}"
                            href="{{ route('ManageExam', ['department_id' => $depart->department_id]) }}"><span
                                class="menu-icon fas fa-align-justify  "></span> จัดการข้อสอบ</a>-->

                        @if (
                            ($data->department_id == $depart->department_id && $data->user_role == 6) ||
                                $data->user_role == 1 ||
                                ($data->department_id == $depart->department_id && $data->user_role == 3) ||
                                ($data->department_id == $depart->department_id && $data->user_role == 7) ||
                                ($data->department_id == $depart->department_id && $data->user_role == 8))
                            <a class="nav-link  font-weight-bold {{ Str::startsWith(request()->url(), route('UserManage')) ? ' active text-info' : '' }}"
                                href="{{ route('DPUserManage', ['department_id' => $depart->department_id]) }}"><span
                                    class="menu-icon fas fa-users-cog  "></span>
                                จัดการผู้ใช้</a>
                        @endif

                        <!-- End Account Sidebar Toggle Button -->
                        </li>
                    </div>
                </div>
            </nav>
