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
                    <a href="{{route('bookpage', ['department_id' => $bookcat->department_id])}}" style="text-decoration: underline;">คลังข้อมูลและความรู้</a> / <a
                        href="{{ route('bookcatpage', [$depart,'category_id' => $books->category_id]) }}" style="text-decoration: underline;">
                        {{ $books->book_name }}</a> / <i> เพิ่มคลังข้อมูลและความรู้</i>
                </div><!-- /.card-header -->
                <!-- .card-body -->
                <form action="{{ route('updatecatbook', [$depart,'book_id' => $books]) }}" method="post"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="book_type">ประเภทหนังสือ</label>
                            <select id="book_type" name="book_type" class="form-control " \ data-toggle="select2"
                                data-placeholder="ประเภทหนังสือ" data-allow-clear="false">
                                <option value="0"> Flip Book</option>
                                <option value="1"> Pdf</option>
                            </select>
                        </div>
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="book_name">ชื่อหนังสือ <span class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" id="book_name" name="book_name"
                                placeholder="ชื่อหนังสือ" required="" value="{{ $books->book_name }}">
                        </div><!-- /.form-group -->
                        @error('book_name')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group  d-none">
                            <label for="book_author">ชื่อผู้แต่ง </label>
                            <input type="text" class="form-control" id="book_author" name="book_author"
                                placeholder="ชื่อผู้แต่ง" value="สำนักงาน ป.ป.ช.">
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group  d-none">
                            <label for="book_year">ปีที่พิมพ์ </label>
                            <input type="text" class="form-control" id="book_year" name="book_year"
                                placeholder="ปีที่พิมพ์" value="">
                        </div><!-- /.form-group -->

                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="cover"><img src="{{ asset($books->cover) }}" alt="{{ $books->cover }}"
                                    style="height:300px">
                        </div>
                        <div class="form-group">
                            <label for="cover">ภาพปก </label>
                            <input type="file" class="form-control" id="cover" name="cover" placeholder="ภาพปก"
                                accept="image/*"><small class="form-text text-muted">JPG, GIF or PNG 400x400, < 2
                                    MB.</small>
                        </div><!-- /.form-group -->
                        @error('cover')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="bookfile">เนื้อหา </label>
                            <input type="file" class="form-control" id="bookfile" name="bookfile" placeholder="เนื้อหา"
                                accept=".pdf">
                        </div><!-- /.form-group -->
                        @error('bookfile')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group  d-none">
                            <label for="detail">ข้อมูลทั่วไป</label>
                            <textarea class="editor" data-placeholder="ข้อมูลทั่วไป" data-height="200" name="detail"></textarea>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="contents">เนื้อหาโดยย่อ</label>
                            <textarea class="editor" data-placeholder="เนื้อหาโดยย่อ" data-height="200" name="contents"
                                value="{{ $books->contents }}">{{ $books->contents }}</textarea>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group  d-none">
                            <label for="recommended">แนะนำ </label>
                            <label class="switcher-control switcher-control-success switcher-control-lg">
                                <input type="checkbox" class="switcher-input" name="recommended" id="recommended"
                                    value="1">
                                <span class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span>
                            </label>
                        </div>
                        <!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group d-none">
                            <label for="book_member">เห็นเฉพาะสมาชิก </label>
                            <label class="switcher-control switcher-control-success switcher-control-lg">
                                <input type="checkbox" class="switcher-input" name="book_member" id="book_member"
                                    value="1">
                                <span class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span>
                            </label>
                        </div>
                        <!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="book_status">สถานะ </label>
                            <label class="switcher-control switcher-control-success switcher-control-lg">
                                <input type="checkbox" class="switcher-input" name="book_status" id="book_status"
                                    value="1">
                                <span class="switcher-indicator"></span> <span class="switcher-label-on">ON</span>
                                <span class="switcher-label-off text-red">OFF</span>
                            </label>
                        </div>
                        <!-- /.form-group -->
                    </div><!-- /.card-body -->
                    
            </div><!-- /.card -->
            <div class="form-actions">
                <button class="btn btn-lg btn-primary-theme ml-auto" type="submit"><i class="far fa-save"></i>
                    บันทึก</button>
            </div><!-- /.form-actions -->
        </form>
        </div><!-- /.page-section -->
    </div><!-- /.page-inner -->
@endsection
