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

                                @php($i = 1)
                                @foreach ($act as $a)
                                    @if ($a->category_id == 3)
                                        <tr>
                                            <td><a href="#">{{ $i++ }}</a></td>
                                            <td>{{ $a->title }}</td>
                                            <td class="align-middle"> <label
                                                    class="switcher-control switcher-control-success switcher-control-lg"><input
                                                        type="checkbox" class="switcher-input switcher-edit" checked
                                                        value="1">
                                                    <span class="switcher-indicator"></span> <span
                                                        class="switcher-label-on">ON</span> <span
                                                        class="switcher-label-off text-red">OFF</span></label> </td>
                                            <td class="align-middle">
                                                <a class="d-none" href="" target=_blank><i
                                                        class="fa fa-eye fa-lg text-success" data-toggle="tooltip"
                                                        title="ข้อมูล"></i></a>
                                                <a class="" href="">
                                                    <i class="fa fa-edit fa-lg text-success" data-toggle="tooltip"
                                                        title="แก้ไข"></i></a>

                                                <a href="#clientDeleteModal" rel="" class="switcher-delete"
                                                    data-toggle="tooltip" title="ลบ"><i
                                                        class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                            </td>
                                        </tr><!-- /tr --><!-- tr -->
                                    @elseif($a->category_id == 4)
                                        <tr>
                                            <td><a href="#">{{ $i++ }}</a></td>
                                            <td>{{ $a->title }}</td>
                                            <td class="align-middle"> <label
                                                    class="switcher-control switcher-control-success switcher-control-lg"><input
                                                        type="checkbox" class="switcher-input switcher-edit" checked
                                                        value="1">
                                                    <span class="switcher-indicator"></span> <span
                                                        class="switcher-label-on">ON</span> <span
                                                        class="switcher-label-off text-red">OFF</span></label> </td>
                                            <td class="align-middle">
                                                <a class="d-none" href="" target=_blank><i
                                                        class="fa fa-eye fa-lg text-success" data-toggle="tooltip"
                                                        title="ข้อมูล"></i></a>
                                                <a class="" href="">
                                                    <i class="fa fa-edit fa-lg text-success" data-toggle="tooltip"
                                                        title="แก้ไข"></i></a>

                                                <a href="#clientDeleteModal" rel="" class="switcher-delete"
                                                    data-toggle="tooltip" title="ลบ"><i
                                                        class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                            </td>
                                        </tr><!-- /tr --><!-- tr -->
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
            <button type="button" class="btn btn-success btn-floated btn-addcop" id="add_activityform"
                data-toggle="tooltip" title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
            <!-- .page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
