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
                    <a href="" style="text-decoration: underline;">จัดการหลักสูตร</a> / <a href=""
                        style="text-decoration: underline;">หมวดหมู่</a> / <i> {{ $subs->subject_th }}</i>
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
                                    <th class="align-middle" style="width:10%"> ลำดับ </th>
                                    <th class="align-middle" style="width:30%"> ชื่อ-สกุล </th>
                                    <th class="align-middle" style="width:30%"> หลักสูตร (อังกฤษ) </th>
                                    <th class="align-middle" style="width:15%"> จำนวน </th>
                                    <th class="align-middle" style="width:15%">กระทำ</th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                @php
                                    
                                    $subject_id = $subs->subject_id;
                                    
                                    $LogSub = \App\Models\Log::select('user_id') // Select only the user_id column
                                        ->where('subject_id', $subject_id)
                                    
                                        ->latest('logdate')
                                        ->get();
                                    $s = 1;
                                    $uniqueUserIds = [];
                                @endphp

                                @if ($LogSub)
                                    @foreach ($LogSub as $Log)
                                        @if (!in_array($Log->user_id, $uniqueUserIds))
                                            @php
                                                $users = \App\Models\Users::where('user_id', $Log->user_id)->first();
                                            @endphp
                                            <tr>
                                                <td>
                                                    {{ $s++ }}
                                                </td>
                                                <td>
                                                    {{ $users->firstname }}   {{ $users->lastname }}
                                                </td>
                                                <td>

                                                </td>
                                                <td>
                                                    0
                                                </td>

                                                <td class="align-middle">

                                                    <a href="" data-toggle="tooltip" title="ผู้เรียน"><i
                                                            class="fas fa-users fa-lg text-info "></i></a>
                                                    <a href="" data-toggle="tooltip" title="รายละเอียดหลักสูตร"><i
                                                            class="fas fa-list-ul fa-lg text-danger "></i></a>

                                                    <a href="" rel="รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย"
                                                        onclick="deleteRecord(event)" class="switcher-delete"
                                                        data-toggle="tooltip" title="ลบข้อมูล"><i
                                                            class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                                </td>
                                            </tr><!-- /tr -->
                                            @php
                                                $uniqueUserIds[] = $Log->user_id; // Add the user_id to the list of unique user_ids
                                            @endphp
                                        @endif
                                    @endforeach
                                @else
                                    <!-- Handle the case where no matching records were found for the specified subject_id -->
                                @endif

                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->


    </div><!-- /.page-inner -->
@endsection
