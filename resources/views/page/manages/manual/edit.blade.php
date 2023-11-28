@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('manage', ['department_id' => $manuals->department_id]) }}"
                        style="text-decoration: underline;">จัดการเว็บ</a> / <a href="{{ route('manualpage', ['department_id' => $manuals->department_id]) }}"
                        style="text-decoration: underline;">แก้ไขคู่มือใช้งาน</a> / <i> {{ $manuals->manual }}</i></div>
                <!-- /.card-header -->
                <!-- .card-body -->
                <form action="{{ route('updatemanual', [$depart,'manual_id' => $manuals->manual_id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="manual">ชื่อคู่มือใช้งาน </label>
                            <input type="text" class="form-control" name="manual" placeholder="คู่มือใช้งาน"
                                required="" value="{{ $manuals->manual }}">
                        </div><!-- /.form-group -->
                        @error('manual')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group">
                            <div class="form-group">
                                <label for="cover"><img src="{{ asset($manuals->cover) }}"
                                        alt="{{ $manuals->cover }}" width="40%">
                            </div>
                            <label for="cover">ภาพปก </label> <input type="file" class="form-control" name="cover"
                                placeholder="ภาพปก" accept="image/*">
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="manual_path">ไฟล์คู่มือใช้งาน </label>
                            <input type="file" class="form-control" name="manual_path" placeholder="ไฟล์คู่มือใช้งาน"
                                 accept="">
                                 <p></p>
                                 <span class="badge badge-warning">{{ $manuals->manual_path }}</span>
                        </div><!-- /.form-group -->
           
                        @error('manual_path')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <label for="manual_status">สถานะ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="manual_status" id="manual_status" value="1"
                                    {{ $manuals->manual_status == 1 ? 'checked' : '' }}> <span class="switcher-indicator"></span>
                                <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                    </div><!-- /.card-body -->
                 
            </div><!-- /.card -->
            <div class="form-actions">
                <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                    บันทึก</button>
            </div><!-- /.form-actions -->
        </form>
        </div><!-- /.page-section -->
    </div><!-- /.page-inner -->
@endsection
