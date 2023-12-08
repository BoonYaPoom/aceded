<div class="table-responsive">
    <!-- .table -->
    <table id="datatable3" class="table w3-hoverable">
        <!-- thead -->
        <thead>
            <tr class="bg-infohead">
                <th class="align-middle" style="width:10%"> ลำดับ </th>
                <th class="align-middle" style="width:65%"> รายการแบบทดสอบ </th>
                <th class="align-middle" style="width:10%"> สถานะ </th>
                <th class="text-center" style="width:15%"> กระทำ </th>
            </tr>
        </thead><!-- /thead -->
        <tbody>
            @php
                $examsNum2 = 1;
            @endphp
            @foreach ($exams->sortBy('exam_id') as $index => $examtem)
                @if ($examtem->exam_type == 5)
                    <tr>
                        <td><a href="#">{{ $examsNum2++ }}</a></td>
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
                        <td class="text-center">
                            <a href="" class="d-none"><i class="fas fa-file-download fa-lg  text-info"
                                    data-toggle="tooltip" title="โหลดไฟล์ข้อสอบ"></i></a>

                            <a href="" class="d-none"><i class="fas fa-file-upload fa-lg  text-primary"
                                    data-toggle="tooltip" title="เพิ่มไฟล์คะแนนสอบ"></i></a>

                            <a class="d-none" href=""><i class="fas fa-file-excel fa-lg  text-primary"
                                    data-toggle="tooltip" title="Download ข้อสอบอัตนัย"></i></a>
                            <a href="{{ route('edit_examform3', [$depart, $subs, 'exam_id' => $examtem]) }}"><i
                                    class="fas fa-cog fa-lg text-success" data-toggle="tooltip"
                                    title="กำหนดค่า"></i></a>

                            <a href="{{ route('examlogpage', [$depart, $subs, 'exam_id' => $examtem]) }}"><i
                                    class="fas fa-chart-bar fa-lg text-danger" data-toggle="tooltip"
                                    title="รายงาน"></i></a>
                            <a href="{{ route('destroy_examform', ['exam_id' => $examtem]) }}" class="switcher-delete"
                                onclick="deleteRecord(event)" data-toggle="tooltip" title="ลบ">
                                <i class="fas fa-trash-alt fa-lg text-warning "></i></a>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    <button type="button" onclick="window.location='{{ route('add_examform3', [$depart, 'subject_id' => $subs]) }}'"
        class="btn btn-success btn-add float-right" id="add_examform" data-toggle="tooltip" title="เพิ่ม">
        <span class="fas fa-plus"></span>
    </button>

    <script>
        $(document).ready(function() {
            var table = $('#datatable3').DataTable({

                lengthChange: false,
                responsive: true,
                info: false,
                language: {
                    url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Thai.json",
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

        });
    </script>
</div>
