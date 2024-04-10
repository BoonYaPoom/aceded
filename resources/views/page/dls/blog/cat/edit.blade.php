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
                <div class="card-header bg-muted"> <a href="{{ route('dls', ['department_id' => $depart->department_id]) }}"
                        style="text-decoration: underline;"> จัดการข้อมูลและความรู้</a> / <a
                        href="{{ route('blogpage', ['department_id' => $depart]) }}" style="text-decoration: underline;">
                        คลังความรู้</a> / <a href="{{ route('blog', [$depart, 'category_id' => $blogcat->category_id]) }}"
                        style="text-decoration: underline;">{{ $blogcat->category_th }}</a> / <i> {{ $blogs->title }}</i>
                </div>
                <!-- /.card-header -->
                <form action="{{ route('updateblog', [$depart, 'blog_id' => $blogs]) }}" method="post"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <!-- .card-body -->
                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="title">ชื่อเรื่อง (ไทย)<span class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="ชื่อเรื่อง (ไทย)" required="" value="{{ $blogs->title }}">
                        </div><!-- /.form-group -->

                        @error('title')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror

                        <div class="form-group ">
                            <label for="detail">รายละเอียด (ไทย)</label>
                            <textarea class="editor" data-placeholder="รายละเอียด" data-height="200" name="detail">{{ html_entity_decode($blogs->detail, ENT_QUOTES, 'UTF-8') }}</textarea>
                        </div><!-- /.form-group -->
                       
                        @error('detail')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->

                        <div class="form-group">
                            <label for="blog_status">สถานะ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="blog_status" id="blog_status" value="1"> <span
                                    class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                    </div><!-- /.card-body -->

            </div><!-- /.card -->

            <!-- .form-actions -->
            <div class="form-actions">
                <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                    บันทึก</button>
            </div><!-- /.form-actions -->
            </form>
        </div><!-- /.page-section -->
    </div><!-- /.page-inner -->
@endsection
