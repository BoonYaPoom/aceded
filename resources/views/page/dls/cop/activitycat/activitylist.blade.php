@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('cop', ['department_id' => $actCat->department_id]) }}"
                        style="text-decoration: underline;">กิจกกรรม</a> / <a
                        href="{{ route('activi', ['department_id' => $actCat->department_id]) }}"
                        style="text-decoration: underline;">ชุมนุมนักปฏิบัติ </a> / <i>
                        {{ $actCat->category_th }}
                    </i></div>
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
                                    <th class="align-middle" style="width:5%"> ลำดับ </th>
                                    <th class="align-middle" style="width:30%"> เรื่อง </th>
                                    <th class="align-middle" style="width:5%"> สถานะ </th>
                                    <th class="align-middle" style="width:5%"> กระทำ</th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody><!-- tr -->

                                @php($i = 0)
                                @foreach ($act as $a)
                                    @php($i++)
                                    @if ($actCat->category_type == 1)
                                        @include('page.dls.cop.activitycat.item.cat1item.cat1')
                                    @elseif ($actCat->category_type == 2)
                                        @include('page.dls.cop.activitycat.item.cat3item.cat3')
                                    @endif
                                @endforeach
                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->
        <script>
            $(document).ready(function() {
                $(document).on('change', '.switcher-input.switcher-edit', function() {
                    var activity_status = $(this).prop('checked') ? 1 : 0;
                    var activity_id = $(this).data('activity-id');
                    console.log('activity_status:', activity_status);
                    console.log('activity_id:', activity_id);
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: '{{ route('ActChangeStatus') }}',
                        data: {
                            'activity_status': activity_status,
                            'activity_id': activity_id
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
        <!-- .page-title-bar -->
      
        <!-- floating action -->
        @if ($actCat->category_type == 1 || $actCat->category_type == 2)
        <button type="button"
            onclick="window.location='{{ route('activiListForm1', [$depart, 'category_id' => $actCat->category_id]) }}'"
            class="btn btn-success btn-floated btn-addcop" id="add_activityform" data-toggle="tooltip"
            title="เพิ่ม"><span class="fas fa-plus"></span></button>
    @elseif($actCat->category_type == 3)
        <button type="button"
            onclick="window.location='{{ route('activiListForm2', [$depart, 'category_id' => $actCat->category_id]) }}'"
            class="btn btn-success btn-floated btn-addcop" id="add_activityform" data-toggle="tooltip"
            title="เพิ่ม"><span class="fas fa-plus"></span></button>
    @endif
        <!-- /floating action -->
        <!-- .page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
