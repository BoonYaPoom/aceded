@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <form action="{{ route('act1stores', ['department_id' => $depart, 'category_id' => $actCat]) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-header -->
                    <div class="card-header bg-muted"><a
                            href="{{ route('cop', ['department_id' => $depart, 'category_id' => $actCat]) }}"
                            style="text-decoration: underline;">กิจกกรรม</a> / <a
                            href="{{ route('activi', ['department_id' => $depart, 'category_id' => $actCat]) }}"
                            style="text-decoration: underline;">ชุมนุมนักปฏิบัติ </a> / <i>

                            <a href="{{ route('activiList', ['department_id' => $depart, 'category_id' => $actCat]) }}"
                                style="text-decoration: underline;">{{ $actCat->category_th }}</a>
                        </i></div>

                    <!-- .card-body -->
                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="title">ชื่อเรื่อง <span class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="ชื่อเรื่อง" required="" value="">
                        </div><!-- /.form-group -->

                  
                        <div class="form-group">
                            <label for="detail">เนื้อหาโดยย่อ</label>
                            <textarea class="editor" data-placeholder="รายละเอียด" data-height="200" name="detail" ></textarea>
                        </div><!-- /.form-group -->
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="flatpickr03">วันที่เริ่ม</label>
                                <input id="flatpickr03" name="startdate" value="" type="text"
                                    class="form-control startdate " data-toggle="flatpickr">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="flatpickr04">วันที่สิ้นสุด</label>
                                <input id="flatpickr04" name="enddate" value="" type="text"
                                    class="form-control enddate " data-toggle="flatpickr">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="activity_status">สถานะ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="activity_status" id="activity_status" value="1"> <span
                                    class="switcher-indicator"></span>
                                <span class="switcher-label-on">ON</span>
                                <span class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
                <div class="form-actions">
                    <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                        บันทึก</button>
                </div><!-- /.form-actions -->
                <!-- .form-actions -->
            </form>
        </div><!-- /.page-section -->

    </div><!-- /.page-inner -->
@endsection
