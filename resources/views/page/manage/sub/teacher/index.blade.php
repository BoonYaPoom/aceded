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



    <!-- .card-body -->
    <div class="card-body">

        <!-- .table-responsive -->
        <div class="table-responsive">
            <!-- .table -->
            <table id="datatable2" class="table w3-hoverable">
                <!-- thead -->
                <thead>
                    <tr class="bg-infohead">
                        <th class="align-middle" style="width:5%"> ลำดับ </th>
                        <th class="align-middle" style="width:30%"> ชื่อ-สกุล </th>

                        <th class="align-middle" style="width:5%"> กระทำ</th>
                    </tr>
                </thead><!-- /thead -->
                <!-- tbody -->
                <tbody>
                    <!-- tr -->
                    @php
                        
                        $n = 0;
                    @endphp
                    @foreach ($teachers as $item)
                        
                        @if ($item->teacher_status == 1)
                        @php
                            $n++;
                            $Users = \App\Models\Users::find($item->user_id);
                        @endphp
                            <tr>

                                <td><a href="#">{{ $n }} </a></td>
                                <td>

                                    {{ $Users->firstname }} {{ $Users->lastname }}

                                </td>

                                <td class="align-middle">
                                    <a href="" class="d-none"><i class="fas fa-user-tie fa-lg text-success"
                                            data-toggle="tooltip" title="ข้อมูล"></i></a>
                                    <a href=""
                                        rel="สำนักงานคณะกรรมการป้องกันและปราบปรามการทุจริตแห่งชาติ "
                                       data-teacher-id="{{ $item->teacher_id }}" class="switcher-delete" data-toggle="tooltip"
                                        title="ลบ"><i class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                        <script>
                                            $(document).ready(function() {
                                                $('.switcher-delete').on('click', function(event) {
                                                    event.preventDefault();
        
                                                    var teacherId = $(this).data('teacher-id');
        
                                                    $.ajax({
                                                        url: "{{ route('TeacherStatus') }}",
                                                        method: "GET",
                                                        data: {
                                                            teacher_id: teacherId,
                                                            teacher_status: 0
                                                        },
                                                        success: function(response) {
                                                            console.log(response); // ล็อกข้อมูลเพื่อตรวจสอบในคอนโซล
        
                                                            location.reload(); // รีเฟรชหน้าเว็บ
                                                        },
                                                        error: function(xhr, status, error) {
                                                            // เกิดข้อผิดพลาดในการส่งคำขอ
                                                            console.log(error);
                                                        }
                                                    });
                                                });
                                            });
                                        </script>
                                </td>

                            </tr><!-- /tr -->
                        @endif
                    @endforeach
                </tbody><!-- /tbody -->
            </table><!-- /.table -->
        </div><!-- /.table-responsive -->
        <br>
        <div class="row  h4">เพิ่มผู้สอน</div>
        <div class="table-responsive">
            <!-- .table -->
            <table id="datatable2" class="table w3-hoverable">
                <!-- thead -->
                <thead>
                    <tr class="bg-infohead">
                        <th class="align-middle" style="width:5%"> ลำดับ </th>
                        <th class="align-middle" style="width:30%"> ชื่อ-สกุล </th>
                        <th class="align-middle" style="width:5%"> เพิ่มผู้สอน</th>
                    </tr>
                </thead><!-- /thead -->
                <!-- tbody -->
                <tbody>

                    <!-- tr -->
                    @php
                        $l = 0;
                    @endphp
                    @foreach ($teachers as $item)
                       
           
                            @if ($item->teacher_status == 0)
                            @php
                            $l++;
                            $Users1 = \App\Models\Users::find($item->user_id);
                        @endphp
                                <tr>
                                    <td><a href="#">{{ $l }}</a></td>
                                    <td>
                                        {{ $Users1->firstname }} {{ $Users1->lastname }}
                                    </td>

                                    <td class="align-middle">
                                        <a href="#" class="change-status" data-teacher-id="{{ $item->teacher_id }}">
                                            <i class="fas fa-user-plus fa-lg text-success" data-toggle="tooltip"
                                                title="ข้อมูล"></i>
                                        </a>
                                    </td>

                                    </td>
                                </tr><!-- /tr -->

                                <script>
                                    $(document).ready(function() {
                                        $('.change-status').on('click', function(event) {
                                            event.preventDefault();

                                            var teacherId = $(this).data('teacher-id');

                                            $.ajax({
                                                url: "{{ route('TeacherStatus') }}",
                                                method: "GET",
                                                data: {
                                                    teacher_id: teacherId,
                                                    teacher_status: 1
                                                },
                                                success: function(response) {
                                                    console.log(response); // ล็อกข้อมูลเพื่อตรวจสอบในคอนโซล

                                                    location.reload(); // รีเฟรชหน้าเว็บ
                                                },
                                                error: function(xhr, status, error) {
                                                    // เกิดข้อผิดพลาดในการส่งคำขอ
                                                    console.log(error);
                                                }
                                            });
                                        });
                                    });
                                </script>
                            @endif
               
                    @endforeach
                </tbody><!-- /tbody -->
            </table><!-- /.table -->
        </div><!-- /.table-responsive -->
    </div><!-- /.card-body -->
@endsection
