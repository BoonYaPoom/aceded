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
                        style="text-decoration: underline;">จัดการวิชา</a> / <i>{{ $cour->course_th }} คะแนน</i></div>
                <!-- /.card-header -->
                <!-- .nav-scroller -->
                <div class="nav-scroller border-bottom">
                    <!-- .nav -->
                    <div class="nav nav-tabs bg-muted h3">
                        <a class="nav-link active text-info"
                            href="{{ route('class_page', ['course_id' => $cour->course_id]) }}"><i class="fas fa-users"></i>
                            ผู้เรียน รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย </a>
                    </div><!-- /.nav -->
                </div>
                <div class="card-body">
                  <!--  <div class="dt-buttons btn-group"><button id="exportButton"
                            class="btn btn-secondary buttons-excel buttons-html5" tabindex="0" aria-controls="datatable"
                            type="button"><span>Excel</span></button> </div>-->



                    <div class="table-responsive">
                        <!-- .table -->
                        <table id="datatable" class="table w3-hoverable" border=0>
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:10%" data-column="ลำดับ"> ลำดับ </th>
                                    <th class="align-middle" style="width:30%" data-column="ชื่อ-สกุล"> ชื่อ-สกุล </th>


                                    <th class="align-middle" style="width:10%" data-column="คะแนนรวม"> คะแนนรวม </th>
                                    <th class="align-middle" style="width:10%" data-column="ผลการสอบ"> GPA </th>

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
                                    $ScoreLog = null;
                                    $latestScore = null;
                                    $latfullScore = null;

                                    $percentage = 0;

                                    $percentagelog = 0;
                                @endphp
                                @foreach ($learners as $l => $learns)
                                    @php
                                        $dataLearn = $learns->registerdate;
                                        $monthsa = \ltrim(\Carbon\Carbon::parse($dataLearn)->format('m'), '0');
                                        $newDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $learns->registerdate)->format('d/m/Y H:i:s');
                                        $users = \App\Models\Users::find($learns->user_id);

                                        $scorefull = 0;
                                        $scorehef = 0;
                                    @endphp

                                    @if ($users !== null)
                                        @if ($monthsa == $m)
                                            @if (!in_array($learns->user_id, $uniqueUserIds))
                                                @php
                                                    array_push($uniqueUserIds, $learns->user_id); // เพิ่ม user_id เข้าไปในอาเรย์
                                                    $ScoreLog = \App\Models\Score::where('user_id', $learns->user_id)
                                                        ->whereHas('examlog', function ($query) {
                                                            $query->where('exam_type', 2);
                                                        })
                                                        ->orderBy('score', 'desc')
                                                        ->get();
                                                    if ($ScoreLog->isNotEmpty()) {
                                                        $firstScoreLog = $ScoreLog->first();
                                                        $latfullScore = $firstScoreLog->fullscore ?? 0;
                                                        $latestScore = $firstScoreLog->score ?? 0;
                                                        $percentage = ($latestScore / $latfullScore) * 100;
                                                    } else {
                                                        $percentage = 0;
                                                    }

                                                @endphp


                                                <tr>
                                                    <td>{{ $n++ }}</td>

                                                    <td>{{ $users->firstname }} {{ $users->lastname }}</td>
                                                    <td>
                                                        @if ($ScoreLog->isNotEmpty())
                                                            {{ number_format($percentage) }}
                                                        @else
                                                            รอลงคะแนน
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($percentage >= 80)
                                                            A
                                                        @elseif ($percentage >= 70 && $percentage < 79)
                                                            B
                                                        @elseif ($percentage >= 60 && $percentage < 69)
                                                            C
                                                        @elseif ($percentage >= 50 && $percentage < 59)
                                                            D
                                                        @elseif ($percentage > 1 && $percentage < 49)
                                                            F
                                                        @elseif ($percentage == 0)
                                                            -
                                                        @endif

                                                    </td>
                                                </tr><!-- /tr -->
                                            @elseif ($users == null)
                                            @endif
                                            <tr>

                                            </tr><!-- /tr -->
                                        @endif
                                    @endif
                                @endforeach
                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->

    </div><!-- /.page-inner -->
@endsection
