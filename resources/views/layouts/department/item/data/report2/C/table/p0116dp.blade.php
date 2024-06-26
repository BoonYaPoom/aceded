@extends('layouts.department.item.data.report2.index')
@section('reports22')
    <!-- .page-inner -->

    <div class="page-inner">
        <div class="form-row">
            <!-- form column -->
            <div class="col-md-1"></div>
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

        </div><!-- /form row -->
        <!-- .table-responsive --><br><!-- .card -->
        <div class="card card-fluid">
            <!-- .card-header -->
            <div class="card-header bg-muted">
                <div class="d-flex align-items-center">
                    <span class="mr-auto">ข้อมูล Log File ในรูปแบบรายงานทางสถิติ</span>
                   <span class="mr-auto">รายงานสถานะผู้เข้าเรียน และจบการศึกษา (รายบุคคล)</span>
                    &nbsp;<a href="#" class="btn btn-icon btn-outline-primary download-excel"><i
                            class="fa fa-file-excel"></i></a>
                    &nbsp;

                    <a class="btn btn-icon btn-outline-success print-button"><i class="fa fa-print"></i></a>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    $(".print-button").on("click", function() {
                        var printableTable = $("#section-to-print").clone();
                        $("body").append(printableTable);
                        $("body > *:not(#section-to-print)").hide();
                        window.print();
                        printableTable.remove();
                        $("body > *").show();
                    });
                });
            </script>
            <div class="card-body">
                <div class="table-responsive">
                    <table border="1" style="width:100%" id="section-to-print">
                        <!-- thead -->
                        <thead>
                            <tr>
                                <th class="text-center" colspan="4">รายงานสถานะผู้เข้าเรียน และจบการศึกษา (รายบุคคล)</th>
                                <th class="text-center" width="5%">สถานะ</th>
                            </tr>
                            <tr class="text-center">
                                <th align="center" width="5%">ลำดับ</th>
                                <th align="center">ชื่อ - สกุล</th>
                                <th align="center" width="20%">สังกัด</th>
                                <th align="center" width="30%">ชื่อหลักสูตร</th>
                                <th align="center" width="15%">N/A = กำลังเรียน P = เรียนจบ
                                </th>
                            </tr>


                        <tbody id="learend">
                        </tbody>


                    </table><!-- /.table -->
                </div><!-- /.table-responsive -->
            </div><!-- /.card-body -->
        </div><!-- /.card -->
        <!-- .page-title-bar -->

    </div><!-- /.page-inner -->
    <script>
        $(document).ready(function() {
            $('#selectyear').on('change', function() {
                var learner = {!! json_encode($learner) !!};
                var selectedYear = $('#selectyear').val();
                var depa = {!! json_encode($depart->department_id) !!};
                var filteredLearner = learner.filter(function(data) {
                    return data.year == selectedYear;
                });

                $(".download-excel").on("click", function() {

                    let url;
                    var admin_user = {!! json_encode($data->user_role) !!};
                    if (admin_user == 7) {
                        url = "{{ route('exportP0116', [':depa', ':selectedYear']) }}"
                            .replace(':depa', depa)
                            .replace(':selectedYear', selectedYear);
                    } else if (admin_user == 9) {
                        url = "{{ route('exportP0116Zone', [':depa', ':selectedYear']) }}"
                            .replace(':depa', depa)
                            .replace(':selectedYear', selectedYear);
                    }

                    if (url) {
                        window.location.href = url;
                    } else {
                        console.error('URL not defined for the given admin_user value.');
                    }
                });
                displayDataInTable(filteredLearner);
            });
            $('#selectyear').trigger('change');
            $('#provin').trigger('change');
        });

        function displayDataInTable(data) {
            $('#learend').empty()
            if (data && data.length > 0) {
                // วนลูปเพื่อแสดงข้อมูลใน tbody
                var i = 1;
                $.each(data, function(index, item) {
                    // สร้างแถวใน tbody
                    var row = $('<tr>');
                    // เพิ่มข้อมูลลงในแถว
                    row.append($('<td class="text-center">').text(i++));

                    row.append($('<td >').text(item.firstname + ' ' + item.lastname));
                    row.append($('<td >').text(item.exten_name));
                    row.append($('<td >').text(item.course_th));
                    row.append($('<td class="text-center">').text(item.congratulation == 0 ? 'P' : (item
                        .congratulation == 1 ? 'N/A' : '')));
                    // เพิ่มแถวลงใน tbody
                    $('#learend').append(row);
                });
            } else {
                // ถ้าไม่มีข้อมูล
                var noDataMessage = $('<tr><td colspan="5" class="text-center">ไม่มีข้อมูลในจังหวัดนี้ </td></tr>');
                $('#learend').append(noDataMessage);
            }
        }
    </script>
@endsection
