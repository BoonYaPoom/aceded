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

    <form action="{{route('class_update',[$depart,'class_id' => $class->class_id])}}" autocomplete="off" id="formclassroom"
        method="post" accept-charset="utf-8">
        @csrf
        @method('PUT')
        <div class="page-inner">
            <div class="page-section">
                <div class="card card-fluid">
                    <div class="card-header bg-muted">
                        <a href="" style="text-decoration: underline;">หมวดหมู่</a> / <a
                            href="{{ route('courpag', [$depart,'group_id' => $cour->group_id]) }}"
                            style="text-decoration: underline;">จัดการวิชา</a> / <i></i>
                    </div>
                    <!-- .nav-scroller -->
                    <div class="nav-scroller border-bottom">
                        <!-- .nav -->
                        <div class="nav nav-tabs bg-muted h3">
                            <a class="nav-link active text-info" href="{{ route('class_page', [$depart,'course_id' => $cour]) }}"><i
                                    class="fas fa-users"></i> ผู้เรียน รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย </a>
                        </div><!-- /.nav -->
                    </div><!-- /.nav-scroller -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="category_th">รุ่น/กลุ่มเรียน <span
                                    class="badge badge-warning">Required</span></label>
                            <input type="text" class="form-control" id="class_name" name="class_name"
                                placeholder="รุ่น/กลุ่มเรียน" required="" value="{{$class->class_name}}">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="amount">จำนวนผู้เรียน</label>
                            <select id="amount" name="amount" class="form-control " data-toggle="select2"
                                data-placeholder="จำนวนผู้เรียน" data-allow-clear="false">
                                <option value="0"> ไม่จำกัด</option>
                                @for ($i = 1; $i <= 500; $i++)
                                <option value="{{ $i }}" {{ $i == $class->amount ? 'selected' : '' }}> {{ $i }} </option>
                            @endfor
           
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="flatpickr03">วันที่เริ่ม</label>
                                <input id="flatpickr03" name="startdate" value="{{$class->startdate}}" type="text"
                                    class="form-control startdate " data-toggle="flatpickr">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="flatpickr04">วันที่สิ้นสุด</label>
                                <input id="flatpickr04" name="enddate" value="{{$class->enddate}}" type="text"
                                    class="form-control enddate " data-toggle="flatpickr">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="flatpickr05">วันประกาศผลการเรียน </label>
                                <input id="flatpickr05" name="announcementdate" value="{{$class->announcementdate}}" type="text"
                                    class="form-control startdate " data-toggle="flatpickr">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="flatpickr05">อายุใบประกาศนียบัตร(เดือน) </label>
                                <input type="number" class="form-control" id="ageofcert" name="ageofcert"
                                    placeholder="จำนวนเดือน" value="{{$class->ageofcert}}" min="0">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="class_status">สถานะ </label> <label
                                class="switcher-control switcher-control-success switcher-control-lg">
                                <input type="checkbox" class="switcher-input" name="class_status" id="class_status"
                                    value="1" > <span class="switcher-indicator"></span> <span
                                    class="switcher-label-on" >ON</span> <span
                                    class="switcher-label-off text-red">OFF</span></label>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn btn-lg btn-primary-theme ml-auto" type="submit"><i class="far fa-save"></i>
                        บันทึก</button>
                </div>
            </div>
        </div>
        </div>
        </div>
    </form>
@endsection
