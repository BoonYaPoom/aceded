@extends('page.report2.index')
@section('reports2')
    <!-- .page-inner -->

    <div class="page-inner">

        <div class="form-row">
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
            <span class="mt-1">จังหวัด</span>&nbsp;
            <div class="col-md-3">
                <select id="provin" name="provin" class="form-control" data-toggle="select2" data-placeholder="หลักสูตร"
                    data-allow-clear="false">
                    @foreach ($provin as $pro)
                        <option value="{{ $pro->name_in_thai }}"
                            {{ $pro->name_in_thai == 'กรุงเทพมหานคร' ? 'selected' : '' }}>
                            {{ $pro->name_in_thai }} </option>
                    @endforeach
                </select>
            </div>
        </div><!-- /form row -->

        <!-- .table-responsive --><br><!-- .card -->
        <div class="card card-fluid">
            <!-- .card-header -->
            <div class="card-header bg-muted">
                <div class="d-flex align-items-center">
                    <span class="mr-auto">รายงานสถิติการเข้าใช้งานรายไตรมาส
                        (ผู้ใช้งานใหม่)</span>
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
                                <th class="text-center" colspan="6">รายงานสถิติการเข้าใช้งานรายไตรมาส
                                    (ผู้ใช้งานใหม่)</th>
                            </tr>
                            <tr class="text-center">
                                <th align="center" width="5%">ลำดับ</th>
                                <th align="center">ไตรมาส</th>
                                <th align="center" width="15%">จำนวนรายการ (คน)</th>

                            </tr>
                        <tbody id="learend"></tbody>
                    </table><!-- /.table -->
                </div><!-- /.table-responsive -->
            </div><!-- /.card-body -->
        </div><!-- /.card -->
        <!-- .page-title-bar -->
    </div><!-- /.page-inner -->
   <script>
        $(document).ready(function() {
            $('#selectyear, #provin').on('change', function() {
                var learner = {!! json_encode($learner) !!};
                var dateAll = {!! json_encode($dateAllWithId) !!};
                var provin = $('#provin').val();
                var selectedYear = $('#selectyear').val();

                var filteredLearner = learner.filter(function(data) {
                    return  data.year == selectedYear && data.province_name == provin;
                });

                displayDataInTable(filteredLearner, dateAll);
            });
            $('#provin').trigger('change');
            $('#selectedYear').trigger('change');
        });

        function displayDataInTable(filteredLearner, dateAll) {
            $('#learend').empty()
            if (dateAll && dateAll.length > 0) {
                // วนลูปเพื่อแสดงข้อมูลใน tbody
                var i = 1;
                $.each(dateAll, function(index, item) {
                    // สร้างแถวใน tbody
                    var row = $('<tr>');
                    // เพิ่มข้อมูลลงในแถว
                    row.append($('<td class="text-center">').text(i++));
                    row.append($('<td >').text(item.ta));
                    var matchingLearner = filteredLearner.find(function(learner) {
                        return learner.ta == item.id;
                    });

                    if (matchingLearner) {
                        row.append($('<td class="text-center">').text(matchingLearner.user_count));
                    } else {
                        row.append($('<td class="text-center">').text('0'));
                    }
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
