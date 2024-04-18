@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <div class="page-inner">
        <div class="page-section">
            <div class="card card-fluid">
                <div class="card-header bg-muted"></div>
                <div class="col-lg">
                    <h6 class="card-header"> ข้อมูลการเรียน </h6>
                    <div class="card-body">
                        @php
                            // จัดเรียงข้อมูลตาม course_id และ subject
                            $sortedData = [];
                            foreach ($data_lesson as $les) {
                                $courseId = $les['course_id'];
                                if (!isset($sortedData[$courseId])) {
                                    $sortedData[$courseId] = [
                                        'course_th' => $les['course_th'],
                                        'banner' => $les['banner'],
                                        'subjects' => [],
                                        'process' => [],
                                    ];
                                }
                                $sortedData[$courseId]['subjects'][] = $les['subject'];
                                // เพิ่ม process เข้าไปใน array เดียวกับ subject
                                $sortedData[$courseId]['process'][] = $les['process'];
                            }
                        @endphp


                        @foreach ($sortedData as $course)
                            <fieldset style="margin-bottom: 10px;">
                                <legend style="font-size: larger;">{{ $course['course_th'] }}</legend>
                                <div class="form-row">
                                    <label for="course" class="col-md-3">
                                        <p class="col-md-3"></p>
                                        <img src="{{ 'https://aced-bn.nacc.go.th/'. $course['banner'] }}" class="card-img" style="max-width: 80%;"
                                            alt="...">
                                    </label>
                                    <div class="col-md-9">
                                        <div class="form-row">
                                            <label for="subject" class="col-md-9">ชื่อวิชา </label>
                                            <p for="process" class="col-md-3 text-center">สถานะรายวิชา </p>
                                        </div>
                                        @foreach ($course['subjects'] as $key => $subject)
                                            <div class="form-row">
                                                <p class="col-md-9">{{ '* ' . $subject }}</p>
                                                <p class="col-md-3 text-center">
                                                    @if ($course['process'][$key] == 100)
                                                        {{ 'จบแล้ว' }}
                                                    @else
                                                        {{ $course['process'][$key] . ' %' }}
                                                    @endif
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </fieldset>
                        @endforeach



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
