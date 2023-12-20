@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <form action="{{ route('act1store', [$depart, 'category_id' => $actCat->category_id]) }}" autocomplete="off" id="formnews"
        enctype="multipart/form-data" method="post" accept-charset="utf-8">
        <input type="hidden" name="__csrf_token_name" value="c4dd375d617e78d25f83e498dd205900" />
        <!-- .page-inner -->
        <div class="page-inner">
            <!-- .form -->
            <!-- .page-section -->
            <div class="page-section">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-header -->
                    <div class="card-header bg-muted"><a
                            href="{{ route('cop', ['department_id' => $actCat->department_id]) }}"
                            style="text-decoration: underline;">กิจกรรม</a> / <a
                            href="{{ route('activi', ['department_id' => $actCat->department_id]) }}"
                            style="text-decoration: underline;">ชุมนุมนักปฏิบัติ</a> /<i> แก้ไขหมวดหมู่</i>
                    </div>
                    <!-- /.card-header -->

                    <!-- .card-body -->
                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="category_th">ชื่อหมวด (ไทย) <span
                                    class="badge badge-warning">Required</span></label> <input type="text"
                                class="form-control" id="category_th" name="category_th" placeholder="ชื่อหมวด (ไทย)"
                                required="" value="ห้องประชุม">
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="category_en">ชื่อหมวด (อังกฤษ) </label> <input type="text" class="form-control"
                                id="category_en" name="category_en" placeholder="ชื่อหมวด (อังกฤษ)" value="Meeting Room">
                        </div><!-- /.form-group --> <!-- .form-group -->
                        <div class="form-group">
                            <label for="cover"><img src="{{ asset('lac/cover.png') }}">
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="cover">ภาพปก </label> <input type="file" class="form-control" id="cover"
                                name="cover" placeholder="ภาพปก" accept="image/*">
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="detail_th">รายละเอียด (ไทย)</label>
                            <textarea class="editor" data-placeholder="รายละเอียด (ไทย)" data-height="200" name="detail_th"></textarea>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="detail_en">รายละเอียด (อังกฤษ)</label>
                            <textarea class="editor" data-placeholder="รายละเอียด (อังกฤษ)" data-height="200" name="detail_en"></textarea>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="recommended">แนะนำ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="recommended" id="recommended" value="1"> <span
                                    class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="category_status">สถานะ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="category_status" id="category_status" value="1"
                                    checked> <span class="switcher-indicator"></span> <span
                                    class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                    </div><!-- /.card-body -->
                </div><!-- /.card -->

                <!-- .form-actions -->
                <div class="form-actions">
                    <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                        บันทึก</button>
                </div><!-- /.form-actions -->
            </div><!-- /.page-section -->
        </div><!-- /.page-inner -->

        </div><!-- /.page -->
        </div><!-- .app-footer -->
    </form><!-- /.form -->
@endsection
