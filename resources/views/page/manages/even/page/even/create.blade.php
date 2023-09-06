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
                <div class="card-header bg-muted"><a href="{{ route('manage', ['department_id' => $depart]) }}"
                        style="text-decoration: underline;">จัดการเว็บ</a> / <a href="{{ route('Webpage', ['department_id' => $depart]) }}"
                            style="text-decoration: underline;">ข่าว/กิจกรรม</a> / <a href="{{ route('evenpage', ['department_id' => $depart]) }}"
                                style="text-decoration: underline;">ข่าว</a> / <i> เพิ่มหมวดข่าว</i></div>
                <!-- /.card-header -->

                <!-- .card-body -->
                <div class="card-body">
                    <form action="{{ route('evenstore', ['department_id' => $depart]) }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="category_th">ชื่อหมวด (ไทย) </label>
                            <input type="text" class="form-control" name="category_th" placeholder="ชื่อหมวด (ไทย)"
                                required="" value="">
                        </div><!-- /.form-group -->
                        <div class="my-2"></div>
                        @error('category_th')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <label for="category_en">ชื่อหมวด (อังกฤษ) </label>
                            <input type="text" class="form-control" name="category_en" placeholder="ชื่อหมวด (อังกฤษ)"
                                value="">
                        </div><!-- /.form-group -->


                        <div class="form-group">
                            <label for="cover">ภาพปก </label>
                            <input type="file" class="form-control" accept="image/*" name="cover" placeholder="ภาพปก">

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
    @endsection
