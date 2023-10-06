@extends('layouts.adminhome')
@section('content')
<form action="{{ route('storeperson') }}" method="post"
    enctype="multipart/form-data">
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
                        href="{{ route('UserManage') }}">ผู้ใช้งาน</a>/ <a
                        href="{{ route('personTypes') }}">กลุ่มผู้ใช้งาน</a> </div><!-- /.card-header -->
                    <!-- .card-body -->
                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="person"> <span
                                    class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" id="person" name="person"
                                placeholder="ชื่อกลุ่มผู้ใช้งาน" required="" value="">
                        </div><!-- /.form-group -->
                        <!-- .form-group -->

                    </div><!-- /.card-body -->
                </div><!-- /.card -->

                <!-- .form-actions -->
                <div class="form-actions ">
                    <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                        บันทึก</button>
                </div><!-- /.form-actions -->
            </div><!-- /.page-section -->
        </div><!-- /.page-inner -->

    </form>
@endsection
