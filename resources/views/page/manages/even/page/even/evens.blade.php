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
    @if (Session::has('warning'))
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

            toastr.warning("{{ Session::get('warning') }}");
        </script>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <div class="page-inner">
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('manage', ['department_id' => $depart]) }}"
                        style="text-decoration: underline;">จัดการเว็บ </a> / <a
                        href="{{ route('Webpage', ['department_id' => $depart]) }}"
                        style="text-decoration: underline;">ข่าว/กิจกรรม</a> / <i> ข่าว</i></div>
                <div class="card-body">

                    <!-- .table-responsive -->
                    <div class="table-responsive">
                        <!-- .table -->
                        <!-- .table -->
                        <table id="datatable2" class="table w3-hoverable">
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:5%"> ลำดับ </th>
                                    <th class="align-middle" style="width:30%"> ชื่อหมวด (ไทย) </th>
                                    <th class="align-middle" style="width:30%"> ชื่อหมวด (อังกฤษ) </th>
                                    <th class="align-middle" style="width:5%"> สถานะ </th>
                                    <th class="align-middle" style="width:5%"> กระทำ</th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr -->
                                @php
                                    $w = 1;

                                @endphp
                                @foreach ($wed->sortBy('category_id') as $item)
                                    @if ($item->category_type == 1)
                                        <tr>
                                            <td>{{ $w++ }}</td>
                                            <td>{{ $item->category_th }}</td>
                                            <td>{{ $item->category_en }}</td>
                                            <td class="align-middle">
                                                <label
                                                    class="switcher-control switcher-control-success switcher-control-lg">
                                                    <input type="checkbox" class="switcher-input switcher-edit"
                                                        {{ $item->category_status == 1 ? 'checked' : '' }}
                                                        data-category-id="{{ $item->category_id }}">
                                                    <span class="switcher-indicator"></span>
                                                    <span class="switcher-label-on">ON</span>
                                                    <span class="switcher-label-off text-red">OFF</span>
                                                </label>
                                            </td>
                                            <script>
                                                $(document).ready(function() {
                                                    $(document).on('change', '.switcher-input.switcher-edit', function() {
                                                        var category_status = $(this).prop('checked') ? 1 : 0;
                                                        var category_id = $(this).data('category-id');
                                                        console.log('category_status:', category_status);
                                                        console.log('category_id:', category_id);
                                                        $.ajax({
                                                            type: "GET",
                                                            dataType: "json",
                                                            url: '{{ route('changeStatusWebCat') }}',
                                                            data: {
                                                                'category_status': category_status,
                                                                'category_id': category_id
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
                                                <a
                                                    href="{{ route('catpage', ['department_id' => $depart, 'category_id' => $item->category_id]) }}">
                                                    <i class="fas far fa-list-alt fa-lg text-info" data-toggle="tooltip"
                                                        title="ข้อมูล"></i></a>
                                                <a
                                                    href="{{ route('evenedit', ['department_id' => $depart, 'category_id' => $item->category_id]) }}"><i
                                                        class="fas fa-edit fa-lg text-success" data-toggle="tooltip"
                                                        title="แก้ไข"></i></a>
                                                <!-- Delete Confirmation Link -->
                                                <a href="{{ route('evendelete', ['category_id' => $item->category_id]) }}"
                                                    onclick="deleteRecord(event)" rel="กิจกรรม" class="switcher-delete"
                                                    title="ลบ"><i class="fas fa-trash-alt fa-lg text-warning "></i></a>

                                                <!-- Delete Confirmation Modal -->
                                                <div class="modal fade" id="deleteModal" tabindex="-1" user_role="dialog"
                                                    aria-labelledby="clientDeleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" user_role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-warning">
                                                                <h6 id="clientDeleteModalLabel"
                                                                    class="modal-title inline-editable">
                                                                    <span class="sr-only">Delete</span>
                                                                    <input type="text"
                                                                        class="form-control form-control-lg text-primary"
                                                                        placeholder="Are you sure you want to delete?"
                                                                        required="">
                                                                </h6>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <div class="form-label-group">
                                                                        <p>
                                                                        <div id="deleteitem" class="h6">DELETE</div>
                                                                        <p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-warning"
                                                                    id="confirmdelete"><i
                                                                        class="fas fa-trash-alt fa-lg "></i>
                                                                    Delete Item</button>
                                                                <button type="button" class="btn btn-light"
                                                                    data-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr><!-- /tr -->
                                        <!-- tr -->
                                    @endif
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
            <button type="button" class="btn btn-success btn-floated btn-addwms"
                onclick="window.location='{{ route('evencreate', ['department_id' => $depart]) }}'" data-toggle="tooltip"
                title="เพิ่ม">
                <span class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
