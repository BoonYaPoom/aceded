@extends('layouts.adminhome')
@section('content')
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
    </style>
 
 <script src="{{ asset('/javascript/Highcharts-6.0.7/code/highcharts.js') }}"></script>
 <script src="{{ asset('/javascript/Highcharts-6.0.7/code/modules/exporting.js') }}"></script>
 <script src="{{ asset('/javascript/Highcharts-6.0.7/code/modules/export-data.js') }}"></script>
 <script src="{{ asset('/javascript/Highcharts-6.0.7/code/modules/accessibility.js') }}"></script>
 
 
 

    <div class="page-inner">
        <div class="sidebar-section-fill">
            <div class="card card-reflow">
                <div class="card-body">
                    <button type="button" class="close mt-n1 d-none d-xl-none d-sm-block" onclick="toggleSidebar()"
                        aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="card-body pb-1">
                        <h3>รายงาน</h3>
                    </div>
                    <div class="list-group list-group-bordered list-group-reflow">
                        <div
                            class="list-group-item justify-content-between align-items-center 
                            {{ Str::startsWith(request()->url(), route('D0100')) || request()->is('D0100', 'D0100/*')
                                ? ' bg-muted'
                                : '' }} ">
                            <span><i class="fas fa-chart-bar text-teal mr-2"></i> <a href="{{ route('D0100') }}"
                                    class="small">ภาพรวมระบบ</a></span>
                        </div>
                        <div
                            class="list-group-item justify-content-between align-items-center 
                            {{ Str::startsWith(request()->url(), route('dashboard')) || request()->is('dashboard', 'dashboard/*')
                                ? ' bg-muted'
                                : '' }}">
                            <span><i class="fas fa-chart-bar text-teal mr-2"></i> <a href="{{ route('dashboard') }}"
                                    class="small">รายงานเสรุปเชิงกราฟฟิค (Dashboard)</a></span>
                        </div>
                        <div
                            class="list-group-item justify-content-between align-items-center 
                            {{ Str::startsWith(request()->url(), route('table')) || request()->is('table', 'table/*')
                                ? ' bg-muted'
                                : '' }}">
                            <span><i class="fas fa-chart-bar text-teal mr-2"></i> <a href="{{ route('table') }}"
                                    class="small">รายงานเชิงตาราง</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        @yield('reports')


    </div><!-- /.page-inner -->
    
@endsection
