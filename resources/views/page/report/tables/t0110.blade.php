@extends('page.report.index')
@section('reports')
    <!-- .page-inner -->
 
    <div class="page-inner">

        <form method="post" id="formreport">
            <div class="form-row">
                <!-- form column -->
            <!--    <div class="col-md-1"><span class="mt-1 ">ปี</span></div>
                <div class="col-md-3">
                    <div class=""><select id="selectyear" name="selectyear" class="form-control" data-toggle="select2"
                            data-placeholder="ปี" data-allow-clear="false" onchange="$('#formreport').submit();">
                            <option value="2022"> {{$oneYearsAgo}} </option>
                            <option value="2023" selected> {{$currentYear}} </option>
                        </select></div>
                </div>-->
                <div class="col-md-3 ">
                    <div class="d-none"><select id="selectmonth" name="selectmonth" class="form-control "
                            data-toggle="select2" data-placeholder="เดือน" data-allow-clear="false"
                            onchange="$('#formreport').submit();">
                            <option value="0">เดือน</option>
                            @foreach ($month as $im => $m)
                            <option value="{{$im}}"> {{$m}} </option>
                           
                            @endforeach
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
                    <span class="mr-auto">การสำรองและการกู้คืนข้อมูล</span><!-- <a
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
                                <th class="text-center" colspan="6">การสำรองและการกู้คืนข้อมูล</th>
                            </tr>
                            <tr class="text-center">
                                <th align="center" width="5%">ลำดับ</th>
                                <th align="center">เดือน</th>
                                <th align="center" width="15%">การสำรองไฟล์</th>
                                <th align="center" width="15%">การสำรองฐานข้อมูล</th>
                            </tr>
                            <tr>
                                <td align="center">1</td>
                                <td>ตุลาคม 2565</td>
                                <td class="text-right">17.10 GB. </td>
                                <td class="text-right">3.42 MB. </td>
                            </tr>
                            <tr>
                                <td align="center">2</td>
                                <td>พฤศจิกายน 2565</td>
                                <td class="text-right">18.10 GB. </td>
                                <td class="text-right">3.52 MB. </td>
                            </tr>
                            </tbody><!-- /tbody -->
                    </table><!-- /.table -->
                </div><!-- /.table-responsive -->
            </div><!-- /.card-body -->
        </div><!-- /.card -->
        <!-- .page-title-bar -->

    </div><!-- /.page-inner -->
@endsection
