@extends('page.report2.index')
@section('reports2')
    <!-- .page-inner -->

    <div class="page-inner">
        <div class="form-row">
            <!-- form column -->
            <div class="col-md-5"></div>
            <span class="mt-1">หลักสูตร</span>&nbsp;
            <div class="col-md-3">
                <div><select id="depa" name="depa" class="form-control" data-toggle="select2" data-placeholder="หลักสูตร"
                        data-allow-clear="false">

                        @php
                            $depart = DB::table('department')->where('department_status', 1)->get();
                        @endphp
                        @foreach ($depart->sortBy('department_id') as $de)
                            <option value="{{ $de->department_id }}" {{ $de->department_id == 1 ? 'selected' : '' }}>
                                {{ $de->name_th }} </option>
                        @endforeach
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
        </div>
    </div>
    <br>
    <div class="card card-fluid">
        <!-- .card-header -->
        <div class="card-header bg-muted">
            <div class="d-flex align-items-center">
                <span class="mr-auto">รายงานสถิติการเข้าใช้งานรายปี
                    (ยอด View)</span>

                <a href="#" class="btn btn-icon btn-outline-primary download-excel"><i
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
                            <th class="text-center" colspan="6">รายงานสถิติการเข้าใช้งานรายปี
                                (ยอด View)</th>
                        </tr>
                        <tr class="text-center">
                            <th align="center" width="5%">ลำดับ</th>
                            <th align="center">ปี</th>
                            <th align="center" width="15%">จำนวนรายการ</th>
                        </tr>

                    <tbody id="learend">

                    </tbody>
                </table>
            </div>
        </div>
    </div>


    </div>
    <script>
        $(document).ready(function() {
            $('#depa, #provin').on('change', function() {
                var learner = {!! json_encode($learner) !!};
                var depa = $('#depa').val();
                var provin = $('#provin').val();
                var filteredLearner = learner.filter(function(data) {
                    return data.department_id == depa && data.province_name == provin;
                });
                $(".download-excel").on("click", function() {
                    var url = "{{ route('exportT0120', [':depa', ':provin']) }}"
                        .replace(':depa', depa)
                        .replace(':provin', provin)
                    window.location.href = url;
                });
                displayDataInTable(filteredLearner);
            });
            $('#provin').trigger('change');
            $('#depa').trigger('change');
        });

        function displayDataInTable(filteredLearner) {
            $('#learend').empty()
            if (filteredLearner && filteredLearner.length > 0) {
                // วนลูปเพื่อแสดงข้อมูลใน tbody
                var i = 1;
                $.each(filteredLearner, function(index, item) {
                    // สร้างแถวใน tbody
                    var row = $('<tr>');
                    // เพิ่มข้อมูลลงในแถว
                    row.append($('<td class="text-center">').text(i++));
                    row.append($('<td >').text(item.year));
                    row.append($('<td >').text(item.user_count));
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
