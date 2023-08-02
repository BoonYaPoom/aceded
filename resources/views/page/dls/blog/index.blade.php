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
    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted">
                    <a href="{{ route('dls') }}" style="text-decoration: underline;">จัดการข้อมูลและความรู้</a> /
                    <i>คลังความรู้</i>
                </div>
                <!-- /.card-header -->
                <!-- .card-body -->
                <div class="card-body">
                    <!-- .table-responsive -->
                    <div class="table-responsive">
                        <!-- .table -->
                        <table id="datatable2" class="table w3-hoverable">
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:10%"> ลำดับ </th>
                                    <th class="align-middle"> ชื่อหมวด (ไทย) </th>
                                    <th class="align-middle"> ชื่อหมวด (อังกฤษ) </th>
                                    <th class="align-middle" style="width:10%"> สถานะ </th>
                                    <th class="align-middle" style="width:10%"> กระทำ</th>
                                </tr>
                            </thead>
                            <!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                @php($i = 1)
                                @foreach ($blogcat as $item)
                                    <tr>
                                        <td><a href="#">{{ $i++ }}</a></td>
                                        <td>{{ $item->category_th }}</td>
                                        <td>{{ $item->category_en }}</td>
                                        <td class="align-middle"> <label
                                                class="switcher-control switcher-control-success switcher-control-lg">
                                                <input type="checkbox" class="switcher-input switcher-edit"
                                                    {{ $item->category_status == 1 ? 'checked' : '' }}
                                                    data-category-id="{{ $item->category_id }}">
                                                <span class="switcher-indicator"></span>
                                                <span class="switcher-label-on">ON</span>
                                                <span class="switcher-label-off text-red">OFF</span>
                                            </label></td>

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
                                                        url: '{{ route('changeStatusBlogCategory') }}',
                                                        data: {
                                                            'category_status': category_status,
                                                            'category_id': category_id
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
                                            <a href="{{ route('blog', ['category_id' => $item->category_id]) }}">
                                                <i class="fas fa-share-alt-square fa-lg text-info" data-toggle="tooltip"
                                                    title="ข้อมูล"></i>
                                            </a>
                                            <a href="{{ route('editblogcat', [$item->category_id]) }}">
                                                <i class="far fa-edit fa-lg text-success" data-toggle="tooltip"
                                                    title="แก้ไข"></i></a>
                                            <a href="{{ route('destoryblogcat', [$item->category_id]) }}"
                                                onclick="deleteRecord(event)" rel="เกร็ดความรู้...สู้ทุจริต"
                                                class="switcher-delete" data-toggle="tooltip" title="ลบ" role="button">
                                                <i class="fas fa-trash-alt fa-lg text-warning "></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->

        <!-- .page-title-bar -->
        <header class="page-title-bar">
            <!-- floating action -->
            <button type="button" class="btn btn-success btn-floated btn-addcop"
                onclick="window.location='{{ route('createblogcat') }}'" data-toggle="tooltip" title="เพิ่ม"><span
                    class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
