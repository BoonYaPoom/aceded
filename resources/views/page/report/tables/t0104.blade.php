@extends('page.report.index')
@section('reports')
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

    @php
        // Fetch logs with logid = 1 and group them by uid
        $countLogsByUid = \App\Models\Log::where('logid', 1)
            ->get()
            ->groupBy('uid');
        $i = 1;
        
        // Fetch users with role 4
        $user_data = \App\Models\Users::where('role', 4)->get();
    @endphp

    <div class="page-inner">


            <div class="form-row">
                <!-- form column -->
                <div class="col-md-1"><span class="mt-1 ">ปี</span></div>
                <div class="col-md-3">
                    <div class=""><select id="selectyear" name="selectyear" class="form-control" data-toggle="select2"
                            data-placeholder="ปี" data-allow-clear="false" onchange="$('#formreport').submit();">
                            <option value="2022"> {{$oneYearsAgo}} </option>
                            <option value="2023" selected> {{$currentYear}} </option>
                        </select></div>
                </div>
                <div class="col-md-4 ">
                    <div>
                        <select id="selectuidt0104" name="selectuidt0104" class="form-control select2" data-toggle="select2"
                            data-placeholder="ผู้ใช้งานทั้งหมด" data-allow-clear="false">
                            <option value="" selected> ผู้ใช้งานทั้งหมด </option>

                            @foreach ($user_data as $uLog)
                                @php
                                    $uid = $uLog->uid;
                                    $logCount = isset($countLogsByUid[$uid]) ? $countLogsByUid[$uid]->count() : 0;
                                @endphp

                                @if ($logCount > 0)
                                    <option value="{{ $uid }}">{{ $uLog->firstname }} {{ $uLog->lastname }}
                                    </option>
                                @endif
                            @endforeach
                 
                        </select>
                        
                    </div>
             

                  
                </div>
                <div class="col-md-3 ">
                    <div class="d-none"><select id="selectmonth" name="selectmonth" class="form-control "
                            data-toggle="select2" data-placeholder="เดือน" data-allow-clear="false"
                            onchange="$('#formreport').submit();">
                            <option value="0">เดือน</option>
                            <option value="0">เดือน</option>
                            @foreach ($month as $key => $m)
                                <option value="{{ $key }}"> {{ $m }}</option>
                            @endforeach
                        </select></div>
                    <button id="resetBtn" class="btn btn-secondary">Reset</button> <!-- เพิ่มปุ่ม Reset นี้ -->

                </div>
                <div class="col-md-1 text-right"><button type="button" class="btn btn-light btn-icon d-xl-none"
                        data-toggle="sidebar"><i class="fa fa-angle-double-left fa-lg"></i></button></div>
                <!-- /form column -->
            </div><!-- /form row -->
            
        <!-- แสดงข้อมูลผู้ใช้งานที่เลือก -->


        
        <!-- .table-responsive --><br><!-- .card -->
        <div class="card card-fluid">
            <!-- .card-header -->
            <div class="card-header bg-muted">
                <div class="d-flex align-items-center">
                    <span class="mr-auto">รายงานการ Login ของผู้เรียน</span> <a
                        href="https://aced.dlex.ai/childhood/admin/export/pdf.html"
                        class="btn btn-icon btn-outline-danger"><i class="fa fa-file-pdf"></i></a>&nbsp;<a
                        href="https://aced.dlex.ai/childhood/admin/export/excel.html"
                        class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a
                        href="javascript:window.print();" class="btn btn-icon btn-outline-success"><i
                            class="fa fa-print "></i></a>
                </div>
            </div><!-- /.card-header -->
            <!-- .card-body -->
            <div class="card-body">
                <div class="table-responsive">
                    <table border="1" style="width:100%" id="section-to-print">
                        <!-- thead -->
                        <thead>
                            <tr>
                                <th class="text-center" colspan="6">รายงานการ Login ของผู้เรียน</th>
                            </tr>
                            <tr class="text-center">
                                <th align="center" width="5%">ลำดับ</th>
                                <th align="center" width="15%">ชื่อผู้ใช้งาน</th>
                                <th align="center">ชื่อ - สกุล</th>

                                <th align="center" width="15%">จำนวนการเข้าระบบ(ครั้ง)</th>
                            </tr>
                            <!-- tbody -->
                        <tbody>
                            @foreach ($user_data as $uLog)
                                @php
                                    $logCount = isset($countLogsByUid[$uLog->uid]) ? $countLogsByUid[$uLog->uid]->count() : 0;

                                @endphp

                                @if ($logCount > 0)
                                    <tr data-uid="{{ $uLog->uid }}">
                                        <td align="center">{{ $loop->iteration }}</td>
                                        <td>{{ $uLog->username }}</td>
                                        <td>{{ $uLog->firstname }} {{ $uLog->lastname }}</td>
                                        <td class="text-right">{{ $logCount }}</td>
                                    </tr>
                                @endif
                            @endforeach

                        </tbody><!-- /tbody -->
                    </table><!-- /.table -->
                </div><!-- /.table-responsive -->
            </div><!-- /.card-body -->
        </div><!-- /.card -->
        <!-- .page-title-bar -->
        <script>
            $(document).ready(function() {
                // เมื่อมีการเลือก option ใน select
                $('#selectuidt0104').on('change', function() {
                    const selectedUser = $(this).val();
                    // แสดงค่า id ของ element ที่เลือก
                    console.log('Selected id:', selectedUser);
                    // ซ่อนแถวที่ไม่เกี่ยวข้อง
                    $('#section-to-print tbody tr').hide();

                    // แสดงแถวที่มีชื่อที่เลือก
                    $('#section-to-print tbody tr[data-uid="' + selectedUser + '"]').show();

                    // แสดง uid ที่เลือก
                    $('#selected-uid').text(selectedUser);

                    // ทำการร้องขอข้อมูลผู้ใช้งานจาก Controller ผ่าน Ajax
                    $.ajax({
                        url: '{{ route('get-Uata') }}',
                        type: 'POST',
                        data: {
                            selected_uid: selectedUser,
                            _token: '{{ csrf_token() }}', // ใส่ CSRF Token ในรูปแบบนี้
                        },
                        dataType: 'json',
                        success: function(response) {
                            // แสดงข้อมูลผู้ใช้งานที่เลือก
                            $('#user-data').html('<pre>' + JSON.stringify(response.user_data, null,
                                2) + '</pre>');
                        },

                        error: function(error) {
                            console.log('Error:', error);
                        }
                    });
                });

                // ฟังก์ชันสำหรับรีเฟรชตาราง
                function refreshTable() {
                    const selectedUser = $('#selectuidt0104').val();
                    console.log('Selected user:', selectedUser); // ตรวจสอบค่า selectedUser ใน Console Log

                    // ทำการร้องขอข้อมูลผู้ใช้งานจาก Controller ผ่าน Ajax
                    $.ajax({
                        url: '{{ route('get-Uata') }}',
                        type: 'POST',
                        data: {
                            selected_uid: selectedUser,
                            _token: '{{ csrf_token() }}', // ใส่ CSRF Token ในรูปแบบนี้
                        },
                        dataType: 'json',
                        success: function(response) {
                            // ซ่อนแถวที่ไม่เกี่ยวข้อง
                            $('#section-to-print tbody tr').hide();

                            // แสดงแถวที่มีชื่อที่เลือก
                            $('#section-to-print tbody tr[data-uid="' + selectedUser + '"]').show();

                            // แสดง uid ที่เลือก
                            $('#selected-uid').text(selectedUser);

                            // แสดงข้อมูลผู้ใช้งานที่เลือก
                            $('#user-data').html('<pre>' + JSON.stringify(response.user_data, null, 2) +
                                '</pre>');
                        },
                        error: function(error) {
                            console.log('Error:', error);
                        }
                    });
                }
             

                    // เมื่อคลิกปุ่ม Reset
                    $('#resetBtn').on('click', function() {
                        // เคลียร์การเลือกใน Select element
                        $('#selectuidt0104').val('');

                        // ซ่อนทั้งหมดของ tbody และแสดงทั้งหมดของ tbody
                        $('#section-to-print tbody tr').show();

                        // เคลียร์ข้อความในส่วนแสดง uid ที่เลือก
                        $('#selected-uid').text('');

                        // เคลียร์ข้อมูลที่แสดงในส่วนข้อมูลผู้ใช้งานที่เลือก
                        $('#user-data').empty();

                     
                    });

                    
                });

        </script>


    </div><!-- /.page-inner -->
@endsection
