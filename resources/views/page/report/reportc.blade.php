@extends('page.report.index')
@section('reports')
    <div class="page-inner">

        <form method="post" id="formreport">
            <div class="form-row">
                <!-- form column -->
             <!--   <div class="col-md-1"><span class="mt-1 ">ปี</span></div>
                <div class="col-md-3">
                    <div class=""><select id="selectyear" name="selectyear" class="form-control" data-toggle="select2"
                            data-placeholder="ปี" data-allow-clear="false" onchange="$('#formreport').submit();">
                            <option value="2022"> 2565 </option>
                            <option value="2023" selected> 2566 </option>
                        </select></div>
                </div>  -->
                <div class="col-md-3 ">
                    <div class="d-none"><select id="selectmonth" name="selectmonth" class="form-control "
                            data-toggle="select2" data-placeholder="เดือน" data-allow-clear="false"
                            onchange="$('#formreport').submit();">
                            <option value="0">เดือน</option>
                            <option value="10"> ตุลาคม </option>
                            <option value="11"> พฤศจิกายน </option>
                            <option value="12"> ธันวาคม </option>
                            <option value="1"> มกราคม </option>
                            <option value="2"> กุมภาพันธ์ </option>
                            <option value="3"> มีนาคม </option>
                            <option value="4"> เมษายน </option>
                            <option value="5"> พฤษภาคม </option>
                            <option value="6"> มิถุนายน </option>
                            <option value="7"> กรกฎาคม </option>
                            <option value="8"> สิงหาคม </option>
                            <option value="9"> กันยายน </option>
                        </select></div>
                </div>
                <div class="col-md-1 text-right"><button type="button" class="btn btn-light btn-icon d-xl-none"
                        data-toggle="sidebar"><i class="fa fa-angle-double-left fa-lg"></i></button></div>
                <!-- /form column -->
            </div><!-- /form row -->
        </form>
        <!-- .table-responsive --><br><!-- .card -->
        <div class="card card-fluid">
            <!-- .card-header -->
            <div class="card-header bg-muted">
                <div class="d-flex align-items-center">
                    <span class="mr-auto">รายงานเชิงตาราง ปี 2566</span> <a
                        href="{{route('generatePdf')}}"
                        class="btn btn-icon btn-outline-danger"><i class="fa fa-file-pdf"></i></a>&nbsp;<a
                        href="{{route('ReportExp')}}"
                        class="btn btn-icon btn-outline-primary"><i class="fa fa-file-excel "></i></a>&nbsp;<a
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
                                <td align="center"><a href="{{route('ReportUserAuth')}}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

                            </tr>
                            <tr>
                                <td align="center">2</td>
                                <td>รายชื่อผู้ฝึกอบรมที่เข้าฝึกอบรมมากที่สุด</td>
                                <td align="center"><a href="{{route('trainUserAuth')}}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

                            </tr>

                            <tr>
                                <td align="center">3</td>
                                <td>รายงานการดาวน์โหลดเอกสาร e-book Multimedia ของผู้เรียน</td>
                                <td align="center"><a href="{{route('bookUserAuth')}}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

                            </tr>
                            <tr>
                                <td align="center">4</td>
                                <td>รายงานการ Login ของผู้เรียน</td>
                                <td align="center"><a href="{{route('LoginUserAuth')}}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

                            </tr>
                           <!-- <tr>
                                <td align="center">5</td>
                                <td>การสำรองและการกู้คืนข้อมูล</td>
                                <td align="center"><a href="{{route('BackUserAuth')}}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

                            </tr>
                            <tr>
                                <td align="center">6</td>
                                <td>สรุปรายรับในการฝึกอบรมรายเดือน</td>
                                <td align="center"><a href="{{route('reportMUserAuth')}}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

                            </tr>
                            <tr>
                                <td align="center">7</td>
                                <td>สรุปรายรับในการฝึกอบรมรายไตรมาส</td>
                                <td align="center"><a href="{{route('reportYeaAuth')}}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

                            </tr>
                            <tr>
                                <td align="center">8</td>
                                <td>สรุปรายรับในการฝึกอบรมรายปี</td>
                                <td align="center"><a
                                        href="{{route('reportQuarterlyAuth')}}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

                            </tr>
                            <tr>
                                <td align="center">9</td>
                                <td>สำรองข้อมูล (Backup System) แบบ Full Backup</td>
                                <td align="center"><a
                                        href="{{route('BackupFullUserAuth')}}"><i
                                            class="fas fa-chart-bar text-teal mr-2"></i></a></td>

                            </tr>-->
                            <tr>
                                <td align="center">5</td>
                                <td>ข้อมูล Log File ในรูปแบบรายงานทางสถิติ</td>
                                <td align="center"><a
                                        href="{{route('LogFileUserAuth')}}"><i
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
