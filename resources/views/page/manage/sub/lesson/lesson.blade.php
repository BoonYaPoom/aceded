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
        <div class="table-responsive ">
            <!-- .table -->
            <table id="datatable" class="table w3-hoverable">
                <!-- thead -->
                <thead>
                    <tr class="bg-infohead">
                        <th class="align-middle" style="width:10%"> ลำดับ </th>
                        <th class="align-middle" style="width:20%"> ชื่อ (ไทย) </th>
                        <th class="align-middle w3-hide-small" style="width:20%"> ชื่อ (อังกฤษ) </th>
                        <th class="align-middle" style="width:10%"> ชนิดสื่อ </th>
                        <th class="align-middle" style="width:10%"> สถานะ </th>
                        <!--    <th class="align-middle" style="width:10%"> เวลาวิดิโอ </th>-->
                        <th class="align-middle" style="width:10%"> กระทำ</th>
                    </tr>
                </thead>
                <!-- tbody -->
                <tbody>
                    @php
                        $level = 0;

                    @endphp

                    @foreach ($lessons->sortBy('lesson_id') as $index => $item)
                        @php
                            $lesson_id = $item->lesson_id;
                            $level++;
                            $totalDuration = $item->duration;
                            $totalDurationInMinutes = $totalDuration;

                            $totalMinutes = floor($totalDurationInMinutes / 60); // จำนวนชั่วโมง
                            $totalMin = $totalDurationInMinutes % 60; // จำนวนนาทีที่เหลือ

                            if ($totalMin > 60) {
                                $totalMinutes += floor($totalMin / 60);
                                $totalMin %= 60;
                            }
                        @endphp
                        @php
                            $contentType = \App\Models\ContentType::where('content_type', $item->content_type)->first();
                        @endphp
                        <!--  Lessons -->

                        @php
                            $left = 0;
                        @endphp

                        <!--  Model -->
                        @if ($item->lesson_id_ref == 0)
                            @include('page.manage.sub.lesson.item.itemLesson')
                            <!--  Model -->
                            @include('page.manage.sub.lesson.item.modelLesson')
                        @endif

                        <!--  Lessons Small -->
                        @php
                            $left += $level + 30;
                        @endphp
                        @php
                            $subItems = $lessons->where('lesson_id_ref', $item->lesson_id)->sortBy('ordering');

                            $Orderings = $lessons->where('lesson_id_ref', $item->lesson_id)->pluck('ordering');

                        @endphp
                        @foreach ($lessons as $subitem)
                            @php
                                $contentTypesubitem = \App\Models\ContentType::where('content_type', $subitem->content_type)->first();
                            @endphp
                            @if ($subitem->ordering != $item->ordering && $subitem->lesson_id_ref == $item->lesson_id)
                                @include('page.manage.sub.lesson.item.subitem')
                                <!-- Model -->
                                @include('page.manage.sub.lesson.item.modelLessonSmall')
                            @endif
                        @endforeach
                    @endforeach

                </tbody><!-- /tbody -->
            </table><!-- /.table -->
        </div><!-- /.table-responsive -->
    </div><!-- /.card-body -->


    <script>
        // เพิ่ม event listener สำหรับ form submission
        document.getElementById('uploadfile').addEventListener('submit', function() {
            // แสดงหน้าต่างโหลด
            document.getElementById('loadingSpinner').style.display = 'block';
        });
    </script>


    <script>
        function togglerows(id) {
            $(".rows_" + id).toggle();
            var obj1 = document.getElementById("icon1_" + id);
            var obj2 = document.getElementById("icon2_" + id);

            if (obj1.classList.contains('fa-plus-circle')) {
                obj1.classList.remove('fa-plus-circle');
                obj1.classList.add('fa-minus-circle');
                obj2.classList.remove('fa-plus-circle');
                obj2.classList.add('fa-minus-circle');
            } else {
                obj1.classList.remove('fa-minus-circle');
                obj1.classList.add('fa-plus-circle');
                obj2.classList.remove('fa-minus-circle');
                obj2.classList.add('fa-plus-circle');
            }

        }
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
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

            $('#myInput').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
    <!-- .page-title-bar -->
    <header class="page-title-bar">
        <!-- floating action -->
        <input type="hidden" name="__id" />
        <button type="button" onclick="window.location='{{ route('add_lessonform', [$depart, 'subject_id' => $subs]) }}'"
            class="btn btn-success btn-floated btn-add" data-toggle="tooltip" title="เพิ่ม"><span
                class="fas fa-plus"></span></button>
        <!-- /floating action -->
    </header><!-- /.page-title-bar -->
@endsection
