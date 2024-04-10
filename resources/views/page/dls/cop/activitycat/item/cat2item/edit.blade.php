@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <!-- .page-inner -->
    <form action="{{ route('act2Update',[$depart,'activity_id' => $act->activity_id] ) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    <div class="page-inner">
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('cop', ['department_id' => $actCat->department_id]) }}"
                    style="text-decoration: underline;">กิจกกรรม</a> / <a href="{{ route('activi', ['department_id' => $actCat->department_id]) }}"
                    style="text-decoration: underline;">ชุมนุมนักปฏิบัติ </a> / <a href="{{ route($depart,'activiList' ,[$act->category_id]) }}"
                    style="text-decoration: underline;">{{ $act->title }}</a>
  
                  </div>
                <!-- .card-body -->
                <div class="card-body">
                    <!-- .form-group -->
                    <div class="form-group">
                        <label for="title">ชื่อเรื่อง <span class="badge badge-warning">Required</span></label> <input
                            type="text" class="form-control" id="title" name="title" placeholder="ชื่อเรื่อง"
                            required="" value="{{$act->title}}">
                    </div><!-- /.form-group -->
                    <div class="col-lg-10">
                            <video width="50%" id="videoplayer" controls="">
                                <source
                                src="{{ asset('uploads/' . $act->media) }}"
                                    alt="{{ $act->media }}" type="video/mp4"
                                    size="720" id="sourcevideo"
                                    class="sourcecontent">
                            </video>
                    </div>
                    <!-- .form-group -->
                    <div class="form-group ">
                        <label for="media">VDO </label> <input type="file" class="form-control" id="media"
                            name="media" placeholder="VDO" accept="video/mp4,video/x-m4v,video/*">
                    </div><!-- /.form-group -->
                    <!-- .form-group -->
                    <div class="form-group ">
                        <label for="detail">รายละเอียด </label>
                        <textarea class="editor" data-placeholder="รายละเอียด" data-height="200" name="detail">{{  html_entity_decode($act->detail, ENT_QUOTES, 'UTF-8') }}</textarea>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                        <label for="activity_status">สถานะ </label> <label
                            class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                class="switcher-input" name="activity_status" id="activity_status" value="1"> <span
                                class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                class="switcher-label-off text-red">OFF</span></label>
                    </div><!-- /.form-group -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->

            <!-- .form-actions -->
            <div class="form-actions">
                <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i> บันทึก</button>
            </div><!-- /.form-actions -->
        </div><!-- /.page-section -->
    </div><!-- /.page-inner -->
    </form>
@endsection
