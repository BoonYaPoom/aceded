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
                <div class="card-header bg-muted">
                    <a href="{{ route('bookpage') }}" style="text-decoration: underline;">จัดการข้อมูลและความรู้</a> /
                    <i>แก้ไขหมวดหมู่/{{ $book->category_th }}</i>
                </div>


                <form action="{{ route('bookupdate', ['category_id' => $book->category_id]) }}" method="post"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group d-none">
                            <label for="category_type">ประเภทหมวด</label>
                            <select id="category_type" name="category_type" class="form-control " data-toggle="select2"
                                data-placeholder="ประเภทหมวด" data-allow-clear="false">
                                <option value="1"> คลังข้อมูลและความรู้</option>
                            </select>
                        </div>
                        <!-- /.form-group -->

                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="category_th">ชื่อหมวด (ไทย) <span
                                    class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" id="category_th" name="category_th"
                                placeholder="ชื่อหมวด (ไทย)" required="" value="{{ $book->category_th }}">
                        </div>
                        <!-- /.form-group -->
                        @error('category_th')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="category_en">ชื่อหมวด (อังกฤษ) </label>
                            <input type="text" class="form-control" id="category_en" name="category_en"
                                placeholder="ชื่อหมวด (อังกฤษ)" value="{{ $book->category_en }}">
                        </div>
                        <!-- /.form-group -->

                        <!-- .form-group -->
                        <div class="form-group"><label for="cover">ภาพปก </label>
                            <input type="file" class="form-control" id="cover" name="cover" placeholder="ภาพปก"
                                accept="image/*">
                        </div> <!-- /.form-group -->
                        <div class="form-group">
                            <label for="cover"><img src="{{ Storage::disk('external')->url('BookCategory/' . $book->cover) }}" alt="{{ $book->cover }}"
                                    style="height:300px ">
                        </div>
                        @error('cover')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group d-none">
                            <label for="detail_th">รายละเอียด (ไทย)</label>
                            <textarea class="ckeditor" data-placeholder="รายละเอียด (ไทย)" data-height="200" name="detail_th"></textarea>
                        </div>
                        <!-- /.form-group -->

                        <!-- .form-group -->
                        <div class="form-group d-none">
                            <label for="detail_en">รายละเอียด (อังกฤษ)</label>
                            <textarea class="ckeditor" data-placeholder="รายละเอียด (อังกฤษ)" data-height="200" name="detail_en"></textarea>
                        </div>
                        <!-- /.form-group -->

                        <!-- .form-group -->
                        <div class="form-group d-none">
                            <label for="recommended">แนะนำ </label>
                            <label class="switcher-control switcher-control-success switcher-control-lg">
                                <input type="checkbox" class="switcher-input" name="recommended" id="recommended"
                                    value="1">
                                <span class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div>
                        <!-- /.form-group -->
                        <div class="form-group">
                            <label for="category_status">สถานะ </label>
                            <label class="switcher-control switcher-control-success switcher-control-lg">
                                <input type="checkbox" class="switcher-input" name="category_status" id="category_status"
                                    value="1">
                                <span class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div>
                        <!-- /.form-group -->
                    </div>

            </div>
            <!-- /.card -->
            <!-- .form-actions -->
            <div class="form-actions">
                <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                    บันทึก</button>
            </div>
            <!-- /.form-actions -->
            </form>
        </div>
        <!-- /.page-section -->
    </div>
    <!-- /.page-inner -->
@endsection
