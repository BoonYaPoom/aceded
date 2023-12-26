@extends('layouts.adminhome')
@section('content')
    <div class="page-inner">
        <!-- .page-title-bar -->

        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">

                <div class="card-header bg-muted">คำขอถึง Admin</div>
                <!-- .card-body -->
                <div class="card-body">
                    <!-- .table-responsive -->
                    <div class="table-responsive">
                        <!-- .table -->
                        <table id="datatable2" class="table w3-hoverable">
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th width="10%">ลำดับ</th>
                                    <th>รายการ</th>

                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr -->

                                <tr>
                                    <td><a>1</a></td>
                                    <td><a href="{{ route('requestSchool') }}"><i
                                                class="fas fa-folder-plus  fa-lg text-primary"></i> คำขอสมัคร
                                            Admin สถานศึกษา</a>
                                    </td>

                                </tr>
                                <tr>
                                    <td><a>2</a></td>
                                    <td><a href="{{ route('Certanddepart') }}"><i
                                                class="fas fa-folder-plus  fa-lg text-primary"></i>
                                            คำขอย้ายหน่วยงาน และ คำขอแก้ใบประกาศ</a>
                                    </td>
                                </tr>

                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->

                </div><!-- /.card-body -->
            </div><!-- /.card -->



        </div><!-- /.page-section -->

        <!-- .page-title-bar -->

    </div>
@endsection
