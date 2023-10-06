@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid" >
                <div class="card-header bg-muted"><a href="{{ route('manage', ['department_id' => $category->department_id]) }}"
                    style="text-decoration: underline;">จัดการเว็บ</a> / <a href="{{ route('Webpage', ['department_id' => $category->department_id]) }}"
                    style="text-decoration: underline;">ข่าว/{{ $category->category_th }}</a> / <a
                    href="{{ route('catpage', ['category_id' => $category->category_id]) }}"
                    style="text-decoration: underline;">
                    กิจกรรม</a> / <i> เพิ่ม</i></div><!-- /.card-header -->


                <form action="{{ route('catstore', ['category_id' => $category]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- .card-body -->
                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="cover">ภาพปก </label> <input type="file" class="form-control" id="cover"
                                name="cover" placeholder="ภาพปก" accept="image/*">
                        </div><!-- /.form-group -->

                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="web_th">ชื่อข่าว/กิจกรรม (ไทย) <span
                                    class="badge badge-warning">Required</span></label> <input type="text"
                                class="form-control" id="web_th" name="web_th" placeholder="ชื่อข่าว/กิจกรรม (ไทย)"
                                required="" value="">
                        </div><!-- /.form-group -->
                        @error('web_th')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="web_en">ชื่อข่าว/กิจกรรม (อังกฤษ) </label> <input type="text"
                                class="form-control" id="web_en" name="web_en" placeholder="ชื่อข่าว/กิจกรรม (อังกฤษ)"
                                value="">
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
                            <label for="web_status">สถานะ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="web_status" id="web_status" value="1"> <span
                                    class="switcher-indicator"></span> <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                    </div><!-- /.card-body -->
                   
            </div><!-- /.card -->

        </div><!-- /.page-section -->
    </div><!-- /.page-inner -->
 <!-- .form-actions -->
 <div class="form-actions">
    <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
        บันทึก</button>
</div><!-- /.form-actions -->
</form>

    </div><!-- /.card -->
@endsection
