@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    @if (Session::has('message'))
        <script>
            toastr.options = {
                "progressBar": true,
                "positionClass": 'toast-top-full-width',
                "extendedTimeOut ": 0,
                "timeOut": 3000,
                "fadeOut": 250,
                "fadeIn": 250,
                "positionClass": 'toast-top-right',


            }
            toastr.success("{{ Session::get('message') }}");
        </script>
    @endif
    <!-- Include axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Include XLSX -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.3/xlsx.full.min.js"></script>


    <!-- .page-inner -->
    <div class="page-inner">

        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('learn', ['department_id' => $depart->department_id]) }}"
                        style="text-decoration: underline;">หมวดหมู่</a> / <a
                        href="{{ route('learn', ['department_id' => $courses->first()->department_id]) }}"
                        style="text-decoration: underline;">จัดการวิชา</a> / <i>{{$cour->course_th}}</i></div><!-- /.card-header -->
                <!-- .nav-scroller -->
                <div class="nav-scroller border-bottom">
                    <!-- .nav -->
                    <div class="nav nav-tabs bg-muted h3">
                        <a class="nav-link active text-info"
                            href="{{ route('class_page', ['course_id' => $cour->course_id]) }}"><i class="fas fa-users"></i>
                            ผู้เรียน รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย </a>
                    </div><!-- /.nav -->
                </div><!-- /.nav-scroller -->
                <!-- .card-body -->
                <div class="card-body">
                  <!--  <div class="dt-buttons btn-group"><button id="exportButton"
                            class="btn btn-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="datatable"
                            type="button"><span>Excel</span></button> </div>-->
                    <!-- .table-responsive -->
                    
                    <div class="table-responsive">
                        <!-- .table -->
                        <table id="datatable" class="table w3-hoverable" border=0>
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:10%" data-column="ลำดับ"> ลำดับ </th>
                                    <th class="align-middle" style="width:15%" data-column="รหัส"> รหัส </th>
                                    <th class="align-middle" style="width:30%" data-column="ชื่อ-สกุล"> ชื่อ-สกุล </th>
                                    <th class="align-middle" style="width:10%" data-column="จำนวนเข้าเรียน">จำนวนเข้าเรียน </th>
                                    <th class="align-middle" style="width:10%" data-column="เวลาวิดิโอ">เวลาวิดิโอ </th>
                                    <th class="align-middle" style="width:10%" data-column="คะแนนสอบ"> คะแนนสอบ </th>
                                    <th class="align-middle" style="width:10%" data-column="ผลการสอบ"> ผลการสอบ </th>
                           
                                    <th class="align-middle" style="width:5%"> ประวัติ </th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->

                            <tbody>
                                <!-- tr -->
                                @php
                                    $n = 1;
                                    $result = []; // สร้างตัวแปรเก็บผลลัพธ์
                                    $uniqueUserIds = [];
                                    $countUsersLogs = null;
                                    $totalDuration = null;
                                    $ScoreUser = null;
                                    
                                @endphp
                                @foreach ($learners as $l => $learns)
                                    @php
                                        $dataLearn = $learns->registerdate;
                                        $monthsa = \ltrim(\Carbon\Carbon::parse($dataLearn)->format('m'), '0');
                                        $newDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $learns->registerdate)->format('d/m/Y H:i:s');
                                        $users = \App\Models\Users::find($learns->user_id);
                                        
                                        if ($users !== null) {
                                            $ScoreLog = \App\Models\Score::where('user_id', $learns->user_id)
                                                ->whereHas('examlog', function ($query) {
                                                    $query->where('exam_type', 2);
                                                })
                                                ->get();
                                        } else {
                                            $ScoreLog = null;
                                        }
                                        
                                    @endphp
                                    @if ($users !== null)
                                        @if ($monthsa == $m)
                                            @if (!in_array($learns->user_id, $uniqueUserIds))
                                                @php
                                                    array_push($uniqueUserIds, $learns->user_id);
                                                    
                                                    $countUsersLogs = \App\Models\Log::where('user_id', $users->user_id)
                                                        ->where('logid', 4)
                                                        ->count();
                                                    $totalDuration = \App\Models\Log::where('user_id', $users->user_id)
                                                        ->where('logid', 4)
                                                        ->sum('duration');
                                                    $ScoreUser = \App\Models\Score::where('user_id', $users->user_id)
                                                        ->whereHas('examlog', function ($query) {
                                                            $query->where('exam_type', 2);
                                                        })
                                                        ->latest('score_date')
                                                        ->get();
                                                    
                                                    $totalDurationInMinutes = $totalDuration / 60;
                                                    
                                                    $totalHours = floor($totalDurationInMinutes / 60); // จำนวนชั่วโมง
                                                    $totalMinutes = $totalDurationInMinutes % 60; // จำนวนนาทีที่เหลือ
                                                    
                                                    if ($totalMinutes > 60) {
                                                        $totalHours += floor($totalMinutes / 60);
                                                        $totalMinutes %= 60;
                                                    }
                                                    $latestScore = null;
                                                    $latfullScore = null;
                                                    $latestScorelog = null;
                                                    $latfullScorelog = null;
                                                    $percentage = 0;
                                                    
                                                    $percentagelog = 0;
                                                    
                                                @endphp

                                                @foreach ($ScoreUser as $score)
                                                    @php
                                                        
                                                        if ($score->score && $score->fullscore) {
                                                            if (($latestScore === null && $latfullScore === null) || $score->score_date > $latestScoreDate) {
                                                                $latestScore = $score->score;
                                                                $latfullScore = $score->fullscore;
                                                                $latestScoreDate = $score->score_date;
                                                        
                                                                if ($latfullScore) {
                                                                    $percentage = ($latestScore / $latfullScore) * 100;
                                                                }
                                                            }
                                                        }
                                                        $ScoreDatelog = [];
                                                    @endphp
                                                @endforeach

                                                <tr>
                                                    <td>{{ $n++ }}</td>

                                                    <td>{{ $users->username }}</td>
                                                    <td>{{ $users->firstname }} {{ $users->lastname }}</td>

                                                    <td>
                                                        {{ $countUsersLogs }}
                                                    </td>
                                                    <td>
                                                        {{ $totalHours }} ชั่วโมง
                                                        {{ number_format($totalMinutes) }} นาที
                                                    </td>
                                                    <td>
                                                        @if ($latestScore)
                                                            {{ $latestScore }}
                                                        @else
                                                            ยังไม่ให้คะแนน
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if ($percentage > 50)
                                                            ผ่าน
                                                        @else
                                                            ไม่ผ่าน
                                                        @endif

                                                    </td>
                                                  
                                                    <td>
                                                        <a data-toggle="modal"
                                                            data-target="#clientPermissionModal-{{ $users->user_id }}"><i
                                                                class="fas fa-chart-bar fa-lg text-danger"
                                                                data-toggle="tooltip" title="ประวัติ"></i></a>
                                                        <script>
                                                            $(document).ready(function() {
                                                                $('.modal').on('shown.bs.modal', function() {
                                                                    var user_id = $(this).data('user_id');
                                                                    console.log('ID ที่เข้าถึงโมเดล:', user_id);
                                                                });
                                                            });
                                                        </script>
                                                        <div id="clientPermissionModal-{{ $users->user_id }}"
                                                            data-user_id="{{ $users->user_id }}" class="modal fade"
                                                            aria-modal="true" tabindex="-1" user_role="dialog">
                                                            <div class="modal-dialog modal-xl" user_role="document">

                                                                <div class="modal-content">

                                                                    <!-- .modal-header -->
                                                                    <div class="modal-header bg-theme-primary ">
                                                                        <h6 id="clientPermissionModalLabel"
                                                                            class="modal-title text-white">
                                                                            <span class="sr-only">Permission</span> <span><i
                                                                                    class="fas fas fa-book text-white"></i>
                                                                                ประวัติการสอบ แบบทดสอบหลังเรียน</span>
                                                                        </h6>
                                                                        <h6 id="clientPermissionModalLabel"
                                                                            class="modal-title text-white">
                                                                            <span class="sr-only">Permission</span> <span><i
                                                                                    class="fas fa-user text-white"></i>
                                                                                {{ $users->firstname }}
                                                                                {{ $users->lastname }}</span>
                                                                        </h6>
                                                                    </div><!-- /.modal-header -->

                                                                    <div class="modal-body">
                                                                        <!-- .form-group -->
                                                                        <div class="form-group">

                                                                            <div class="table-responsive">
                                                                                <table id="datatable2"
                                                                                    class="table w3-hoverable" border=0>
                                                                                    <!-- thead -->
                                                                                    <thead>
                                                                                        <tr class="bg-infohead">

                                                                                            <th class="align-middle"
                                                                                                style="width:20%"> วันที่
                                                                                            </th>
                                                                                            <th class="align-middle"
                                                                                                style="width:30%"> คะแนนสอบ
                                                                                            </th>
                                                                                            <th class="align-middle"
                                                                                                style="width:30%">
                                                                                                คะแนนเต็ม
                                                                                            </th>
                                                                                            <th class="align-middle"
                                                                                                style="width:20%"> ผลการสอบ
                                                                                            </th>

                                                                                        </tr>
                                                                                    </thead><!-- /thead -->

                                                                                    <tbody>

                                                                                        @foreach ($ScoreLog as $scoreog)
                                                                                            @php
                                                                                                if ($scoreog->score && $scoreog->fullscore) {
                                                                                                    $latestScorelog = $scoreog->score;
                                                                                                    $latfullScorelog = $scoreog->fullscore;
                                                                                                    $latestScoreDatelog = $scoreog->score_date;
                                                                                                
                                                                                                    $ScoreDatelog = \ltrim(\Carbon\Carbon::parse($latestScoreDatelog)->format('m'), '0');
                                                                                                
                                                                                                    $carbonDate = \Carbon\Carbon::parse($latestScoreDatelog);
                                                                                                    $thaiDate = $carbonDate->locale('th')->isoFormat('D MMMM');
                                                                                                    $buddhistYear = $carbonDate->addYears(543)->year;
                                                                                                    $thaiYear = $buddhistYear > 0 ? $buddhistYear : '';
                                                                                                    $thaiDateWithYear = $thaiDate . ' ' . $thaiYear;
                                                                                                    if ($latfullScorelog) {
                                                                                                        $percentagelog = ($latestScorelog / $latfullScorelog) * 100;
                                                                                                    }
                                                                                                }
                                                                                                
                                                                                            @endphp
                                                                                            @if ($ScoreDatelog == $m)
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        {{ $thaiDateWithYear }}
                                                                                                    </td>
                                                                                                    <td>

                                                                                                        @if ($latestScorelog)
                                                                                                            {{ $latestScorelog }}
                                                                                                        @else
                                                                                                            ยังไม่ทำการตรวจ
                                                                                                        @endif
                                                                                                    </td>
                                                                                                    <td>

                                                                                                        @if ($latfullScorelog)
                                                                                                            {{ $latfullScorelog }}
                                                                                                        @else
                                                                                                            0
                                                                                                        @endif
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        @if ($percentagelog > 50)
                                                                                                            ผ่าน
                                                                                                        @else
                                                                                                            ไม่ผ่าน
                                                                                                        @endif
                                                                                                    </td>
                                                                                             
                                                                                                </tr>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </tbody>
                                                                                </table>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit"
                                                                            class="btn btn-primary-theme"
                                                                            id="btnsetuser_role">
                                                                            <i class="fas fa-user-shield"></i> เช็ค
                                                                        </button>
                                                                        <button type="button" class="btn btn-light"
                                                                            data-dismiss="modal">ยกเลิก</button>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>



                                                    </td>
                                                </tr><!-- /tr -->
                                            @elseif ($users == null)
                                            @endif
                                        @endif
                                    @endif
                                @endforeach

                                <script>
                                    $(document).ready(function() {
                                        var table = $('#datatable').DataTable({

                                            lengthChange: false,
                                            responsive: true,
                                            info: true,
                                            pageLength: 50,
                                            language: {
                                                info: "ลำดับที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                                infoEmpty: "ไม่พบรายการ",
                                                infoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
                                                paginate: {
                                                    first: "หน้าแรก",
                                                    last: "หน้าสุดท้าย",
                                                    previous: "ก่อนหน้า",

                                                    next: "ถัดไป"
                                                },
                                                emptyTable: "ไม่พบรายการแสดงข้อมูล"
                                            },
                                        });
                                    });
                                </script>
                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->

        <!--
                                <header class="page-title-bar">
                                  
                                    <input type="hidden" />
                                    <button type="button" onclick="window.location=''" class="btn btn-success btn-floated btn-add "
                                        id="registeradd" data-toggle="tooltip" title="เพิ่ม"><span class="fas fa-plus"></span></button>
                                    
                                </header> -->
    </div><!-- /.page-inner -->
@endsection
