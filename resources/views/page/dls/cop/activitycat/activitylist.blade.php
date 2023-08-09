@extends('layouts.adminhome')
@section('content')
    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="http://tcct.localhost:8080/admin/cop/home.html"
                        style="text-decoration: underline;">กิจกรรม</a> / <a
                        href="http://tcct.localhost:8080/admin/cop/activitycategory.html"
                        style="text-decoration: underline;">ชุมนุมนักปฏิบัติ</a> / <i>
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
                                    @if ($a->category_id == 1)
                                    @include('page.dls.cop.activitycat.item.cat1item.cat1')
                                    
                                    @elseif($a->category_id == 2)
                                    @include('page.dls.cop.activitycat.item.cat2item.cat2')
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
            <button type="button" onclick="window.location='{{ route('activiListForm1',['category_id' => $a->category_id]) }}'" class="btn btn-success btn-floated btn-addcop" id="add_activityform"
                data-toggle="tooltip" title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
            <!-- .page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
