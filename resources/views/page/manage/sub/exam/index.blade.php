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
        <div class="table-responsive">
            <!-- .table -->
            <table id="datatable2" class="table w3-hoverable">
                <!-- thead -->
                <thead>
                    <tr class="bg-infohead">
                        <th class="align-middle" style="width:10%"> ลำดับ </th>
                        <th class="align-middle" style="width:70%"> รายการ/ชื่อข้อสอบ </th>
                        <th class="align-middle" style="width:10%"> สถานะ </th>
                        <th class="align-middle" style="width:10%"> กระทำ </th>
                    </tr>
                </thead><!-- /thead -->
                <!-- tbody -->
                <tbody>
                    <tr>
                        <td><a href="#">1</a></td>
                        <td><a>คลังข้อสอบ</a></td>
                        <td></td>
                        <td>
                            <a href="{{ route('pagequess', [$depart,$subs->subject_id]) }}"><i
                                    class="fas fa-edit fa-lg text-success" data-toggle="tooltip"
                                    title="เพิ่มข้อสอบ"></i></a>
                            <a href="{{ route('questionadd', [$depart,$subs->subject_id]) }}"><i
                                    class="fas fa-file-alt fa-lg  text-danger" data-toggle="tooltip"
                                    title="เพิ่มไฟล์ข้อสอบ"></i></a>
                        </td>
                    </tr>
                    <!-- tr -->
                    @foreach ($exams->sortBy('exam_id')  as $index => $examtem)
                        @php
                            $examsNum = $index + 2;
                        @endphp
                        <tr>
                            <td><a href="#">{{ $examsNum }}</a></td>
                            <td><a>{{ $examtem->exam_th }}</a></td>

                            <td class="align-middle"> <label
                                    class="switcher-control switcher-control-success switcher-control-lg">
                                    <input type="checkbox" class="switcher-input switcher-edit"
                                        {{ $examtem->exam_status == 1 ? 'checked' : '' }}
                                        data-exam-id="{{ $examtem->exam_id }}">
                                    <span class="switcher-indicator"></span>
                                    <span class="switcher-label-on" data-on="ON">เปิด</span>
                                    <span class="switcher-label-off text-red" data-off="OFF">ปิด</span>
                                </label>
                            </td>
                            <script>
                                $(document).ready(function() {
                                    $(document).on('change', '.switcher-input.switcher-edit', function() {
                                        var exam_status = $(this).prop('checked') ? 1 : 0;
                                        var exam_id = $(this).data('exam-id');
                                        console.log('exam_status:', exam_status);
                                        console.log('exam_id:', exam_id);
                                        $.ajax({
                                            type: "GET",
                                            dataType: "json",
                                            url: '{{ route('changeStatusExam') }}',
                                            data: {
                                                'exam_status': exam_status,
                                                'exam_id': exam_id
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
                            <td>

                                @if (in_array($examtem->exam_type, [1, 2]))
                                    <a href="{{ route('edit_examform', [$depart,'exam_id' => $examtem]) }}"><i
                                            class="fas fa-cog fa-lg text-success" data-toggle="tooltip"
                                            title="กำหนดค่า"></i></a>

                                    <a href="{{ route('examlogpage', [$depart,'exam_id' => $examtem]) }}"><i
                                            class="fas fa-chart-bar fa-lg text-danger" data-toggle="tooltip"
                                            title="รายงาน"></i></a>
                                @else
                                    <a href="" class="d-none"><i class="fas fa-file-download fa-lg  text-info"
                                            data-toggle="tooltip" title="โหลดไฟล์ข้อสอบ"></i></a>

                                    <a href="" class="d-none"><i class="fas fa-file-upload fa-lg  text-primary"
                                            data-toggle="tooltip" title="เพิ่มไฟล์คะแนนสอบ"></i></a>

                                    <a class="d-none" href=""><i class="fas fa-file-excel fa-lg  text-primary"
                                            data-toggle="tooltip" title="Download ข้อสอบอัตนัย"></i></a>
                                    <a href="{{ route('edit_examform', [$depart,'exam_id' => $examtem]) }}"><i
                                            class="fas fa-cog fa-lg text-success" data-toggle="tooltip"
                                            title="กำหนดค่า"></i></a>

                                    <a href="{{ route('examlogpage', [$depart,'exam_id' => $examtem]) }}"><i
                                            class="fas fa-chart-bar fa-lg text-danger" data-toggle="tooltip"
                                            title="รายงาน"></i></a>
                                    <a href="{{ route('destroy_examform', ['exam_id' => $examtem]) }}"
                                        class="switcher-delete" onclick="deleteRecord(event)" data-toggle="tooltip"
                                        title="ลบ">
                                        <i class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                @endif


                            </td>
                        </tr><!-- /tr -->
                    @endforeach
                </tbody><!-- /tbody -->
            </table><!-- /.table -->
        </div><!-- /.table-responsive -->
    </div><!-- /.card-body -->

    <header class="page-title-bar">
        <!-- floating action -->
        <input type="hidden" name="__id" />
        <button type="button" onclick="window.location='{{ route('add_examform', [$depart,'subject_id' => $subs]) }}'"
            class="btn btn-success btn-floated btn-add" id="add_examform" data-toggle="tooltip" title="เพิ่ม"><span
                class="fas fa-plus"></span></button>
        <!-- /floating action -->
    </header>
@endsection
