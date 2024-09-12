@extends('page.report2.index')
@section('reports2')
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
            <div class="col-md-3">

                <div><select id="depa" name="depa" class="form-control" data-toggle="select2"
                        data-placeholder="หลักสูตร" data-allow-clear="false">
                        <option value="0" selected>ทั้งหมด </option>
                        @php
                            $depart = DB::table('department')->where('department_status', 1)->get();
                        @endphp
                        @foreach ($depart->sortBy('department_id') as $de)
                            <option value="{{ $de->department_id }}">
                                {{ $de->name_th }} </option>
                        @endforeach
                    </select></div>
            </div>
            <span class="mt-1">จังหวัด</span>&nbsp;
            <div class="col-md-3 ">
                <select id="provin" name="provin" class="form-control" data-toggle="select2" data-placeholder="หลักสูตร"
                    data-allow-clear="false">
                    @foreach ($provin as $pro)
                        <option value="{{ $pro->id }}" {{ $pro->name_in_thai == 'กรุงเทพมหานคร' ? 'selected' : '' }}>
                            {{ $pro->name_in_thai }} </option>
                    @endforeach
                </select>
            </div>

        </div><!-- /form row -->

        <br>
        <div class="card card-fluid">
            <!-- .card-header -->
            <div class="card-header bg-muted">
                <div class="d-flex align-items-center">
                    <span class="mr-auto">รายงานข้อมูลรายชื่อผู้เรียนทั้งหมด และแยกตามหลักสูตร</span>
                    {{-- <a href="" class="btn btn-icon btn-outline-danger"><i class="fa fa-file-pdf"></i></a> --}}
                    &nbsp;<a href="#" class="btn btn-icon btn-outline-primary download-excel"><i
                            class="fa fa-file-excel"></i></a>
                    &nbsp;

                    <a class="btn btn-icon btn-outline-success print-button"><i class="fa fa-print"></i></a>
                </div>
            </div><!-- /.card-header -->
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
                                <th class="text-center" colspan="6">รายงานข้อมูลรายชื่อผู้เรียนทั้งหมด และแยกตามหลักสูตร
                                </th>
                            </tr>
                            <tr class="text-center">
                                <th align="center" width="5%">ลำดับ</th>
                                <th align="center" width="20%">ชื่อ - สกุล</th>
                                <th align="center" width="20%">สังกัด</th>
                                <th align="center">หลักสูตร</th>
                                <th align="center" width="10%">วันที่ลงทะเบียนเรียน</th>
                                <th align="center" width="10%">วันที่จบหลักสูตร</th>
                            </tr>
                        </thead>
                        17260445930
                        <script>
                            $(document).ready(function() {
                                $('#selectyear, #depa, #provin').on('change', function() {
                                    var depa = $('#depa').val();
                                    var selectedYear = $('#selectyear').val();
                                    var provin = $('#provin').val();
                                    var apiUrl = '{{ route('T0101api', ['year', 'provin']) }}'
                                        .replace('year', selectedYear)
                                        .replace('provin', provin);
                                    $.ajax({
                                        url: apiUrl,
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function(response) {
                                            var filteredLearner = response.filter(function(data) {
                                                if (depa == 0) {
                                                    return data;
                                                } else {
                                                    return data.department_id == depa;
                                                }
                                            });
                                            displayDataInTable(filteredLearner);
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Error fetching data:', xhr, status, error);
                                            $('#learend').html(
                                                '<tr><td colspan="6" class="text-center">เกิดข้อผิดพลาดในการดึงข้อมูล</td></tr>'
                                            );
                                        }
                                    });
                                });
                                $('#selectyear').trigger('change');
                                $(".download-excel").on("click", function() {
                                    var depa = $('#depa').val();
                                    var selectedYear = $('#selectyear').val();
                                    var provin = $('#provin').val();
                                    var url = generateExcelDownloadUrl(depa, provin, selectedYear);
                                    window.location.href = url;
                                });
                            });

                            function generateExcelDownloadUrl(depa, provin, selectedYear) {
                                return "{{ route('exportT0101', [':depa', ':provin', ':selectedYear']) }}"
                                    .replace(':depa', depa)
                                    .replace(':provin', provin)
                                    .replace(':selectedYear', selectedYear);
                            }

                            function displayDataInTable(data) {
                                $('#learend').empty();

                                if (data && data.length > 0) {
                                    var i = 1;
                                    $.each(data, function(index, item) {
                                        var row = $('<tr>');
                                        row.append($('<td class="text-center">').text(i++));
                                        row.append($('<td>').text(item.firstname + ' ' + item.lastname));
                                        row.append($('<td>').text(item.exten_name));
                                        row.append($('<td>').text(item.course_th));
                                        row.append($('<td class="text-center">').text(item.register_date));
                                        row.append($('<td class="text-center">').text(item.realcongratulationdate));
                                        $('#learend').append(row);
                                    });
                                } else {
                                    var noDataMessage = $('<tr><td colspan="6" class="text-center">ไม่มีข้อมูลในจังหวัดนี้</td></tr>');
                                    $('#learend').append(noDataMessage);
                                }
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
