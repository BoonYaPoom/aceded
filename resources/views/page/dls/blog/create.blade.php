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
                <div class="card-header bg-muted"><a href="{{ route('dls') }}"
                        style="text-decoration: underline;">จัดการข้อมูลและความรู้</a> / <a
                        href="{{ route('blogpage') }}"
                        style="text-decoration: underline;">คลังความรู้</a> / <i> เพิ่มหมวดหมู่</i></div>
                <!-- /.card-header -->

                <form action="{{ route('storeblogcat') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- .card-body -->
                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="category_th">ชื่อหมวด (ไทย) </label> <input type="text" class="form-control"
                                id="category_th" name="category_th" placeholder="ชื่อหมวด (ไทย)" value="">
                        </div><!-- /.form-group -->
                        @error('category_th')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="category_en">ชื่อหมวด (อังกฤษ) </label> <input type="text" class="form-control"
                                id="category_en" name="category_en" placeholder="ชื่อหมวด (อังกฤษ)" value="">
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label for="cover">ภาพปก </label> <input type="file" class="form-control" id="cover"
                                name="cover" placeholder="ภาพปก" accept="image/*">
                        </div><!-- /.form-group -->

                        <!-- .form-group -->
                        <div class="form-group d-none">
                            <label for="detail_th">รายละเอียด (ไทย)</label>
                            <textarea class="ckeditor" data-placeholder="รายละเอียด (ไทย)" data-height="200" name="detail_th"></textarea>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group d-none">
                            <label for="detail_en">รายละเอียด (อังกฤษ)</label>
                            <textarea class="ckeditor" data-placeholder="รายละเอียด (อังกฤษ)" data-height="200" name="detail_en"></textarea>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group d-none">
                            <label for="recommended">แนะนำ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="recommended" id="recommended" value="1"> <span
                                    class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
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
