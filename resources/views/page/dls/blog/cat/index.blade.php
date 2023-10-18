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
        <div class="page-section">
            <div class="card card-fluid">
                <div class="card-header bg-muted">
                    <a href="{{ route('dls',['department_id'=> $blogcat->department_id]) }}" style="text-decoration: underline;">จัดการข้อมูลและความรู้</a> / <a
                        href="{{ route('blogpage',['department_id'=> $blogcat->department_id]) }}"
                        style="text-decoration: underline;">คลังความรู้</a> / <i> {{ $blogcat->category_th }}</i>
                </div>
                <!-- .card-body -->
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- .table -->
                        <table id="datatable" class="table w3-hoverable">
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:5%"> ลำดับ </th>
                                    <th class="align-middle" style="width:70%"> เรื่อง </th>
                                    <th class="align-middle d-none" style="width:5%"> แนะนำ </th>
                                    <th class="align-middle d-none"> เรียงลำดับ </th>
                                    <th class="align-middle" style="width:5%"> สถานะ </th>
                                    <th class="align-middle text-center" style="width:15%"> กระทำ</th>
                                </tr>
                            </thead>
                            <!-- /thead -->
                            <tbody>
                                <!-- tr -->
                                @php($i = 1)
                                @foreach ($blogs as $item)
                                    <tr>
                                        <td><a href="#">{{ $i++ }}</a></td>
                                        <td>{{ $item->title }}</td>
                                        <td class="align-middle d-none">
                                            <label class="switcher-control switcher-control-success switcher-control-lg">
                                                <input type="checkbox" class="switcher-input switcher-edit" checked
                                                    value="1"
                                                    id="156fd107bbfd704a8becf299f19a86b6__blog__recommended__blog_id__1__1683528128">
                                                <span class="switcher-indicator"></span>
                                                <span class="switcher-label-on">ON</span>
                                                <span class="switcher-label-off text-red">OFF</span>
                                            </label>
                                        </td>
                                        <td class="align-middle d-none">
                                            <select class="custom-select"
                                                onchange="window.location='https://aced.dlex.ai/childhood/admin/switcher/sortblog/1/'+this.value">
                                                <option value="1" selected>1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </td>

                                        <td class="align-middle"> <label
                                            class="switcher-control switcher-control-success switcher-control-lg">
                                            <input type="checkbox" class="switcher-input switcher-edit"
                                                {{ $item->blog_status == 1 ? 'checked' : '' }}
                                                data-blog-id="{{ $item->blog_id }}">
                                            <span class="switcher-indicator"></span>
                                            <span class="switcher-label-on">ON</span>
                                            <span class="switcher-label-off text-red">OFF</span>
                                        </label></td>
                      
                                    <script>
                                        $(document).ready(function() {
                                            $(document).on('change', '.switcher-input.switcher-edit', function() {
                                                var blog_status = $(this).prop('checked') ? 1 : 0;
                                                var blog_id = $(this).data('blog-id');
                                                console.log('blog_status:', blog_status);
                                                console.log('blog_id:', blog_id);
                                                $.ajax({
                                                    type: "GET",
                                                    dataType: "json",
                                                    url: '{{ route('changeStatusBlog') }}',
                                                    data: {
                                                        'blog_status': blog_status,
                                                        'blog_id': blog_id
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


                                        <td class="align-middle text-center">
                                            <a class="d-none" href=""
                                                target=_blank>
                                                <i class="fa fa-eye fa-lg text-success" data-toggle="tooltip"
                                                    title="ข้อมูล"></i>
                                            </a>
                                            <a class="" href="{{ route('editblog', [$depart,'blog_id' => $item]) }}">
                                                <i class="fa fa-edit fa-lg text-success" data-toggle="tooltip"
                                                    title="แก้ไข"></i></a>
                                            <a href="{{ route('destoryblog', ['blog_id' => $item]) }}"
                                                onclick="deleteRecord(event)" class="switcher-delete" data-toggle="tooltip"
                                                title="ลบ">
                                                <i class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                        </td>
                                    </tr><!-- /tr -->
                                    <!-- tr -->
                                @endforeach
                            </tbody>
                        </table>
                        <script>
                            $(document).ready(function() {
                                var table = $('#datatable').DataTable({

                                    lengthChange: false,
                                    responsive: true,
                                    info: true,
                                    pageLength: 50,
                                    language: {
                                        info: "ลำดับที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                        infoEmpty: "ไม่พบรายการ",
                                        infoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
                                        paginate: {
                                            first: "หน้าแรก",
                                            last: "หน้าสุดท้าย",
                                            previous: "ก่อนหน้า",

                                            next: "ถัดไป"
                                        }
                                    },

                                });


                            });
                        </script>
                        <!-- /.table -->
                    </div><!-- /.table-responsive -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->

        <!-- .page-title-bar -->
        <header class="page-title-bar">
            <!-- floating action -->
            <button type="button" class="btn btn-success btn-floated btn-addcop"
                onclick="window.location='{{ route('createblog', [$depart,'category_id' => $blogcat]) }}'" data-toggle="tooltip"
                title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
    </div><!-- /.page-inner -->
@endsection
