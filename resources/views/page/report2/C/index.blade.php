@extends('page.report2.index')
@section('reports2')
    <div class="page-inner">
        <div class="form-row">
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
        </div>
        <br>
        <div class="card card-fluid">
            <!-- .card-header -->
            <div class="card-header bg-muted">
                <div class="d-flex align-items-center">
                    <span class="mr-auto">รายงานเชิงตาราง </span>
                    &nbsp;<a href="#" class="btn btn-icon btn-outline-primary download-AllT0000"><i
                            class="fa fa-file-excel "></i></a>
                </div>
            </div><!-- /.card-header -->
            <!-- .card-body -->

            <div class="card-body">
                <div class="table-responsive">
                    <table border="1" style="width:100%" id="section-to-print">
                        <!-- thead -->
                        <thead>
                            <tr>
                                <th id="heaid" class="text-center" colspan="6"></th>
                            </tr>
                            <tr class="text-center">
                                <th align="center" width="10%">ลำดับ</th>
                                <th align="center" width="80%">ชื่อรายงาน</th>
                                <th align="center" width="5%">รายงาน</th>
                                <th align="center" width="5%">ดาวโหลด</th>
                            </tr>
                            <tr>
                                <td align="center">1</td>
                                <td>รายงานข้อมูลรายชื่อผู้เรียนทั้งหมด และแยกตามหลักสูตร</td>
                                <td align="center"><a href="{{ route('T0101') }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a>
                                </td>
                                <td align="center">
                                    <a class="download-T0101" href="#"> <i
                                            class="fas fa-file-excel text-teal mr-2 "></i></a>
                                </td>

                            </tr>

                            <tr>
                                <td align="center">2</td>
                                <td>รายงานสถานะผู้เข้าเรียน และจบการศึกษา (รายบุคคล)
                                </td>
                                <td align="center"><a href="{{ route('T0116') }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a>
                                </td>
                                <td align="center">
                                    <a class="download-T0116" href="#"> <i
                                            class="fas fa-file-excel text-teal mr-2"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">3</td>
                                <td>รายงานการดาวน์โหลดเอกสาร e-book Multimedia ของผู้เรียน</td>
                                <td align="center"><a href="{{ route('T0103') }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a>
                                </td>
                                <td align="center">
                                    <a class="download-T0103" href="#"> <i
                                            class="fas fa-file-excel text-teal mr-2"></i></a>
                                </td>

                            </tr>

                            <tr>
                                <td align="center">4</td>
                                <td>รายงานสถิติช่วงอายุของผู้เรียนในแต่ละหลักสูตร (ช่วงที่ 1 อายุไม่เกิน 11 ปี / ช่วงที่ 2
                                    อายุ12 - 17 ปี / ช่วงที่ 3 อายุ 18 - 25 ปี / ช่วงที่ 4 อายุเกิน 25 ปีขึ้นไป)
                                </td>
                                <td align="center"><a href="{{ route('T0117') }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a>
                                </td>
                                <td align="center">
                                    <a class="download-T0117" href="#"> <i
                                            class="fas fa-file-excel text-teal mr-2"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">5</td>
                                <td>รายงานสถิติการเข้าใช้งานรายเดือน
                                    (ยอด View)
                                </td>
                                <td align="center"><a href="{{ route('T0118') }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a>
                                </td>
                                <td align="center">
                                    <a class="download-T0118" href="#"> <i
                                            class="fas fa-file-excel text-teal mr-2"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">6</td>
                                <td>รายงานสถิติการเข้าใช้งานรายไตรมาส
                                    (ยอด View)
                                </td>
                                <td align="center"><a href="{{ route('T0119') }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a>
                                </td>
                                <td align="center">
                                    <a class="download-T0119" href="#"> <i
                                            class="fas fa-file-excel text-teal mr-2"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">7</td>
                                <td> รายงานสถิติการเข้าใช้งานรายปี
                                    (ยอด View)
                                </td>
                                <td align="center"><a href="{{ route('T0120') }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a>
                                </td>
                                <td align="center">
                                    <a class="download-T0120" href="#"> <i
                                            class="fas fa-file-excel text-teal mr-2"></i></a>
                                </td>
                            </tr>
                            {{-- <tr>
                                <td align="center">8</td>
                                <td> รายงานสถิติการเข้าใช้งานรายเดือน
                                    (กลุ่มบุคลากรภาครัฐ และรัฐวิสาหกิจ)
                                </td>
                                <td align="center"><a href="{{ route('T0121') }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>
                            </tr>
                            <tr>
                                <td align="center">9</td>
                                <td> รายงานสถิติการเข้าใช้งานรายเดือน
                                    (กลุ่มการศึกษาขั้นพื้นฐาน)
                                </td>
                                <td align="center"><a href="{{ route('T0122') }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

                            </tr>
                            <tr>
                                <td align="center">10</td>
                                <td> รายงานสถิติการเข้าใช้งานรายเดือน
                                    (กลุ่มอุดมศึกษา)
                                    
                                </td>
                                <td align="center"><a href="{{ route('T0123') }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

                            </tr>
                            <tr>
                                <td align="center">11</td>
                                <td>รายงานสถิติการเข้าใช้งานรายเดือน
                                    (กลุ่มอาชีวศึกษา)
                                    
                                    
                                </td>
                                <td align="center"><a href="{{ route('T0124') }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

                            </tr>
                            <tr>
                                <td align="center">12</td>
                                <td>รายงานสถิติการเข้าใช้งานรายเดือน
                                    (กลุ่มโค้ช และประชาชน)
                                </td>
                                <td align="center"><a href="{{ route('T0125') }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

                            </tr> --}}
                            </tbody><!-- /tbody -->
                    </table><!-- /.table -->
                </div><!-- /.table-responsive -->
            </div><!-- /.card-body -->
        </div><!-- /.card -->
        <!-- .page-title-bar -->

    </div><!-- /.page-inner -->

    <script>
        $(document).ready(function() {
            $('#selectyear').on('change', function() {
                var selectedYear = $('#selectyear').val();
                $('#heaid').text('รายงานเชิงตาราง ปี ' + selectedYear);
                $(".download-T0101").on("click", function() {
                    var url = "{{ route('exportT0101ALL', [':selectedYear']) }}"
                        .replace(':selectedYear', selectedYear);
                    window.location.href = url;
                });
                $(".download-T0103").on("click", function() {
                    var url = "{{ route('exportT0103ALL', [':selectedYear']) }}"
                        .replace(':selectedYear', selectedYear);
                    window.location.href = url;
                });
                $(".download-T0116").on("click", function() {
                    var url = "{{ route('exportT0116ALL', [':selectedYear']) }}"
                        .replace(':selectedYear', selectedYear);
                    window.location.href = url;
                });
                $(".download-T0117").on("click", function() {
                    var url = "{{ route('exportT0117ALL', [':selectedYear']) }}"
                        .replace(':selectedYear', selectedYear);
                    window.location.href = url;
                });
                $(".download-T0118").on("click", function() {
                    var url = "{{ route('exportT0118ALL', [':selectedYear']) }}"
                        .replace(':selectedYear', selectedYear);
                    window.location.href = url;
                });
                $(".download-T0119").on("click", function() {
                    var url = "{{ route('exportT0119ALL', [':selectedYear']) }}"
                        .replace(':selectedYear', selectedYear);
                    window.location.href = url;
                });

                $(".download-T0120").on("click", function() {
                    var url = "{{ route('exportT0120ALL') }}";
                    window.location.href = url;
                });
                   $(".download-AllT0000").on("click", function() {
                    var url = "{{ route('exportAllT0000') }}";
                    window.location.href = url;
                });

            });
            $('#selectyear').trigger('change');


        });
    </script>
@endsection
