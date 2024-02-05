@extends('page.report2.index')
@section('reports2')
    <!-- .page-inner -->

    <div class="page-inner">

        <div class="form-row">
            <!-- form column -->
            <div class="col-md-8"></div>
            <span class="mt-1">ปี</span>&nbsp;
            <div class="col-md-3">
                <div class=""><select id="selectyear" name="selectyear" class="form-control" data-toggle="select2"
                        data-placeholder="ปี" data-allow-clear="false">
                        <option value="2566">ปี 2566 </option>
                        <option value="2567" selected>ปี 2567 </option>
                        <option value="2568">ปี 2568 </option>
                    </select></div>
            </div>


        </div><!-- /form row -->
        <!-- .table-responsive --><br><!-- .card -->
        <div class="card card-fluid">
            <!-- .card-header -->
            <div class="card-header bg-muted">
                <div class="d-flex align-items-center">
                    <span class="mr-auto">รายงานสถิติช่วงอายุของผู้เรียนในแต่ละหลักสูตร ( ช่วงที่ 1 อายุไม่เกิน 11 ปี /
                        ช่วงที่ 2 อายุ12 - 17 ปี / ช่วงที่ 3 อายุ 18 - 25 ปี
                        / ช่วงที่ 4 อายุเกิน 25 ปีขึ้นไป )</span>
                    <!-- <a
                                                      href="https://aced.dlex.ai/childhood/admin/export/pdf.html"
                                                      class="btn btn-icon btn-outline-danger"><i class="fa fa-file-pdf"></i></a>&nbsp;<a
                                                      href="https://aced.dlex.ai/childhood/admin/export/excel.html"
                                                      class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>-->&nbsp;<a
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
                                <th class="text-center" colspan="4">รายงานสถิติช่วงอายุของผู้เรียนในแต่ละหลักสูตร
                                    ( ช่วงที่ 1 อายุไม่เกิน 11 ปี / ช่วงที่ 2 อายุ12 - 17 ปี / ช่วงที่ 3 อายุ 18 - 25 ปี
                                    / ช่วงที่ 4 อายุเกิน 25 ปีขึ้นไป )</th>

                            </tr>
                            <tr class="text-center">
                                <th align="center" width="5%">ลำดับ</th>
                                <th align="center">ชื่อหลักสูตร</th>
                                <th align="center" width="10%">ช่วงอายุ</th>
                                <th align="center" width="10%">จำนวน (คน)</th>

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
                var filteredLearner = learner.filter(function(data) {
                    return data.year == selectedYear;
                });
     
                displayDataInTable(filteredLearner);
            });
            $('#selectyear').trigger('change');

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
                    row.append($('<td >').text(item.course_th));
                    row.append($('<td class="text-center">').text(
                        item.department_id == 1 ? 'อายุไม่เกิน 11 ปี' :
                        item.department_id == 2 ? 'อายุไม่เกิน 11 ปี' :
                        item.department_id == 3 ? 'อายุ 12 - 17 ปี' :
                        item.department_id == 5 ? 'อายุ 18 - 25 ปี' :
                        item.department_id == 6 ? 'อายุเกิน 25 ปีขึ้นไป' :
                        item.department_id == 7 ? 'อายุเกิน 25 ปีขึ้นไป' : ''
                    ));
                    row.append($('<td class="text-center">').text(item.user_count));
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
