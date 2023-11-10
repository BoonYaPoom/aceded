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
                    <a href="{{ route('manage', ['department_id' => $depart->department_id]) }}">หน่วยงาน</a> / จัดการข้อสอบ ระดับ {{$depart->name_th}}
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
                                    <th width="10%">สถานะ</th>
                                    <th width="10%">กระทำ</th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr -->
                                @php
                                    $e = 0;
                                @endphp
                                <tr>
                                    <td><a>{{ $e }}</a></td>
                                    <td><a>22</a></td>

                                    <td class="align-middle"> <label
                                            class="switcher-control switcher-control-success switcher-control-lg">
                                            <input type="checkbox" class="switcher-input switcher-edit" data-group-id="">
                                            <span class="switcher-indicator"></span>
                                            <span class="switcher-label-on">ON</span>
                                            <span class="switcher-label-off text-red">OFF</span>
                                        </label></td>
                                    <td class="align-middle">
                                        <a href="{{ route('ManageExam', $depart) }}"><i
                                                class="fas fa-plus-circle fa-lg text-info" data-toggle="tooltip"
                                                title="เพิ่มคำถาม"></i></a>
                                        <a href=""><i class="fas fa-chart-bar fa-lg text-danger"
                                                data-toggle="tooltip" title="รายงานผล"></i></a>
                                        <a href=""><i class="far fa-edit fa-lg text-success" data-toggle="tooltip"
                                                title="แก้ไข"></i></a>
                                        <a href="" onclick="deleteRecord(event)"
                                            rel="แบบประเมินความพึงพอใจที่มีต่อบทเรียนออนไลน์ รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย"
                                            class="switcher-delete" data-toggle="tooltip" title="ลบ">
                                            <i class="fas fa-trash-alt fa-lg text-warning "></i></a>

                                    </td>
                                </tr><!-- /tr -->

                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->

                </div><!-- /.card-body -->
            </div><!-- /.card -->



        </div><!-- /.page-section -->

        <!-- .page-title-bar -->
        <!-- .page-title-bar -->
        <header class="page-title-bar">
            <!-- floating action -->
            <button type="button" class="btn btn-success btn-floated btn-addwms" onclick="window.location=''"
                data-toggle="tooltip" title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div>
@endsection
