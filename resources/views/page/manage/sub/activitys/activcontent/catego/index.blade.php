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
                        <th class="align-middle" style="width:30%"> ชื่อหมวด (ไทย) </th>
                        <th class="align-middle" style="width:30%"> ชื่อหมวด (อังกฤษ) </th>
                        <th class="align-middle" style="width:5%"> สถานะ </th>
                        <th class="align-middle" style="width:5%"> กระทำ</th>
                    </tr>
                </thead><!-- /thead -->
                @foreach ($catac as $c)
                    <tr>
                        <td><a href="#">1</a></td>
                        <td>{{ $c->category_th }}</td>
                        <td>{{ $c->category_en }}</td>
                        <td class="align-middle"> <label
                                class="switcher-control switcher-control-success switcher-control-lg">
                                <input type="checkbox" class="switcher-input switcher-edit"
                                    {{ $c->category_status == 1 ? 'checked' : '' }}
                                    data-category-id="{{ $c->category_id }}">
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
                                        url: '{{ route('changeStatuCategory') }}',
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
                            <a href="{{ route('topic', [$depart,$c->category_id]) }}">
                                <i class="fas fa-comment-dots fa-lg text-info" data-toggle="tooltip" title="ข้อมูล"></i></a>
                            <a href="{{ route('categoryform_edit', [$depart, $c->category_id]) }}">
                                <i class="far fa-edit fa-lg text-success" data-toggle="tooltip" title="แก้ไข"></i></a>
                            <a href="{{ route('categoryform_destroy', [$c->category_id]) }}" rel=" กระดานข่าว"
                                onclick="deleteRecord(event)" class="switcher-delete" data-toggle="tooltip" title="ลบ">
                                <i class="fas fa-trash-alt fa-lg text-warning "></i></a>
                        </td>
                    </tr><!-- /tr -->
                @endforeach
                <tbody>
                </tbody><!-- /tbody -->
            </table><!-- /.table -->
        </div><!-- /.table-responsive -->
    </div><!-- /.card-body -->
    <!-- .page-title-bar -->
    <header class="page-title-bar">
        <!-- floating action -->
        <input type="hidden" name="__id" />
        <button type="button" class="btn btn-success btn-floated btn-add" id="add_categoryform" data-toggle="tooltip"
            onclick="window.location='{{ route('categoryform', [$depart, 'subject_id' => $subs]) }}'" title="เพิ่ม"><span
                class="fas fa-plus"></span></button>
        <!-- /floating action -->
    </header><!-- /.page-title-bar -->
@endsection
