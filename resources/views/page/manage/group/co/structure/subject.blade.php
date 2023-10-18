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


    <!-- .page-inner -->
    <div class="page-inner">

        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted">
                    <a href="{{ route('learn', [$courses->department_id]) }}"
                        style="text-decoration: underline;">จัดการหลักสูตร</a> / <a
                        href="{{ route('courgroup', [$courses->department_id]) }}"
                        style="text-decoration: underline;">หมวดหมู่</a> / <i>{{ $courses->group_th }}</i>
                </div><!-- /.card-header -->
                <!-- .card-body -->
                <div class="card-body">

                    <!-- .table-responsive -->
                    <div class="table-responsive">
                        <!-- .table -->
                        <table id="datatable2" class="table w3-hoverable">
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:10%"> รหัสหลักสูตร </th>
                                    <th class="align-middle" style="width:30%"> หลักสูตร (ไทย) </th>
                                    <th class="align-middle" style="width:30%"> หลักสูตร (อังกฤษ) </th>
                                    <th class="align-middle" style="width:15%"> จำนวน </th>
                                    <th class="align-middle" style="width:15%">กระทำ</th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                @php
                                    
                                    $subjects = $cour->subject;
                                    $jsonsubject = json_decode($subjects, true);
                                    
                                    $dataSubject = collect($jsonsubject);
                                    $s = 1;
                                @endphp
                                @foreach ($dataSubject as $sub)
                                    @php
                                        
                                        $subs = \App\Models\CourseSubject::where('subject_id', $sub)->first();
                                        
                                    @endphp

                                    <tr>
                                        <td>
                                            {{ $s++ }}
                                        </td>
                                        <td>
                                            {{ $subs->subject_th }}
                                        </td>
                                        <td>
                                            {{ $subs->subject_en }}
                                        </td>
                                        <td>
                                           0
                                        </td>

                                        <td class="align-middle">
                                           
                                            <a href="{{ route('subjecClass_page', [$depart,'subject_id' => $subs]) }}"
                                                data-toggle="tooltip" title="ผู้เรียน"><i
                                                    class="fas fa-users fa-lg text-info "></i></a>
                                            <a href=""
                                                data-toggle="tooltip" title="รายละเอียดหลักสูตร"><i
                                                    class="fas fa-list-ul fa-lg text-danger "></i></a>
                                           
                                            <a href=""
                                                rel="รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย"
                                                onclick="deleteRecord(event)" class="switcher-delete" data-toggle="tooltip"
                                                title="ลบข้อมูล"><i class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                        </td>
                                    </tr><!-- /tr -->
                                @endforeach
                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->


    </div><!-- /.page-inner -->
@endsection
