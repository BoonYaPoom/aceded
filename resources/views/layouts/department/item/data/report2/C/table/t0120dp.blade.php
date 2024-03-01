@extends('layouts.department.item.data.report2.index')
@section('reports22')



    <div class="page-inner">
        <div class="form-row">

            <div class="col-md-5"></div>
            <span class="mt-1">หลักสูตร</span>&nbsp;
  
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
     
        <div class="card-header bg-muted">
            <div class="d-flex align-items-center">
                <span class="mr-auto">รายงานสถิติการเข้าใช้งานรายปี
                    (ผู้ใช้งานใหม่)</span>
{{-- 
                <a href="#" class="btn btn-icon btn-outline-primary download-excel"><i
                        class="fa fa-file-excel"></i></a> --}}
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
                                (ผู้ใช้งานใหม่)</th>
                        </tr>
                        <tr class="text-center">
                            <th align="center" width="5%">ลำดับ</th>
                            <th align="center">ปี</th>
                            <th align="center" width="15%">จำนวนรายการ (คน)</th>
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
            $('#provin').on('change', function() {
                var learner = {!! json_encode($learner) !!};
                var provin = $('#provin').val();
                var filteredLearner = learner.filter(function(data) {
                    return  data.province_name == provin;
                });
        
                displayDataInTable(filteredLearner);
            });
            $('#provin').trigger('change');
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
