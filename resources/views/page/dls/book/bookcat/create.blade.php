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
                        href="{{ route('bookpage', ['department_id' => $depart]) }}" style="text-decoration: underline;">
                        หนังสืออิเล็กทรอนิกส์</a> / <a
                        href="{{ route('bookcatpage', [$depart, 'category_id' => $bookcat->category_id]) }}"
                        style="text-decoration: underline;"> {{ $bookcat->category_th }}</a> / <i>
                        เพิ่มคลังข้อมูลและความรู้</i>
                </div><!-- /.card-header -->
                <!-- .card-body -->
                <form action="{{ route('bookcatstore', [$depart, 'category_id' => $bookcat]) }}" method="post"
                    enctype="multipart/form-data">
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
                                placeholder="ชื่อหนังสือ" required="" value="">
                        </div><!-- /.form-group -->
                        @error('book_name')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group ">
                            <label for="book_author">ชื่อผู้แต่ง </label>
                            <input type="text" class="form-control" id="book_author" name="book_author"
                                placeholder="ชื่อผู้แต่ง" value="">
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="cover">ภาพปก <span class="badge badge-warning">Required</span></label>
                            <input type="file" class="form-control" id="cover" name="cover" placeholder="ภาพปก"
                                accept=" image/jpeg, image/png" required=""><small class="form-text text-muted">JPG, GIF
                                or PNG 400x400, < 2 MB.</small>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="bookfile">เนื้อหา <span class="badge badge-warning">Required</span></label>
                            <input type="file" class="form-control" id="bookfile" name="bookfile" placeholder="เนื้อหา"
                                accept=".pdf" required="">
                        </div><!-- /.form-group -->
                        <!-- .form-group -->

                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="contents">เนื้อหาโดยย่อ</label>
                            <textarea class="editor" data-placeholder="เนื้อหาโดยย่อ" data-height="200" name="contents"></textarea>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="recommended">หนังสือแนะนำ </label>
                            <label class="switcher-control switcher-control-success switcher-control-lg">
                                <input type="checkbox" class="switcher-input" name="recommended" id="recommended"
                                    value="1">
                                <span class="switcher-indicator"></span> <span class="switcher-label-on">ON</span>
                                <span class="switcher-label-off text-red">OFF</span>
                            </label>
                        </div>

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
