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
                        style="text-decoration: underline;">จัดการเว็บ</a> / <i> แก้หมวดข่าว/กิจกรรม{{ $wed->category_th }}</i></div>
                <!-- /.card-header -->

                <!-- .card-body -->
                <div class="card-body">
                    <form method="POST" action="{{ route('updateeven', ['category_id' => $wed->category_id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="category_th">ชื่อหมวด (ไทย) </label>
                            <input type="text" class="form-control" name="category_th" placeholder="ชื่อหมวด (ไทย)"
                                required="" value="{{ $wed->category_th }}">
                        </div><!-- /.form-group -->
                        <div class="my-2"></div>
                        @error('category_th')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="category_en">ชื่อหมวด (อังกฤษ) </label>
                            <input type="text" class="form-control" name="category_en" placeholder="ชื่อหมวด (อังกฤษ)"
                                value="{{ $wed->category_en }}">
                        </div><!-- /.form-group -->

                        <div class="form-group">
                            <label for="cover">ภาพปก </label>
                            <input type="file" class="form-control" accept="image/*" name="cover" placeholder="ภาพปก"
                                value="{{ $wed->cover }}">

                        </div><!-- /.card-body -->
                        <div class="form-group">
                            <label for="cover"><img src="{{ Storage::disk('external')->url('webcategory/' . $wed->cover) }}" alt="{{ $wed->cover }}"
                                    style="height:400px">
                        </div>
                </div><!-- /.card -->

              
            </div><!-- /.page-section -->
        </div><!-- /.page-inner -->
          <!-- .form-actions -->
          <div class="form-actions">
            <input type="hidden" name="hidden_id" value="">
            <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                บันทึก</button>
        </div><!-- /.form-actions -->
        </form>
    @endsection
