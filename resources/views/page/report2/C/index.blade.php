@extends('page.report2.index')
@section('reports2')
    <div class="page-inner">

        <div class="card card-fluid">
            <!-- .card-header -->
            <div class="card-header bg-muted">
                <div class="d-flex align-items-center">
                    <span class="mr-auto">รายงานเชิงตาราง </span> <a href="{{ route('generatePdf') }}"
                        class="btn btn-icon btn-outline-danger"><i class="fa fa-file-pdf"></i></a>&nbsp;<a
                        href="{{ route('ReportExp') }}" class="btn btn-icon btn-outline-primary"><i
                            class="fa fa-file-excel "></i></a>&nbsp;<a href="javascript:window.print();"
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
                                <th class="text-center" colspan="6">รายงานเชิงตาราง ปี 2566</th>
                            </tr>
                            <tr class="text-center">
                                <th align="center" width="10%">ลำดับ</th>
                                <th align="center" width="80%">ชื่อรายงาน</th>
                                <th align="center" width="10%">รายงาน</th>
                            </tr>
                            <tr>
                                <td align="center">1</td>
                                <td>รายงานข้อมูลรายชื่อผู้เรียนทั้งหมด และแยกตามหลักสูตร</td>
                                <td align="center"><a href="{{ route('T0101') }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

                            </tr>

                            <tr>
                                <td align="center">2</td>
                                <td>รายงานสถานะผู้เข้าเรียน และจบการศึกษา (รายบุคคล)
                                </td>
                                <td align="center"><a href="{{ route('T0116') }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>
                            </tr>
                            <tr>
                                <td align="center">3</td>
                                <td>รายงานการดาวน์โหลดเอกสาร e-book Multimedia ของผู้เรียน</td>
                                <td align="center"><a href="{{ route('T0103') }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

                            </tr>
                        
                            <tr>
                                <td align="center">4</td>
                                <td>รายงานสถิติช่วงอายุของผู้เรียนในแต่ละหลักสูตร (ช่วงที่ 1 อายุไม่เกิน 11 ปี / ช่วงที่ 2
                                    อายุ12 - 17 ปี / ช่วงที่ 3 อายุ 18 - 25 ปี / ช่วงที่ 4 อายุเกิน 25 ปีขึ้นไป)
                                </td>
                                <td align="center"><a href="{{ route('T0117') }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>
                            </tr>
                            <tr>
                                <td align="center">5</td>
                                <td>รายงานสถิติการเข้าใช้งานรายเดือน
                                    (ผู้ใช้งานใหม่)
                                </td>
                                <td align="center"><a href="{{ route('T0118') }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>
                            </tr>
                            <tr>
                                <td align="center">6</td>
                                <td>รายงานสถิติการเข้าใช้งานรายไตรมาส
                                    (ผู้ใช้งานใหม่)
                                </td>
                                <td align="center"><a href="{{ route('T0119') }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>
                            </tr>
                            <tr>
                                <td align="center">7</td>
                                <td> รายงานสถิติการเข้าใช้งานรายปี
                                    (ผู้ใช้งานใหม่)
                                </td>
                                <td align="center"><a href="{{ route('T0120') }}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>
                            </tr>
                            <tr>
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

                            </tr>
                            </tbody><!-- /tbody -->
                    </table><!-- /.table -->
                </div><!-- /.table-responsive -->
            </div><!-- /.card-body -->
        </div><!-- /.card -->
        <!-- .page-title-bar -->

    </div><!-- /.page-inner -->
@endsection
