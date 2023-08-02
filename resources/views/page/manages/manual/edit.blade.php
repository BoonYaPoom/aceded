@extends('layouts.adminhome')
@section('content')
    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('manage') }}"
                        style="text-decoration: underline;">จัดการเว็บ</a> / <a href="{{ route('manualpage') }}"
                        style="text-decoration: underline;">แก้ไขคู่มือใช้งาน</a> / <i> {{ $manuals->manual }}</i></div>
                <!-- /.card-header -->
                <!-- .card-body -->
                <form action="{{ route('updatemanual', ['manual_id' => $manuals->manual_id]) }}" method="post"
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
                                <label for="cover"><img src="{{ Storage::disk('external')->url('Manual/image/' . $manuals->cover) }}"
                                        alt="{{ $manuals->cover }}">
                            </div>
                            <label for="cover">ภาพปก </label> <input type="file" class="form-control" name="cover"
                                placeholder="ภาพปก" accept="image/*">
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="manual_path">ไฟล์คู่มือใช้งาน </label>
                            <input type="file" class="form-control" name="manual_path" placeholder="ไฟล์คู่มือใช้งาน"
                                required="" accept=".doc,.docx,.xls,.xlsx,.pdf,.ppt,.pptx">
                        </div><!-- /.form-group -->
                        @error('manual_path')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                       
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
