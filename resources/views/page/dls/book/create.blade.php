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
                        href="{{route('bookpage', ['department_id' => $depart])}}"
                        style="text-decoration: underline;"> หนังสืออิเล็กทรอนิกส์</a> /
                    <i>เพิ่มหมวดหมู่</i>
                </div>


                <form action="{{ route('storebook', ['department_id' => $depart]) }}" method="post"
                    enctype="multipart/form-data">
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
                                placeholder="ชื่อหมวด (ไทย)" required="" value="">
                        </div>
                        <!-- /.form-group -->
                        @if ($errors->has('category_th'))
                            <span class="badge badge-warning">{{ $errors->first('category_th') }}</span>
                        @endif



                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="category_en">ชื่อหมวด (อังกฤษ) <span
                                    class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" id="category_en" name="category_en"
                                placeholder="ชื่อหมวด (อังกฤษ)" value="" required="">
                        </div>
                        <!-- /.form-group -->



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
