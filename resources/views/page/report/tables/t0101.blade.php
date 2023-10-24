@extends('page.report.index')
@section('reports')
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
                <!--   <div class="col-md-1"><span class="mt-1 ">ปี</span></div>
                                <div class="col-md-3">
                                    <div class=""><select id="selectyear" name="selectyear" class="form-control" data-toggle="select2"
                                            data-placeholder="ปี" data-allow-clear="false" onchange="$('#formreport').submit();">
                                            <option value="2022"> </option>
                                            <option value="2023" selected> </option>
                                        </select></div>
                                </div>-->
                <!--    <div class="col-md-4 ">
                                    <div><select id="selectcourse" name="selectcourse" class="form-control" data-toggle="select2"
                                            data-placeholder="หลักสูตร" data-allow-clear="false" onchange="$('#formreport').submit();">
                                            <option value="" selected> เลือกหลักสูตร </option>
                                            <option value="" selected> </option>
                                            <option value="รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย"> รายวิชาเพิ่มเติม
                                                การป้องกันการทุจริต ระดับปฐมวัย </option>
                                        </select></div>
                                </div>-->
                <!--  <div class="col-md-4 ">
                                    <div><select id="selectuser_id" name="selectuser_id" class="form-control" data-toggle="select2"
                                            data-placeholder="ผู้ใช้งานทั้งหมด" data-allow-clear="false"
                                            onchange="$('#formreport').submit();">
                                            <option value=""> ผู้ใช้งานทั้งหมด </option>
                                            <option value="ธนภัทร วงษ์กล่อม"> ธนภัทร วงษ์กล่อม </option>
                                            <option value="aced_admin "> aced_admin </option>
                                            <option value="ธนภัทร วงษ์กล่อม"> ธนภัทร วงษ์กล่อม </option>
                                            <option value="ธนภัทร วงษ์กล่อม"> ธนภัทร วงษ์กล่อม </option>
                                            <option value="TCCT1 user"> TCCT1 user </option>
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
                span class="mr-auto">รายงานข้อมูลรายชื่อผู้เรียนทั้งหมด และแยกตามหลักสูตร</span>   <!--   <<a
                        href="{{route('generatePdfT0101')}}"
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
                                <th class="text-center" colspan="6">รายงานข้อมูลรายชื่อผู้เรียนทั้งหมด และแยกตามหลักสูตร
                                </th>
                            </tr>
                            <tr class="text-center">
                                <th align="center" width="5%">ลำดับ</th>
                                <th align="center" width="20%">ชื่อผู้ใช้งาน</th>
                                <th align="center" width="30%">ชื่อ - สกุล</th>

                                <th align="center">หลักสูตร</th>
                                <th align="center" width="10%">วันที่ลงทะเบียนเรียน</th>
                                <th align="center" width="10%">วันที่จบหลักสูตร</th>
                            </tr>



                            <!-- tr --> @php
                                $n = 1;
                                $result = []; // สร้างตัวแปรเก็บผลลัพธ์
                                $uniqueUserIds = [];
                                $users = null;
                            @endphp
                            @foreach ($learners as $l => $learns)
                            
                                @php
                                
                                    $dataLearn = $learns->registerdate;
                                    $congrateLearn = $learns->congratulationdate;
                                    $congrate = $learns->congratulation;
                                    $monthsa = \ltrim(\Carbon\Carbon::parse($dataLearn)->format('m'), '0');
                                    $newDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $learns->registerdate)->format('d/m/Y H:i:s');
                                    $users = \App\Models\Users::find($learns->user_id);
                                    
                                    $courses = \App\Models\Course::find($learns->course_id);
                                    
                                    if ($courses) {
                                        // Access properties of the $courses object here
                                        $course_th = $courses->course_th;
                                        // ...
                                    } else {
                                    }
                                    $carbonDate = \Carbon\Carbon::parse($congrateLearn);
                                    $thaiDate = $carbonDate->locale('th')->isoFormat('D MMMM');
                                    $buddhistYear = $carbonDate->addYears(543)->year;
                                    $thaiYear = $buddhistYear > 0 ? $buddhistYear : '';
                                    $thaiDateWithYear = $thaiDate . ' ' . $thaiYear;
                                    
                                    $carbonDa = \Carbon\Carbon::parse($dataLearn);
                                    $thaiDa = $carbonDa->locale('th')->isoFormat('D MMMM');
                                    $buddhistYe = $carbonDa->addYears(543)->year;
                                    $thai = $buddhistYe > 0 ? $buddhistYe : '';
                                    $thaiDat = $thaiDa . ' ' . $thai;
                                    
                                @endphp

                                @if (isset($users) && $users)
                                    <tr>
                                        <td align="center">{{ $n++ }}</td>

                                        <td>
                                            @if (optional($users)->username)
                                                {{ $users->username }}
                                            @else
                                                
                                            @endif
                                        </td>
                                        <td>
                                            @if (optional($users)->firstname)
                                                {{ $users->firstname }}
                                            @else
                                                
                                            @endif
                                            @if (optional($users)->lastname)
                                                {{ $users->lastname }}
                                            @else
                                                
                                            @endif
                                        </td>

                                        <td>
                                            @if (optional($courses)->course_th)
                                                {{ $courses->course_th }}
                                            @else
                                            @endif
                                        </td>
                                        <td align="center">
                                            @if ($thaiDat)
                                                {{ $thaiDat }}
                                            @else
                                            @endif
                                        </td>
                                        <td align="center">
                                            @if ($congrate == 1)
                                                {{ $thaiDateWithYear }}
                                            @elseif($congrate == 0)
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
