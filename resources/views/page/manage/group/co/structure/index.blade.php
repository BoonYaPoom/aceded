@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')
    @if (Session::has('message'))
        <script>
            toastr.options = {
                "progressBar": true,
                "positionClass": 'toast-top-full-width',
                "extendedTimeOut ": 0,
                "timeOut": 3000,
                "fadeOut": 250,
                "fadeIn": 250,
                "positionClass": 'toast-top-right',


            }
            toastr.success("{{ Session::get('message') }}");
        </script>
    @endif
 
    <form action="{{ route('update_structure', ['course_id' => $cour->course_id]) }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="page-inner">
            <!-- .form -->
            <!-- .page-section -->
            <div class="page-section">
                <!-- .card -->
                <div class="card card-fluid">
                    <!-- .card-header -->
                    <div class="card-header bg-muted">
                        <a href="{{ route('learn', ['department_id' => $courses->first()->department_id]) }}"
                            style="text-decoration: underline;">จัดการหลักสูตร</a> / <a
                            href="{{ route('courgroup', ['department_id' => $courses->first()->department_id]) }}"
                            style="text-decoration: underline;">หมวดหมู่</a> / <a
                            href="{{ route('courpag', ['group_id' => $cour->group_id]) }}"
                            style="text-decoration: underline;">

                            {{ $courses->group_th }}

                        </a> /
                        <i> {{ $cour->course_th }}</i>
                    </div><!-- /.card-header -->

                    <!-- .card-body -->
                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="description">คำอธิบายหลักสูตร (ไทย)</label>
                            <textarea class="editor" data-placeholder="คำอธิบายหลักสูตร" data-height="200" name="description_th">
                                {{ $cour->description_th }}</textarea>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="description">คำอธิบายหลักสูตร (อังกฤษ)</label>
                            <textarea class="editor" data-placeholder="คำอธิบายหลักสูตร" data-height="200" name="description_en">
                                {{ $cour->description_en }}</textarea>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="objectives">วัตถุประสงค์การเรียนรู้ (ไทย)</label>
                            <textarea class="editor" data-placeholder="วัตถุประสงค์การเรียนรู้" data-height="200" name="objectives_th">
                                    {{ $cour->objectives_th }}</textarea>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="objectives">วัตถุประสงค์การเรียนรู้ (อังกฤษ)</label>
                            <textarea class="editor" data-placeholder="วัตถุประสงค์การเรียนรู้" data-height="200" name="objectives_en">   
                                 {{ $cour->objectives_en }}</textarea>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="qualification">คุณสมบัติผู้เข้าอบรม (ไทย)</label>
                            <textarea class="editor" data-placeholder="คุณสมบัติผู้เข้าอบรม" data-height="200" name="qualification_th">
                                    {{ $cour->qualification_th }}</textarea>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="qualification">คุณสมบัติผู้เข้าอบรม (อังกฤษ)</label>
                            <textarea class="editor" data-placeholder="คุณสมบัติผู้เข้าอบรม" data-height="200" name="qualification_en"> 
                                   {{ $cour->qualification_en }}</textarea>
                        </div><!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="evaluation">การประเมินผล (ไทย)</label>
                            <textarea class="editor" data-placeholder="การประเมินผล" data-height="200" name="evaluation_th">   
                                 {{ $cour->evaluation_th }}</textarea>
                        </div><!-- /.form-group -->
                        <div class="form-group">
                            <label for="evaluation">การประเมินผล (อังกฤษ)</label>
                            <textarea class="editor" data-placeholder="การประเมินผล" data-height="200" name="evaluation_en">  
                                  {{ $cour->evaluation_en }}</textarea>
                        </div><!-- /.form-group -->
                    </div><!-- /.card-body -->
                </div><!-- /.card -->

                <!-- .form-actions -->
                <div class="form-actions ">
                    <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                        บันทึก</button>
                </div><!-- /.form-actions -->
            </div><!-- /.page-section -->
        </div><!-- /.page-inner -->

  


    </form>
@endsection
