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
            toastr.error("{{ Session::get('error') }}");
        </script>
    @endif
    <div class="page-inner">
        <div class="page-section">
            <div class="card card-fluid">
                <div class="card-header bg-muted"></div>
                <div class="col-lg">
                    <h6 class="card-header"> ข้อมูลการเรียน ของ {{ ' ' . $db_user->firstname . ' ' . $db_user->lastname }}
                    </h6>
                    <div class="card-body">
                        @if (count($data_lesson) > 0)
                            @php
                                // จัดเรียงข้อมูลตาม course_id และ subject
                                $sortedData = [];
                                foreach ($data_lesson as $les) {
                                    $courseId = $les['course_id'];
                                    if (!isset($sortedData[$courseId])) {
                                        $sortedData[$courseId] = [
                                            'course_id' => $les['course_id'],
                                            'course_th' => $les['course_th'],
                                            'banner' => $les['banner'],
                                            'certificate_full_no' => $les['certificate_full_no'],
                                            'certificate_file_role_status' => $les['certificate_file_role_status'],
                                            'certificate_file_path' => $les['certificate_file_path'],
                                            'certificate_file_id' => $les['certificate_file_id'],
                                            'congratulation' => $les['congratulation'],
                                            'realcongratulationdate' => $les['realcongratulationdate'],
                                            'subjects' => [],
                                            'process' => [],
                                            'score' => [],
                                            'fullscore' => [],
                                        ];
                                    }
                                    $sortedData[$courseId]['subjects'][] = $les['subject'];
                                    // เพิ่ม process เข้าไปใน array เดียวกับ subject
                                    $sortedData[$courseId]['process'][] = $les['process'];
                                    $sortedData[$courseId]['score'][] = $les['score'];
                                    $sortedData[$courseId]['fullscore'][] = $les['fullscore'];
                                }
                            @endphp
                            @foreach ($sortedData as $course)
                                <fieldset style="margin-bottom: 10px;">
                                    <legend style="font-size: larger;">{{ $course['course_th'] }}</legend>
                                    <div class="form-row">
                                        <label for="course" class="col-md-3">

                                            <div class="d-flex justify-content-center">
                                                <img src="{{ 'https://aced-bn.nacc.go.th/' . $course['banner'] }}"
                                                    class="card-img" style="max-width: 80%;" alt="...">
                                            </div>
                                            <br>
                                            @if ($course['congratulation'] == 0)
                                                <p class="text-center">ยังไม่จบ</p>
                                            @else
                                                @if ($course['certificate_file_role_status'] == 0)
                                                    <p class="text-center">รอสร้างใบประกาศ</p>
                                                @else
                                                    <p class="text-center">ดาวโหลดใบประกาศ หรือ รีเซ็ตใหม่</p>
                                                @endif
                                            @endif
                                            <div class="d-flex justify-content-center">
                                                @if ($course['congratulation'] == 0)
                                                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top"
                                                        aria-label="ยังไม่สำเร็จ" data-bs-original-title="ยังไม่สำเร็จ"
                                                        title="ยังไม่สำเร็จ">
                                                        <img src="https://aced.nacc.go.th/images/icon_page_learn-07.png">
                                                    </a>
                                                @else
                                                    @if ($course['certificate_file_role_status'] == 0)
                                                        <a href="javascript:void(0);" data-toggle="tooltip"
                                                            data-placement="top" aria-label="รอใบประกาศ"
                                                            data-bs-original-title="รอใบประกาศ" title="รอใบประกาศ">
                                                            <img
                                                                src="https://aced.nacc.go.th/images/icon_page_learn-07.png">
                                                        </a>
                                                    @else
                                                        <a href="{{ 'https://aced.nacc.go.th/' . $course['certificate_file_path'] }}"
                                                            target="_blank" data-toggle="tooltip" data-placement="top"
                                                            aria-label="สำเร็จ" data-bs-original-title="สำเร็จ"
                                                            title="สำเร็จ">
                                                            <img
                                                                src="https://aced.nacc.go.th/images/icon_page_learn-06.png">
                                                        </a>
                                                        &nbsp;
                                                        <a href="{{ route('classroom_user_status', [$user_id, $course['course_id'], $course['certificate_file_id']]) }}"
                                                            onclick="resetcer(event)" target="_blank" data-toggle="tooltip"
                                                            data-placement="top" style="margin-top: 5px;"
                                                            aria-label="รีเซ็ตใบประกาศ"
                                                            data-bs-original-title="รีเซ็ตใบประกาศ" title="รีเซ็ตใบประกาศ">
                                                            <i class="fas fa-sync-alt"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                        </label>
                                        <div class="col-md-9">
                                            <div class="form-row">
                                                <label for="subject" class="col-md-8">ชื่อวิชา </label>
                                                <p for="process" class="col-md-2 text-center">สถานะรายวิชา </p>
                                                <p for="process" class="col-md-2 text-center">คะแนนสอบ </p>
                                            </div>
                                            @foreach ($course['subjects'] as $key => $subject)
                                                <div class="form-row">
                                                    <p class="col-md-8">{{ '* ' . $subject }}</p>
                                                    <p class="col-md-2 text-center">

                                                        @if ($course['congratulation'] == 1)
                                                            จบแล้ว
                                                        @else
                                                            @if ($course['process'][$key] == 100)
                                                                {{ 'จบแล้ว' }}
                                                            @else
                                                                {{ $course['process'][$key] . ' %' }}
                                                            @endif
                                                        @endif
                                                    </p>
                                                    <p class="col-md-2 text-center">

                                                        @if ($course['score'][$key] != null)
                                                            {{ $course['score'][$key] . '/' . $course['fullscore'][$key] . ' คะแนน' }}
                                                        @else
                                                            -
                                                        @endif
                                                    </p>
                                                </div>
                                            @endforeach
                                        </div>
                                   
                                    </div>
                                </fieldset>
                            @endforeach
                        @else
                            <fieldset style="margin-bottom: 10px;">
                                <legend style="font-size: larger;">ไม่มีข้อมูล</legend>
                                <h1 style="font-size: larger; opacity: 0.5;" class="text-center">ไม่มีข้อมูล</h1>
                            </fieldset>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function resetcer(ev) {
            ev.preventDefault();
            var urlToredirect = ev.currentTarget.getAttribute('href');
            swal({
                    title: "คุณแน่ใจหรือไม่ที่จะรีเซ็ตข้อมูลใบประกาศ?",
                    text: "คุณจะไม่สามารถย้อนกลับได้!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((confirm) => {
                    if (confirm) {
                        window.location.href = urlToredirect;
                    } else {
                        swal("คุญได้ยกเลิกการรีเซ็ตใบประกาศ !");
                    }
                });
        }
    </script>
@endsection
