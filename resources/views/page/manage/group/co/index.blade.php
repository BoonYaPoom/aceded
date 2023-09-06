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


    <!-- .page-inner -->
    <div class="page-inner">

        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted">
                    <a href="{{ route('learn',[$courses->department_id]) }}" style="text-decoration: underline;">จัดการหลักสูตร</a> / <a
                        href="{{ route('courgroup',[$courses->department_id]) }}" style="text-decoration: underline;">หมวดหมู่</a> / <i>{{$courses->group_th}}</i>
                </div><!-- /.card-header -->
                <!-- .card-body -->
                <div class="card-body">

                    <!-- .table-responsive -->
                    <div class="table-responsive">
                        <!-- .table -->
                        <table id="datatable2" class="table w3-hoverable">
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:10%"> รหัสหลักสูตร </th>
                                    <th class="align-middle" style="width:30%"> หลักสูตร (ไทย) </th>
                                    <th class="align-middle" style="width:30%"> หลักสูตร (อังกฤษ) </th>
                                    <th class="align-middle" style="width:10%"> แนะนำ </th>
                                    <th class="align-middle" style="width:20%">กระทำ</th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr -->
                                @foreach ($cour as $item)
                                    <tr>
                                        <td>{{ $item->course_code }}</td>
                                        <td> {{ $item->course_th }}</td>
                                        <td>{{ $item->course_en }} </td>
                                        <td class="align-middle"> <label
                                                class="switcher-control switcher-control-success switcher-control-lg"><input
                                                    type="checkbox" class="switcher-input switcher-edit"  {{ $item->course_status == 1 ? 'checked' : '' }}
                                                    data-course-id="{{ $item->course_id }}">
                                                <span class="switcher-indicator"></span> <span
                                                    class="switcher-label-on">ON</span> <span
                                                    class="switcher-label-off text-red">OFF</span></label> </td>


                                            
                                  
                                                <script>
                                                    $(document).ready(function() {
                                                        $(document).on('change', '.switcher-input.switcher-edit', function() {
                                                            var course_status = $(this).prop('checked') ? 1 : 0;
                                                            var course_id = $(this).data('course-id');
                                                            console.log('course_status:', course_status);
                                                            console.log('course_id:', course_id);
                                                            $.ajax({
                                                                type: "GET",
                                                                dataType: "json",
                                                                url: '{{ route('changeStatusCourse') }}',
                                                                data: {
                                                                    'course_status': course_status,
                                                                    'course_id': course_id
                                                                },
                                                                success: function(data) {
                                                                    console.log(data.message); 
                                                                },
                                                                error: function(xhr, status, error) {
                                                                    console.log('ข้อผิดพลาด');
                                                                }
                                                            });
                                                        });
                                                    });
                                                </script>







                                        <td class="align-middle">
                                            <a href="{{ route('class_page', ['course_id' => $item]) }}"
                                                data-toggle="tooltip" title="ผู้เรียน"><i
                                                    class="fas fa-users fa-lg text-info "></i></a>
                                            <a href="{{ route('structure_page', ['course_id' => $item]) }}"
                                                data-toggle="tooltip" title="รายละเอียดหลักสูตร"><i
                                                    class="fas fa-list-ul fa-lg text-danger "></i></a>
                                            <a href="{{ route('editcor', ['course_id' => $item]) }}"
                                                data-toggle="tooltip" title="แก้ไข"><i
                                                    class="far fa-edit fa-lg text-success "></i></a>
                                            <a href="{{ route('courseform_destroy', ['course_id' => $item]) }}"
                                                rel="รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย"
                                                onclick="deleteRecord(event)" class="switcher-delete" data-toggle="tooltip"
                                                title="ลบข้อมูล"><i class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                        </td>
                                    </tr><!-- /tr -->
                                @endforeach
                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->

        <!-- .page-title-bar -->
        <header class="page-title-bar">
            <!-- floating action -->
            <input type="hidden" name="__id" id="__id" value="29" />
            <button type="button" class="btn btn-success btn-floated btn-add"
                onclick="window.location='{{ route('createcor', ['group_id' => $courses]) }}'" data-toggle="tooltip"
                title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
