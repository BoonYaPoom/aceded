    @extends('layouts.adminhome')
    @section('content')
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



        <div class="page-inner">

            <!-- .page-section -->
            <div class="page-section">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-header -->
                    <div class="card-header bg-muted"><a href="{{ route('lessonpage', [$exams->subject_id]) }}"
                            style="text-decoration: underline;">หมวดหมู่</a> / <a
                            href="{{ route('exampage', [$exams->subject_id]) }}"
                            style="text-decoration: underline;">จัดการวิชา</a> / <i>{{ $exams->exam_th }}</i></div>
                    <!-- .card-body -->
                    <div class="card-body">

                        <!-- .table-responsive -->
                        <div class="table-responsive">
                            <!-- .table -->
                            <table id="datatable" class="table w3-hoverable">
                                <!-- thead -->
                                <thead>
                                    <tr class="bg-infohead">
                                        <th class="align-middle" style="width:5%"> ลำดับ </th>
                                        <th class="align-middle" style="width:15%"> รหัส </th>
                                        <th class="align-middle" style="width:35%"> ชื่อ-สกุล </th>
                                        <th class="align-middle" style="width:10%"> คะแนนเต็ม </th>
                                        <th class="align-middle" style="width:10%"> คะแนน </th>
                                        <th class="align-middle" style="width:10%"> เปอร์เซ็น </th>
                                        <th class="align-middle" style="width:15%"> วันที่</th>
                                    </tr>
                                </thead><!-- /thead -->
                                <!-- tbody -->
                                <tbody>
                                    <!-- tr -->
                                    @php
                                        $sc = 0;
                                    @endphp
                                    @foreach ($score as $scores)
                                        @php
                                            $user = \App\Models\Users::find($scores->user_id);
                                                
                                            if ($user !== null) {
                                                $fullscore = $scores->fullscore;
                                                $scoreexam = $scores->score;
                                                $ansscore = 0; // Initialize $ansscore to 0
                                            
                                                if ($fullscore != 0) {
                                                    $ansscore = ($scoreexam / $fullscore) * 100;
                                                }
                                            $sc++;

                                        
                                        @endphp

                                        <tr>
                                            <td><a href="#">{{ $sc }}</a></td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                                            <td>{{ $fullscore }}</td>
                                            <td>{{ $scoreexam }}</td>
                                            <td>{{ number_format($ansscore, 2) }} %</td>
                                            <td>{{ $scores->date }}</td>
                                        </tr><!-- /tr -->
                                        @php
                                            }
                                        @endphp
                                    @endforeach
                                </tbody><!-- /tbody -->
                            </table><!-- /.table -->
                        </div><!-- /.table-responsive -->
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /.page-section -->
            <script>
                $(document).ready(function() {
                    var table = $('#datatable').DataTable({

                        lengthChange: false,
                        responsive: true,
                        info: false,
                        language: {

                            infoEmpty: "ไม่พบรายการ",
                            infoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
                            paginate: {
                                first: "หน้าแรก",
                                last: "หน้าสุดท้าย",
                                previous: "ก่อนหน้า",
                                next: "ถัดไป" // ปิดการแสดงหน้าของ DataTables
                            }
                        }

                    });

                    $('#myInput').on('keyup', function() {
                        table.search(this.value).draw();
                    });
                });
            </script>
            <!-- .page-title-bar -->
            <header class="page-title-bar">
                <!-- floating action -->

                <input type="hidden" />
                <button type="button" class="d-none btn btn-success btn-floated" data-toggle="tooltip"
                    title="บันทึกคะแนน"><span class="fas fa-save"></span></button>
                <!-- /floating action -->
            </header><!-- /.page-title-bar -->
        </div><!-- /.page-inner -->
    @endsection
