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
    <div class="page-inner">
        <div class="page-section">
            <div class="card card-fluid">
                <div class="card-header bg-muted">
                    <a href="{{ route('courpag', [$depart,'group_id' => $cour->group_id]) }}"
                        style="text-decoration: underline;">หมวดหมู่ </a>/ จัดการหลักสูตร / {{$cour->course_th}}
                </div>
                <!-- .nav-scroller -->
                <div class="nav-scroller border-bottom">
                    <!-- .nav -->
                    <div class="nav nav-tabs bg-muted h3">
                        <a class="nav-link active text-info" href="{{ route('class_page', [$depart,'course_id' => $cour]) }}"><i
                                class="fas fa-users"></i>
                            ผู้เรียน รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย </a>
                    </div><!-- /.nav -->
                </div><!-- /.nav-scroller -->
              
                    @if($cour->learn_format  ==  0)
                    @include('page.manage.group.co.classrooms.classroom0.classroom0')
                    @elseif($cour->learn_format  == 1)
                    @include('page.manage.group.co.classrooms.classroom1.classroom1')
                    @endif


            
                      <header class="page-title-bar">
                    <input type="hidden" name="__id" id="__id" value="" />
                    <button type="button" class="btn btn-success btn-floated btn-add" id="add_classroomform"
                        data-toggle="tooltip" title="เพิ่ม"><span class="fas fa-plus"
                            onclick="window.location='{{ route('class_create', [$depart,'course_id' => $cour]) }}'"></span></button>

                </header> 
            </div>
        </div>
    </div>
    </div>
@endsection
