@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <div class="card-header bg-muted"><a href="{{ route('manage', ['department_id' => $depart]) }}"
                        style="text-decoration: underline;">จัดการเว็บ</a> / <a
                        href="{{ route('linkpage', ['department_id' => $depart]) }}"
                        style="text-decoration: underline;">ลิงค์ที่น่าสนใจ</a> </div><!-- /.card-header -->
                <form action="{{ route('storelink', ['department_id' => $depart]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- .card-body -->
                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="cover">ภาพปก </label>
                            <input type="file" class="form-control" name="cover" placeholder="ภาพปก" accept="image/*">
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="links_title">ลิงค์ที่น่าสนใจ <span class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" name="links_title" placeholder="ลิงค์ที่น่าสนใจ"
                                required="" value="">
                        </div><!-- /.form-group -->
                        @error('links_title')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="links">URL <span class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" name="links" placeholder="ลิงค์ที่น่าสนใจ"
                                required="" value="">
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        @error('links')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-actions -->
                        <div class="form-group">
                            <label for="links_status">สถานะ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="links_status" id="links_status" value="1"
                                   > <span class="switcher-indicator"></span>
                                <span class="switcher-label-on">ON</span> <span
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
