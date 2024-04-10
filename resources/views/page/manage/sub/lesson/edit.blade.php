@extends('page.manage.sub.navsubject')
@section('subject-data')

                <form action="{{ route('update_lessonform', [$depart,$subs,'lesson_id' => $lessons]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="lesson_number">ลำดับ </label> <input type="text" class="form-control"
                                 name="lesson_number" placeholder="ลำดับ" value="{{$lessons->lesson_number}}">
                        </div>
                        <!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="lesson_th">ชื่อเรื่อง (ไทย) <span
                                    class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" id="lesson_th" name="lesson_th"
                                placeholder="ชื่อเรื่อง (ไทย)" required="" value="{{$lessons->lesson_th}}">
                        </div>
                        <!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="lesson_en">ชื่อเรื่อง (อังกฤษ) </label> <input type="text" class="form-control"
                                 name="lesson_en" placeholder="ชื่อเรื่อง (อังกฤษ)" value="{{$lessons->lesson_en}}">
                        </div>
                        <!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group d-none">
                            <label for="description">คำอธิบายบทเรียน</label>
                            <textarea class="editor" data-placeholder="คำอธิบายบทเรียน" data-height="200" name="description"></textarea>
                        </div>
                        <!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label for="resultlesson">สิ่งที่ได้รับจากบทเรียน</label>
                            <textarea class="editor" data-placeholder="สิ่งที่ได้รับจากบทเรียน" data-height="200" name="resultlesson"> {{  html_entity_decode($lessons->resultlesson , ENT_QUOTES, 'UTF-8') }}</textarea>
                        </div>
                        <!-- /.form-group -->
                        <!-- .form-group -->
                        <div class="form-group">
                            <label class="control-label" for="content_type">รูปแบบบทเรียน(ชนิดสื่อ)</label>
                            <select  name="content_type" class="form-control" data-toggle="select2"
                                data-placeholder="ชนิดสื่อ" data-allow-clear="false">
                                @foreach ($content_types as $content_type)
                                    <option value="{{ $content_type->content_type }}"   {{ $content_type->content_type == $lessons->content_type ? 'selected' : '' }}>{{ $content_type->content_th }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
               
                        <div class="form-group">
                            <label for="lesson_status">สถานะหัวข้อ </label>
                            <label class="switcher-control switcher-control-success switcher-control-lg">
                                <input type="checkbox" class="switcher-input" name="lesson_status"
                                 {{ $lessons->lesson_status == 1 ? 'checked' : '' }} value="1">  
                                 <span class="switcher-indicator"></span>
                                <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div>
                  
                        <div class="form-group">
                            <label for="exercise">แบบฝึกหัดท้ายบท </label>
                            <label class="switcher-control switcher-control-success switcher-control-lg">
                                <input type="checkbox" class="switcher-input" name="exercise"  
                                {{ $lessons->exercise == 1 ? 'checked' : '' }} value="1">
                                <span class="switcher-indicator"></span>
                                <span class="switcher-label-on">ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div>
                        <!-- /.form-group -->
                        <!-- .fieldset -->

                        <div class="form-actions ">
                            <button class="btn btn-lg btn-primary-theme ml-auto" type="submit"><i class="far fa-save"></i>
                                บันทึก</button>
                        </div><!-- /.form-actions -->
                    </div><!-- /.card-body -->

        </form>
       
@endsection
