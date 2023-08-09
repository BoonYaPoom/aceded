@extends('layouts.adminhome')
@section('content')
    <!-- .page-inner -->
    <div class="page-inner">

        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="/">หน่วยงาน</a> / จัดการเรียนรู้</div>
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
                                    <th class="align-middle" style="width:90%"> </th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr -->



                                <tr>
                                    <td>1</td>
                                    <td><i class="fas fa-folder-plus fa-lg text-primary"></i> <a
                                            href="{{ route('suppage', ['department_id' => $depart->department_id]) }}">จัดการวิชา</a>
                                    </td>
                                    </td>
                                </tr><!-- /tr -->
                                <!-- tr -->
                                <tr>
                                    <td>2</td>
                                    <td><i class="fas fa-folder-plus fa-lg text-primary"></i> <a
                                            href="{{ route('courgroup', ['department_id' => $depart->department_id]) }}">จัดการหลักสูตร</a>
                                    </td>
                                    </td>
                                </tr><!-- /tr -->
                                <tr>
                                    <td>3</td>
                                    <td><i class="fas fa-folder-plus fa-lg text-primary"></i> <a
                                            href="{{ route('hightDep', ['department_id' => $depart->department_id]) }}">ภาพประชาสัมพันธ์</a>
                                    </td>
                                    </td>
                                </tr><!-- /tr -->

                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->

        <!-- .page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
