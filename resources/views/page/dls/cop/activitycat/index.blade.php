@extends('layouts.adminhome')
@section('content')
    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('cop') }}"
                        style="text-decoration: underline;">กิจกกรรม</a> / <a href="{{ route('activi') }}"
                        style="text-decoration: underline;">
                        ชุมนุมนักปฏิบัติ</a> / <i> ถ่ายทอดสด</i></div><!-- /.card-header -->
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
                            <!-- tbody -->
                            <tbody class="font-size-1">
                                @php($a = 0)
                                @foreach ($actCat as $item)
                                    @php($a++)
                                    <tr class="js-datatabale-details">
                                        <td class="align-middle " width="10%">
                                            {{ $a }}
                                        </td>
                                        <td class="align-middle  font-weight-normal" width="40%">
                                            {{ $item->category_th }}
                                        </td>

                                        <td class="align-middle " width="15%">
                                            {{ $item->category_en }}
                                        </td>
                                        <td class="align-middle" width="10%"> <label
                                                class="switcher-control switcher-control-success switcher-control-lg">
                                                <input type="checkbox" class="switcher-input switcher-edit"
                                                    {{ $item->category_status == 1 ? 'checked' : '' }}
                                                    data-category-id="{{ $item->category_id }}">
                                                <span class="switcher-indicator"></span>
                                                <span class="switcher-label-on">ON</span>
                                                <span class="switcher-label-off text-red">OFF</span>
                                            </label></td>

                                        <td class="align-middle text-danger" width="25%">
                                            <a class="btn btn-sm btn-icon btn-soft-secondary rounded-circle" href="{{ route('activiList', [$item->category_id]) }}">
                                                <span class="fas fa-list-ul btn-icon__inner  text-success"></span>
                                            </a>
                                            <a class="btn btn-sm btn-icon btn-soft-secondary rounded-circle" href="{{ route('activiInvite', [$item->category_id]) }}">
                                                <span class="fas fa-paper-plane btn-icon__inner  text-success"></span>
                                            </a>
                                            <a class="btn btn-sm btn-icon btn-soft-secondary rounded-circle" href="{{ route('activiFrom', [$item->category_id]) }}">
                                                <span class="fas fa-edit btn-icon__inner text-success"></span>
                                            </a>

                                        </td>
                                    </tr>


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
                                                    url: '{{ route('ActivityChangeStatus') }}',
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
            <button type="button" class="d-none btn btn-success btn-floated btn-addcop" id="add_activitycategoryform"
                data-toggle="tooltip" title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
