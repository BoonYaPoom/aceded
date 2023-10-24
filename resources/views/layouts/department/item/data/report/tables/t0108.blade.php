@extends('layouts.department.item.data.report.index')
@section('Departreportspage')
    <!-- .page-inner -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #section-to-print,
            #section-to-print * {
                visibility: visible;
            }

            #section-to-print {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
    <div class="page-inner">

  
        <form method="post" id="formreport">
            <div class="form-row">
                <!-- form column -->
            <!--      <div class="col-md-1"><span class="mt-1 ">ปี</span></div>
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
                    <span class="mr-auto">รายชื่อผู้ฝึกอบรมที่เข้าฝึกอบรมมากที่สุด</span> <a
                        href="https://aced.dlex.ai/childhood/admin/export/pdf.html"
                        class="btn btn-icon btn-outline-danger"><i class="fa fa-file-pdf"></i></a>&nbsp;<a
                        href="https://aced.dlex.ai/childhood/admin/export/excel.html"
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
                                <th class="text-center" colspan="6">รายชื่อผู้ฝึกอบรมที่เข้าฝึกอบรมมากที่สุด</th>
                            </tr>
                            <tr class="text-center">
                                <th align="center" width="5%">ลำดับ</th>
                                <th align="center" width="15%">ชื่อผู้ใช้งาน</th>
                                <th align="center">ชื่อ - สกุล</th>

                                <th align="center" width="15%">จำนวนลงทะเบียน</th>
                            </tr>
                            @php
                            // Fetch logs with logid = 1 and group them by user_id
                            $countLogsByuser_id = \App\Models\Log::where('logid', 1)
                                ->get()
                                ->groupBy('user_id');
                            $i = 1;
                            
                            // Fetch users with user_role 4
                            $user_data = \App\Models\Users::where('user_role', 4)->get();
                        @endphp
                            @foreach ($user_data as $uLog)
                            @php
                            $logCount = isset($countLogsByuser_id[$uLog->user_id]) ? $countLogsByuser_id[$uLog->user_id]->count() : 0;
                        @endphp
                         @if ($logCount > 0)
                            <tr>
                                <td align="center">{{ $i++ }}</td>
                                <td>{{$uLog->username}}</td>
                                <td>{{ $uLog->firstname }} {{ $uLog->lastname }}</td>
                                <td class="text-right">{{ $logCount}} &nbsp;</td>
                            </tr>
                            @endif
                            @endforeach
                            </tbody><!-- /tbody -->
                    </table><!-- /.table -->
                </div><!-- /.table-responsive -->
            </div><!-- /.card-body -->
        </div><!-- /.card -->
        <!-- .page-title-bar -->

    </div><!-- /.page-inner -->
    <!-- .page-sidebar -->
@endsection
