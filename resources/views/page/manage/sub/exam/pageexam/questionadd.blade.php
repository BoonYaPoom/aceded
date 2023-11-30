@extends('page.manage.sub.navsubject')
@section('subject-data')
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


  
                <div class="card-body">
                    <!-- .table-responsive -->

                    <div class="form-row mb-3">
                        <div class="col-md-9">

                        </div>

                        <div class="col-md-3">
                            <select id="drop2" name="drop2" class="form-control" data-toggle="select2"
                                data-placeholder="เลือกทั้งหมด" data-allow-clear="false" style="width:30%">
                                <option value="0" >เลือกทั้งหมด </option>

                                <option value="แบบทดสอบ ">
                                    แบบทดสอบ
                                </option>
                                <option value="ข้อสอบ ">
                                    ข้อสอบ
                                </option>

                            </select>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- .table -->
                        <table id="datatable" class="table w3-hoverable">
                            <div id="datatable_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="top">
                                    <div class="dt-buttons btn-group"><button
                                            class="btn btn-secondary buttons-excel buttons-html5" tabindex="0"
                                            aria-controls="datatable" type="button"
                                            onclick="window.location='{{ route('questionExport', ['subject_id' => $subs]) }}'"><span>Excel</span></button>
                                    </div>

                                    <div id="datatable_filter" class="dataTables_filter">
                                        <label>ค้นหา<input type="search" id="myInput" class="form-control" placeholder=""
                                                aria-controls="datatable"></label>
                                    </div>

                                </div>
                            </div>
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:5%"> ลำดับ </th>
                                    <th class="align-middle" style="width:60%"> คำถาม </th>
                                    <th class="align-middle" style="width:10%"> ประเภท </th>
                                    <th class="align-middle" style="width:10%"> ชนิด </th>
                                    <th class="align-middle" style="width:10%"> สถานะ </th>
                                    <th class="align-middle" style="width:5%"> กระทำ</th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr -->
                                @php
                                    $rowNumber = 0;
                                @endphp
                                @foreach ($ques->sortBy('question_id') as $item)
                                    @php
                                        $rowNumber++;
                                    @endphp
                                    @php
                                        $lessonItem = \App\Models\CourseLesson::find($item->content_type);
                                    @endphp
                                    @php
                                        $questionType = \App\Models\QuestionType::find($item->question_type);
                                    @endphp

                                    @if ($questionType)
                                        <tr>
                                            <td><a href="#">{{ $rowNumber }}</a></td>
                                            <td>{!! $item->question !!}</td>
                                            <td>{{ $questionType->question_type_th }}</td>
                                            @if ($item->lesson_id == 0)
                                                <td>ข้อสอบ</td>
                                            @elseif($item->lesson_id > 0)
                                                <td>แบบทดสอบ</td>
                                            @endif
                                            <td class="align-middle"> <label
                                                    class="switcher-control switcher-control-success switcher-control-lg">
                                                    <input type="checkbox" class="switcher-input switcher-edit"
                                                        {{ $item->question_status == 1 ? 'checked' : '' }}
                                                        data-question-id="{{ $item->question_id }}">
                                                    <span class="switcher-indicator"></span>
                                                    <span class="switcher-label-on">ON</span>
                                                    <span class="switcher-label-off text-red">OFF</span>
                                                </label></td>

                                            <script>
                                                $(document).ready(function() {
                                                    $(document).on('change', '.switcher-input.switcher-edit', function() {
                                                        var question_status = $(this).prop('checked') ? 1 : 0;
                                                        var question_id = $(this).data('question-id');
                                                        console.log('question_status:', question_status);
                                                        console.log('question_id:', question_id);
                                                        $.ajax({
                                                            type: "GET",
                                                            dataType: "json",
                                                            url: '{{ route('queschangeStatus') }}',
                                                            data: {
                                                                'question_status': question_status,
                                                                'question_id': question_id
                                                            },
                                                            success: function(data) {
                                                                console.log(data.message); // แสดงข้อความที่ส่งกลับ

                                                            },
                                                            error: function(xhr, status, error) {
                                                                console.log('ข้อผิดพลาด');
                                                            }
                                                        });
                                                    });
                                                });
                                            </script>
                                            <td class="align-middle">
                                                <a href="{{ route('edit_question', [$depart,'question_id' => $item]) }}"><i
                                                        class="far fa-edit fa-lg text-success" data-toggle="tooltip"
                                                        title="แก้ไข"></i></a>
                                                <a href="{{ route('delete_question', [$depart,'question_id' => $item]) }}"
                                                    rel="รัฐที่มีอาณาบริเวณพื้นที่มากหรือใหญ่ที่สุดในโลกขณะนี้ ได้แก่"
                                                    onclick="deleteRecord(event)" class="switcher-delete"
                                                    data-toggle="tooltip" title="ลบ"><i
                                                        class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                            </td>
                                        </tr><!-- /tr -->
                                    @endif
                                @endforeach
                            </tbody><!-- /tbody -->
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
                                    $('#drop2').on('change', function() {
                                        var selecteddrop2Id = $(this).val();
                                        if (selecteddrop2Id == 0) {
                                            table.columns(3).search('').draw();
                                        } else {
                                            // กรองข้อมูลใน DataTables ด้วยหน่วยงานที่เลือก
                                            table.columns(3).search(selecteddrop2Id).draw();
                                        }
                                    });

                                });
                            </script>
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                    <header class="page-title-bar">
                        <!-- floating action -->
                        <input type="hidden" name="__id" />
                        <button type="button" class="btn btn-success btn-floated btn-add"
                            onclick="window.location='{{ route('questionform', [$depart,'subject_id' => $subs]) }}'" data-toggle="tooltip"
                            title="เพิ่ม"><span class="fas fa-plus"></span></button>
            
                        <!-- /floating action -->
                    </header><!-- /.page-title-bar -->
                </div><!-- /.card-body -->
         


 

@endsection
