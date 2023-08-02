@extends('layouts.adminhome')
@section('content')
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
                    <a href="{{ route('courpag', ['group_id' => $cour->group_id]) }}"
                        style="text-decoration: underline;">หมวดหมู่ </a>/ จัดการหลักสูตร / {{$cour->course_th}}
                </div>
                <!-- .nav-scroller -->
                <div class="nav-scroller border-bottom">
                    <!-- .nav -->
                    <div class="nav nav-tabs bg-muted h3">
                        <a class="nav-link active text-info" href="{{ route('class_page', ['course_id' => $cour]) }}"><i
                                class="fas fa-users"></i>
                            ผู้เรียน รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย </a>
                    </div><!-- /.nav -->
                </div><!-- /.nav-scroller -->
                <div class="card-body">
                    <form method="post" id="formclassroom">
                        <div class="form-row">
                            <label for="selectyear text-center" class="col-md-4 w3-hide-small ">&nbsp;</label>
                            <div class="col-md-4">
                                <p>
                                    <select id="selectyear" name="selectyear" class="form-control " data-toggle="select2"
                                        data-placeholder="ปี" data-allow-clear="false"
                                        onchange="$('#formclassroom').submit();">
                                        <option value="2022"> 2022 </option>
                                        <option value="2023" selected> 2023 </option>
                                    </select>
                                </p>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table id="datatable2" class="table w3-hoverable">
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:10%"> ลำดับ </th>
                                    <th class="align-middle" style="width:70%"> เดือน </th>
                                    <th class="align-middle" style="width:10%"> จำนวนผู้เรียน </th>
                                    <th class="align-middle" style="width:10%"> กระทำ </th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr -->
                                @php
                                    $n = 0;
                                    
                                @endphp
                                @foreach ($month as $m => $months)
                                @foreach ($class as $c => $cc)
     
                                    @php
                                        $prefix=md5('moc'.date('Ymd'));
                                        $register = empty($result[$m]['register']) ? 0 : $result[$m]['register'];
                                        
                                    @endphp
                                    <tr id="{{$prefix}}'__course_class__class_status__class_id__'{{$c}}'__'{{$m}}'__row">
                                        <td><a>{{ $m }}</a></td>
                                        <td><a>{{ $months }}</a></td>
                                        <td>
                                            <a>{{ $register }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('register_page', [$m]) }}"><i
                                                    class="fas fa-user-plus fa-lg text-dark" data-toggle="tooltip"
                                                    title="รายชื่อลงทะเบียน"></i></a>
                                            <a href="{{ route('report_page', [$m]) }}"><i
                                                    class="fas fa-chart-bar fa-lg text-danger" data-toggle="tooltip"
                                                    title="รายงาน"></i></a>
                                            <a href="{{ route('congratuation_page', [$m]) }}"><i
                                                    class="fas fa-user-graduate fa-lg text-info" data-toggle="tooltip"
                                                    title="ผู้สำเร็จหลักสูตร"></i></a>


                                            <!--  -->

                                        </td>
                                    </tr><!-- /tr -->
                                @endforeach
                                @endforeach
             

                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div>
                </div>
                <header class="page-title-bar">
                    <input type="hidden" name="__id" id="__id" value="" />
                    <button type="button" class="btn btn-success btn-floated btn-add" id="add_classroomform"
                        data-toggle="tooltip" title="เพิ่ม"><span class="fas fa-plus"
                            onclick="window.location='{{ route('class_create', ['course_id' => $cour]) }}'"></span></button>

                </header>
            </div>
        </div>
    </div>
    </div>
@endsection
