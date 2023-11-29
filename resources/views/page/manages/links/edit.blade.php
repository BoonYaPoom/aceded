@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid" >
                <div class="card-header bg-muted"><a href="{{ route('manage', ['department_id' => $links->department_id]) }}"
                  style="text-decoration: underline;">จัดการเว็บ</a> / <a
                  href="{{ route('linkpage', ['department_id' => $links->department_id]) }}"
                        style="text-decoration: underline;">ลิงค์ที่น่าสนใจ</a> / {{ $links->links_title }}</div><!-- /.card-header -->
                <form action="{{ route('updatelink', ['department_id' => $depart,'links_id' => $links->links_id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- .card-body -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="cover"><img src="{{ asset($links->cover) }} " style="width:50%"
                                    alt="{{ $links->cover }}">
                        </div>
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="cover">ภาพปก </label>
                            <input type="file" class="form-control" name="cover" placeholder="ภาพปก" accept=" image/jpeg, image/png"
                                value="{{ $links->cover }}">
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="links_title">ลิงค์ที่น่าสนใจ </label>
                            <input type="text" class="form-control" name="links_title" placeholder="ลิงค์ที่น่าสนใจ"
                                required="" value="{{ $links->links_title }}">
                        </div><!-- /.form-group -->
                        @error('links_title')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="links">URL </label>
                            <input type="text" class="form-control" name="links" placeholder="ลิงค์ที่น่าสนใจ"
                                required="" value="{{ $links->links }}">
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        @error('links')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                    
                        <div class="form-group">
                            <label for="links_status">สถานะ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg"><input type="checkbox"
                                    class="switcher-input" name="links_status" id="links_status" value="1"
                                    {{ $links->links_status == 1 ? 'checked' : '' }}> <span class="switcher-indicator"></span>
                                <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div><!-- /.form-group -->
                    </div><!-- /.card-body -->

   
            </div><!-- /.card -->
                <!-- .form-actions -->
                <div class="form-actions">
                    <input type="hidden" name="hidden_id" value="">
                    <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                        บันทึก</button>
                </div><!-- /.form-actions -->
        </form>

        </div><!-- /.page-section -->
    </div><!-- /.page-inner -->
@endsection
