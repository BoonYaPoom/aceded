@extends('page.report2.index')
@section('reports2')
    <!-- .page-inner -->

    <div class="page-inner">



        <div class="form-row">
            <!-- form column -->
            <div class="col-md-5"></div>
            <span class="mt-1">ปี</span>&nbsp;
            <div class="col-md-3">
                <div class=""><select id="selectyear" name="selectyear" class="form-control" data-toggle="select2"
                        data-placeholder="ปี" data-allow-clear="false">
                        <option value="2566">ปี 2566 </option>
                        <option value="2567" selected>ปี 2567 </option>
                        <option value="2568">ปี 2568 </option>
                    </select></div>
            </div>
            <span class="mt-1">หน่วยงาน</span>&nbsp;
            <div class="col-md-3">

                <div><select id="depa" name="depa" class="form-control" data-toggle="select2"
                        data-placeholder="หลักสูตร" data-allow-clear="false">

                        @php
                            $depart = DB::table('department')
                                ->where('department_status', 1)
                                ->get();
                        @endphp
                        @foreach ($depart->sortBy('department_id') as $de)
                            <option value="{{ $de->department_id }}" {{ $de->department_id == 1 ? 'selected' : '' }}>
                                {{ $de->name_th }} </option>
                        @endforeach
                    </select></div>
            </div>
            <div class="col-md-3 ">
                <div class="d-none"><select id="selectmonth" name="selectmonth" class="form-control " data-toggle="select2"
                        data-placeholder="เดือน" data-allow-clear="false" onchange="$('#formreport').submit();">
                        <option value="0">เดือน</option>
                        @foreach ($month as $im => $m)
                            <option value="{{ $im }}"> {{ $m }} </option>
                        @endforeach
                    </select></div>
            </div>
            <div class="col-md-1 text-right"><button type="button" class="btn btn-light btn-icon d-xl-none"
                    data-toggle="sidebar"><i class="fa fa-angle-double-left fa-lg"></i></button></div>
            <!-- /form column -->
        </div><!-- /form row -->

        <br>
        <div class="card card-fluid">
            <!-- .card-header -->
            <div class="card-header bg-muted">
                <div class="d-flex align-items-center">
                    <span class="mr-auto">รายงานข้อมูลรายชื่อผู้เรียนทั้งหมด และแยกตามหลักสูตร</span>
                    {{-- <a href="" class="btn btn-icon btn-outline-danger"><i class="fa fa-file-pdf"></i></a> --}}
                    &nbsp;<a href="" class="btn btn-icon btn-outline-primary"><i
                            class="fa fa-file-excel "></i></a>&nbsp;<a onclick="window.print()"
                        class="btn btn-icon btn-outline-success"><i class="fa fa-print "></i></a>
                </div>
            </div><!-- /.card-header -->
            <!-- .card-body -->
            <div class="card-body">
                <div class="table-responsive">
                    <table border="1" style="width:100%" id="section-to-print">
                        <!-- thead -->
                        <thead>
                            <tr>
                                <th class="text-center" colspan="6">รายงานข้อมูลรายชื่อผู้เรียนทั้งหมด และแยกตามหลักสูตร
                                </th>
                            </tr>
                            <tr class="text-center">
                                <th align="center" width="5%">ลำดับ</th>
                                <th align="center" width="10%">ชื่อผู้ใช้งาน</th>
                                <th align="center" width="20%">ชื่อ - สกุล</th>
                                <th align="center" width="20%">สังกัด</th>
                                <th align="center">หลักสูตร</th>
                                <th align="center" width="10%">วันที่ลงทะเบียนเรียน</th>
                                <th align="center" width="10%">วันที่จบหลักสูตร</th>
                            </tr>
                        </thead>
                        <script>
                            $(document).ready(function() {
                                $('#selectyear, #depa').on('change', function() {
                                    var learner = {!! json_encode($learner) !!};
                                    var depa = $('#depa').val();
                                    var selectedYear = $('#selectyear').val();
                                    console.log(depa)
                                    console.log(selectedYear)
                                    var filteredLearner = learner.filter(function(data) {
                                        return data.year == selectedYear && data.department_id == depa;
                                    });

                                    displayDataInTable(filteredLearner);
                                });
                                $('#selectyear').trigger('change');
                                $('#depa').trigger('change');

                            });

                            function displayDataInTable(data) {
                                $('#learend').empty();
                                // วนลูปเพื่อแสดงข้อมูลใน tbody
                                $.each(data, function(index, item) {
                                    // สร้างแถวใน tbody
                                    var row = $('<tr>');
                                    // เพิ่มข้อมูลลงในแถว
                                    row.append($('<td class="text-center">').text(index));
                                    row.append($('<td class="text-center">').text(item.username));
                                    row.append($('<td >').text(item.firstname + ' ' + item.lastname));
                                    row.append($('<td >').text(item.exten_name));
                                    row.append($('<td >').text(item.course_th));
                                    row.append($('<td class="text-center">').text(item.register_date));
                                    row.append($('<td class="text-center">').text(item.realcongratulationdate));
                                    // เพิ่มแถวลงใน tbody
                                    $('#learend').append(row);
                                });

                            }
                        </script>

                        <tbody id="learend">
                        </tbody>

                    </table><!-- /.table -->

                </div><!-- /.table-responsive -->
            </div><!-- /.card-body -->
        </div><!-- /.card -->
        <!-- .page-title-bar -->

    </div><!-- /.page-inner -->
@endsection
