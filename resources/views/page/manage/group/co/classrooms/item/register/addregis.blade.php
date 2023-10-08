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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .page-section -->
       <form action="{{ route('saveSelectedUsers', ['course_id' => $cour, 'm' => $m]) }}" method="POST">
            @csrf        
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted">
                    <a href="{{ route('learn', ['department_id' => $depart->department_id]) }}" style="text-decoration: underline;">หมวดหมู่</a>
                </div>
                <!-- /.card-header -->
                <!-- .nav-scroller -->
                <div class="nav-scroller border-bottom">
                    <!-- .nav -->
                    <div class="nav nav-tabs bg-muted h3">
                        <a class="nav-link active text-info" href="{{ route('class_page', ['course_id' => $cour->course_id]) }}"><i class="fas fa-users"></i>
                            ผู้เรียน รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย </a>
                    </div><!-- /.nav -->
                </div><!-- /.nav-scroller -->
                <!-- .card-body -->
                <div class="card-body">
                    <!-- .table-responsive -->
                    <div class="table-responsive">
                        <!-- .table -->
                        <table id="datatable" class="table w3-hoverable">
                            <!-- thead -->
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:5%"> ลำดับ </th>
                                    <th class="align-middle" style="width:10%"> รหัสผู้ใช้ </th>
                                    <th class="align-middle" style="width:15%"> ชื่อ-สกุล </th>
                                    <th class="align-middle" style="width:15%"> เลือก </th>

                                </tr>
                            </thead>
                            <!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                     
                                    @php $n = 1; @endphp
                                    @foreach ($filteredUsers as $u => $user)
                                        @if($user->user_role == 4)
                                            <tr>
                                                <td><a href="#">{{ $n++ }}</a></td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                                                <td><input type="checkbox" class="user-checkbox" name="selectedUsers[]" value="{{ $user->user_id }}"></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                  
                                
                                <script>
                                    $(function() {
                                        $("#checkall").click(function() {
                                            $('.custom-control-input').prop('checked', $(this).prop('checked'));
                                        });
                            
                                    });
                                </script>
                                <script>
                            

                                    $(document).ready(function() {
                                        var table = $('#datatable').DataTable({

                                            lengthChange: false,
                                            responsive: true,
                                            info: true,
                                            pageLength: 50,
                                            language: {
                                                info: "ลำดับที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                                infoEmpty: "ไม่พบรายการ",
                                                infoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
                                                paginate: {
                                                    first: "หน้าแรก",
                                                    last: "หน้าสุดท้าย",
                                                    previous: "ก่อนหน้า",

                                                    next: "ถัดไป"
                                                },
                                                emptyTable: "ไม่พบรายการแสดงข้อมูล"
                                            },
                                        });
                                    });
                                </script>
                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                    <button class="btn btn-lg btn-primary-theme ml-auto" type="submit"><i class="fa fa-user-plus"></i> เพิ่มผู้เรียน</button>
                </form>
              
            </div><!-- /.card -->
        </div><!-- /.page-section -->
        <!-- .page-title-bar -->
       
    </div><!-- /.page-inner -->
@endsection

          