@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <!-- .page-inner -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #section-to-print,
            #section-to-print * {
                visibility: visible;
            }

            #section-to-print {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
/* ซ่อน dropdown เริ่มต้น */
#sidebarDropdown {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s ease-out;
}

/* กำหนดรูปแบบสำหรับปุ่มเปิด-ปิด */
#sidebarToggle {
    cursor: pointer;
    background: none;
    border: none;
    font-size: 1.5rem;
    transition: transform 0.4s ease-out; /* เพิ่มการเปลี่ยนรูปร่างเมื่อคลิก */
}

/* กำหนดสไตล์เมื่อปุ่มถูกคลิก */
#sidebarToggle.active + #sidebarDropdown {
    max-height: 500px; /* ปรับความสูงเพื่อให้แสดงเนื้อหา */
}


    </style>
<script>
    $(document).ready(function () {
    // เมื่อคลิกปุ่มเปิด-ปิด
    $("#sidebarToggle").click(function () {
        $(this).toggleClass("active");
    });
});

</script>
    <script src="{{ asset('/javascript/Highcharts-6.0.7/code/highcharts.js') }}"></script>
    <script src="{{ asset('/javascript/Highcharts-6.0.7/code/modules/exporting.js') }}"></script>
    <script src="{{ asset('/javascript/Highcharts-6.0.7/code/modules/export-data.js') }}"></script>
    <script src="{{ asset('/javascript/Highcharts-6.0.7/code/modules/accessibility.js') }}"></script>




    <div class="page-inner">

        <div class="sidebar-section-fill">
            <div class="card card-reflow">
                <div class="card-body">
                    <button type="button" class="dropdown-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
                       <span class="menu-icon fas fa-bars  "></span> รายงาน
                    </button>
                    <div class="dropdown-content" id="sidebarDropdown">
                        <div class="card-body pb-1 ">
                            <h3>  รายงาน</h3>
                        </div>
                        <div class="list-group list-group-bordered list-group-reflow">
                            <div
                                class="list-group-item justify-content-between align-items-center 
                            {{ Str::startsWith(request()->url(), route('DepartD0100', ['department_id' => $depart->department_id]) ) || request()->is('DepartD0100', 'DepartD0100/*') ? ' bg-muted' : '' }} ">
                                <span><i class="fas fa-chart-bar text-teal mr-2"></i> <a href="{{ route('DepartD0100', ['department_id' => $depart->department_id]) }}"
                                        class="small">ภาพรวมระบบ</a></span>
                            </div>
                            <div
                                class="list-group-item justify-content-between align-items-center 
                            {{ Str::startsWith(request()->url(), route('Departdashboard', ['department_id' => $depart->department_id])) || request()->is('dashboard', 'dashboard/*')
                                ? ' bg-muted'
                                : '' }}">
                                <span><i class="fas fa-chart-bar text-teal mr-2"></i> <a href="{{ route('dashboard', ['department_id' => $depart->department_id]) }}"
                                        class="small">รายงานเสรุปเชิงกราฟฟิค (Dashboard)</a></span>
                            </div>
                            <div
                                class="list-group-item justify-content-between align-items-center 
                            {{ Str::startsWith(request()->url(), route('Departtable', ['department_id' => $depart->department_id])) || request()->is('table', 'table/*') ? ' bg-muted' : '' }}">
                                <span><i class="fas fa-chart-bar text-teal mr-2"></i> <a href="{{ route('table', ['department_id' => $depart->department_id]) }}"
                                        class="small">รายงานเชิงตาราง</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        @yield('Departreportspage')
    @endsection
