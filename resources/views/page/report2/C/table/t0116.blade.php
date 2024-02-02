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
                                            <option value="2022"> {{ $oneYearsAgo }} </option>
                                            <option value="2023" selected> {{ $currentYear }} </option>
                                        </select></div>
                                </div>-->
                <div class="col-md-3 ">
                    <div class="d-none"><select id="selectmonth" name="selectmonth" class="form-control "
                            data-toggle="select2" data-placeholder="เดือน" data-allow-clear="false"
                            onchange="$('#formreport').submit();">
                            <option value="0">เดือน</option>
                            @foreach ($month as $im => $m)
                                <option value="{{ $im }}"> {{ $m }} </option>
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
                    <span class="mr-auto">ข้อมูล Log File ในรูปแบบรายงานทางสถิติ</span>
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
                                <th class="text-center" colspan="4">รายงานสถานะผู้เข้าเรียน และจบการศึกษา (รายบุคคล)</th>
                                <th class="text-center" width="5%">สถานะ</th>
                            </tr>
                            <tr class="text-center">
                                <th align="center" width="5%">ลำดับ</th>
                                <th align="center">ชื่อ - สกุล</th>
                                <th align="center" width="20%">สังกัด</th>
                                <th align="center" width="30%">ชื่อหลักสูตร</th>
                                <th align="center" width="15%">N/A = กำลังเรียน P = เรียนจบ
                                </th>
                            </tr>


                            <!-- tr --> @php
                                $n = 1;
                                $result = []; // สร้างตัวแปรเก็บผลลัพธ์
                                $uniqueUserIds = [];
                                $users = null;
                                $UserSchool = null;
                                $schoolName = null;
                            @endphp
                            @foreach ($learners as $l => $learns)
                                @php

                                    $dataLearn = $learns->registerdate;
                                    $congrateLearn = $learns->realcongratulationdate;
                                    $congrate = $learns->congratulation;
                                    $monthsa = \ltrim(\Carbon\Carbon::parse($dataLearn)->format('m'), '0');
                                    $newDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $learns->registerdate)->format('d/m/Y H:i:s');
                                    $users = \App\Models\Users::find($learns->user_id);

                                    if ($users) {
                                        $UserSchool = \App\Models\Extender2::where('extender_id', $users->organization)->first();

                                        if ($UserSchool) {
                                            $schoolName = $UserSchool->name;
                                        } else {
                                            $schoolName = [];
                                        }
                                    } else {
                                        $schoolName = [];
                                    }

                                    $courses = \App\Models\Course::find($learns->course_id);

                                    if ($courses) {
                                        // Access properties of the $courses object here
                                        $course_th = $courses->course_th;
                                        // ...
                                    } else {
                                    }

                                @endphp

                                @if (isset($users) && $users)
                                    <tr>
                                        <td align="center">{{ $n++ }}</td>

                                        <td align="center">
                                            @if (optional($users)->firstname)
                                                {{ $users->firstname }}
                                            @else
                                            @endif
                                            @if (optional($users)->lastname)
                                                {{ $users->lastname }}
                                            @else
                                            @endif
                                        </td>
                                        <td align="center">

                                            @if ($schoolName)
                                                {{ $schoolName }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td align="center">
                                            @if (optional($courses)->course_th)
                                                {{ $courses->course_th }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td align="center">
                                            @if ($congrate == 0)
                                                N/A
                                            @elseif($congrate == 1)
                                                P
                                            @endif
                                        </td>
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
@endsection
