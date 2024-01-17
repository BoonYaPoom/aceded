@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <form action="{{ route('addextendersubmit', $depart) }}" method="post" enctype="multipart/form-data">
        @csrf
        <!-- .page-inner -->
        <div class="page-inner">
            <!-- .form -->
            <!-- .page-section -->
            <div class="page-section">
                <!-- .card -->
                <div class="card card-fluid">

                    <!-- .card-header -->
                    <div class="card-header bg-muted"><a
                            href="{{ route('DPUserManage', ['department_id' => $depart->department_id]) }}">ผู้ใช้งาน</a>/ <a
                            href="{{ route('testumsschool', ['department_id' => $depart->department_id]) }}">จัดการสถานศึกษา</a>
                    </div>
                    <div class="card-body">
                        @include('layouts.department.item.data.UserAdmin.group.umsschool.test.create.select')
                        @include('layouts.department.item.data.UserAdmin.group.umsschool.test.create.text')
                        @include('layouts.department.item.data.UserAdmin.group.umsschool.test.create.js')
                    </div>
                </div>
                <div class="form-actions ">
                    <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                        บันทึก</button>
                </div><!-- /.form-actions -->
            </div><!-- /.page-section -->
        </div><!-- /.page-inner -->

    </form>
@endsection
