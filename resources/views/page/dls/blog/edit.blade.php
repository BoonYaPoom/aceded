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
                <div class="card-header bg-muted">
                    <a href="{{ route('dls', ['department_id' => $depart->department_id]) }}"
                        style="text-decoration: underline;"> จัดการข้อมูลและความรู้</a> / <a
                        href="{{ route('blogpage', ['department_id' => $depart]) }}" style="text-decoration: underline;">
                        คลังความรู้</a> / {{ $blogcat->category_th }} แก้ไขหมวดหมู่</a>
                </div>
                <!-- /.card-header -->

                <form action="{{ route('updateblogcat', [$depart, 'category_id' => $blogcat->category_id]) }}" method="post"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <!-- .card-body -->
                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="category_th">ชื่อหมวด (ไทย) </label> <input type="text" class="form-control"
                                id="category_th" name="category_th" placeholder="ชื่อหมวด (ไทย)" required=""
                                value="{{ $blogcat->category_th }}">
                        </div><!-- /.form-group -->
                        @error('category_th')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="category_en">ชื่อหมวด (อังกฤษ) </label> <input type="text" class="form-control"
                                id="category_en" name="category_en" placeholder="ชื่อหมวด (อังกฤษ)"
                                value="{{ $blogcat->category_en }}">
                        </div><!-- /.form-group -->
                        @error('category_en')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <label for="category_status">สถานะ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="category_status" id="category_status" value="1"> <span
                                    class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
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
