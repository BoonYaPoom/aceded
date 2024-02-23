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
                    <span class="mr-auto">รายงานการดาวน์โหลดเอกสาร e-book Multimedia ของผู้เรียน</span>
                    {{-- <a
                            href="https://aced.dlex.ai/childhood/admin/export/pdf.html"
                            class="btn btn-icon btn-outline-danger"><i class="fa fa-file-pdf"></i></a> --}}
                    &nbsp;
                    <a href="#" class="btn btn-icon btn-outline-primary download-excel"><i
                            class="fa fa-file-excel"></i></a>&nbsp;
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
                                <th class="text-center" colspan="6">รายงานการดาวน์โหลดเอกสาร e-book Multimedia
                                    ของผู้เรียน</th>
                            </tr>
                            <tr class="text-center">
                                <th align="center" width="5%">ลำดับ</th>
                                <th align="center" width="45%">เอกสาร e-book Multimedia</th>
                                <th align="center" width="20%">จำนวน</th>
                            </tr>


                        <tbody id="learend"></tbody>
                        <script>
                            $(document).ready(function() {
                                $('#selectyear').on('change', function() {
                                    var learner = {!! json_encode($learner) !!};
                                    var selectedYear = $('#selectyear').val();
                                    var filteredLearner = learner.filter(function(data) {
                                        return data.year == selectedYear;
                                    });
                                    $(".download-excel").on("click", function() {
                                        var url = "{{ route('exportT0103', [':selectedYear']) }}"
                                            .replace(':selectedYear', selectedYear);
                                        window.location.href = url;
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
                                        row.append($('<td >').text(item.book_name));
                                        row.append($('<td class="text-center">').text(item.user_count));
                                        // เพิ่มแถวลงใน tbody
                                        $('#learend').append(row);
                                    });
                                } else {
                                    // ถ้าไม่มีข้อมูล
                                    var noDataMessage = $('<tr><td colspan="53 class="text-center">ไม่มีข้อมูลในจังหวัดนี้ </td></tr>');
                                    $('#learend').append(noDataMessage);
                                }
                            }
                        </script>
                    </table><!-- /.table -->
                </div><!-- /.table-responsive -->
            </div><!-- /.card-body -->
        </div><!-- /.card -->
        <!-- .page-title-bar -->

    </div><!-- /.page-inner -->
@endsection
