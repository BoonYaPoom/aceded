@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <div class="page-inner">
        <!-- .page-title-bar -->

        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted">
                    <a href="{{ route('departmentwmspage') }}">หน่วยงาน</a> / จัดการเว็บ
                </div>
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
                                    <th width="10%">กระทำ</th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr -->

                                <tr>
                                    <td><a>1</a></td>
                                    <td><a href="{{ route('hightDep', ['department_id' => $depart]) }}"><i
                                                class="fas fa-folder-plus  fa-lg text-primary"></i> ภาพประชาสัมพันธ์</a>
                                    </td>
                                    <td><a href="{{ route('hightDep', ['department_id' => $depart]) }}"><i
                                                class="fas fa-edit fa-lg text-success" data-toggle="tooltip"
                                                title="จัดการ"></i></a></td>
                                </tr><!-- /tr -->
                                <tr>
                                    <td><a>2</a></td>
                                    <td><a href="{{ route('Webpage', ['department_id' => $depart]) }}"><i
                                                class="fas fa-folder-plus  fa-lg text-primary"></i> ข่าว/กิจกรรม</a></td>
                                    <td><a href="{{ route('Webpage', ['department_id' => $depart]) }}"><i
                                                class="fas fa-edit fa-lg text-success" data-toggle="tooltip"
                                                title="จัดการ"></i></a></td>
                                </tr><!-- /tr -->
                                <!-- tr -->
                                <tr>
                                    <td><a>3</a></td>
                                    <td><a href="{{ route('linkpage', ['department_id' => $depart]) }}"><i
                                                class="fas fa-folder-plus  fa-lg text-primary"></i> ลิงค์ที่น่าสนใจ</a></td>
                                    <td><a href="{{ route('linkpage', ['department_id' => $depart]) }}"><i
                                                class="fas fa-edit fa-lg text-success" data-toggle="tooltip"
                                                title="จัดการ"></i></a></td>
                                </tr><!-- /tr -->
                                <!-- tr -->
                                <tr>
                                    <td><a>4</a></td>
                                    <td><a href="{{ route('surveypage', ['department_id' => $depart]) }}"><i
                                                class="fas fa-folder-plus  fa-lg text-primary"></i> แบบสำรวจ</a></td>
                                    <td><a href="{{ route('surveypage', ['department_id' => $depart]) }}"><i
                                                class="fas fa-edit fa-lg text-success" data-toggle="tooltip"
                                                title="จัดการ"></i></a></td>
                                </tr><!-- /tr -->
                                <!-- tr -->
                                <tr>
                                    <td><a>5</a></td>
                                    <td><a href="{{ route('manualpage', ['department_id' => $depart]) }}"><i
                                                class="fas fa-folder-plus  fa-lg text-primary"></i> คู่มือแนะนำการเรียน</a>
                                    </td>
                                    <td><a href="{{ route('manualpage', ['department_id' => $depart]) }}"><i
                                                class="fas fa-edit fa-lg text-success" data-toggle="tooltip"
                                                title="จัดการ"></i></a></td>
                                </tr><!-- /tr -->

                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->

                </div><!-- /.card-body -->
            </div><!-- /.card -->



        </div><!-- /.page-section -->

        <!-- .page-title-bar -->

    </div>
@endsection
