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
                    <a href="{{ route('dls') }}" style="text-decoration: underline;">คลังข้อมูลและความรู้</a> / <i>
                        {{ $bookcat->category_th }}</i>
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
                                    <th class="align-middle" style="width:10%"> ลำดับ </th>
                                    <th class="align-middle" style="width:40%"> เรื่อง </th>
                                    <th class="align-middle" style="width:30%"> ผู้แต่ง </th>
                                    <th class="align-middle" style="width:10%"> สถานะ </th>
                                    <th class="align-middle" style="width:10%"> กระทำ</th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                @php($i = 1)
                                @foreach ($books as $item)
                                    <tr>
                                        <td><a>{{ $i++ }}</a></td>
                                        <td>{{ $item->book_name }}</td>
                                        <td>{{ $item->book_author }}</td>

                                        <td class="align-middle"> <label
                                                class="switcher-control switcher-control-success switcher-control-lg">
                                                <input type="checkbox" class="switcher-input switcher-edit"
                                                    {{ $item->book_status == 1 ? 'checked' : '' }}
                                                    data-book-id="{{ $item->book_id }}">
                                                <span class="switcher-indicator"></span>
                                                <span class="switcher-label-on">ON</span>
                                                <span class="switcher-label-off text-red">OFF</span>
                                            </label></td>

                                        <script>
                                            $(document).ready(function() {
                                                $(document).on('change', '.switcher-input.switcher-edit', function() {
                                                    var book_status = $(this).prop('checked') ? 1 : 0;
                                                    var book_id = $(this).data('book-id');
                                                    console.log('book_status:', book_status);
                                                    console.log('book_id:', book_id);
                                                    $.ajax({
                                                        type: "GET",
                                                        dataType: "json",
                                                        url: '{{ route('changeStatuBook') }}',
                                                        data: {
                                                            'book_status': book_status,
                                                            'book_id': book_id
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
                                            <a href="{{ route('editcatbook', ['book_id' => $item]) }}"
                                                title="แก้ไข"><i class="far fa-edit fa-lg text-success"></i></a>
                                            <a href="{{ route('destroycatbook', ['book_id' => $item]) }}"
                                                onclick="deleteRecord(event)" rel="" class="switcher-delete"
                                                title="ลบ"><i
                                                    class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                        </td>
                                        </td>
                                    </tr>
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
            <input type="hidden" name="__id" id="__id" value="5" />
            <button type="button" class="btn btn-success btn-floated btn-adddls"
                onclick="window.location='{{ route('catcreatebook', ['category_id' => $bookcat]) }}'" data-toggle="tooltip"
                title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
