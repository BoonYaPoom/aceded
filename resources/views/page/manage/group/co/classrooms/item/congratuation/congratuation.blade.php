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
                    <a href="{{ route('departmentpage') }}"
                        style="text-decoration: underline;">หมวดหมู่</a>
                </div><!-- /.card-header -->
                <!-- .nav-scroller -->
                <div class="nav-scroller border-bottom">
                    <!-- .nav -->
                    <div class="nav nav-tabs bg-muted h3">
                        <a class="nav-link " href=""><i
                                class="fas fa-users"></i> ผู้เรียน รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย </a>
                    </div><!-- /.nav -->
                </div><!-- /.nav-scroller -->
                <!-- .card-body -->

                <div class="card-body">


                  <div class="top">
                    <div class="dt-buttons btn-group"><button class="btn btn-secondary buttons-excel buttons-html5"
                            tabindex="0" aria-controls="datatable" type="button"><span>Excel</span></button>
                    </div>

                </div>

                    <div class="table-responsive">
                        <!-- .table -->

                        <table id="datatable" class="table w3-hoverable">

                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:5%"> ลำดับ </th>
                                    <th class="align-middle" style="width:65%"> ชื่อ-สกุล </th>
                                    <th class="align-middle" style="width:15%"> ขอใบประกาศนียบัตร </th>
                                    <th class="align-middle" style="width:15%"> กระทำ</th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr -->
                                <tr>
                                    <td><a href="#">1</a></td>
                                    <td id="learnername23">aced_admin </td>
                                    <td id="request_23"></td>
                                    <td class="align-middle"><a
                                            href=""><i
                                                class="fas fa-graduation-cap fa-lg text-success" data-toggle="tooltip"
                                                title="พิมพ์ใบประกาศนียบัตร"></i></a><a
                                            href="{{route('teacherinfo')}}"><i
                                                class="fas fa-envelope fa-lg text-danger" data-toggle="tooltip"
                                                title="อนุมัติคำขอ"></i></a>
                                    </td>
                                </tr><!-- /tr -->
                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->
        <!-- .page-title-bar -->
        <header class="page-title-bar">
            <!-- floating action -->
            <input type="hidden" />
            <button type="button" onclick="window.location=''"
                class="btn btn-success btn-floated btn-add '.$buttonadd.'" id="registeradd" data-toggle="tooltip"
                title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
