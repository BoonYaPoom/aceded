@extends('layouts.department.layout.departmenthome')
@section('contentdepartment')

@if (Session::has('message'))
<script>
  toastr.options ={
      "progressBar" : true,
      "positionClass" : 'toast-top-full-width',
      "extendedTimeOut " : 0,
      "timeOut" : 3000,
      "fadeOut" : 250,
      "fadeIn" : 250,
      "positionClass" : 'toast-top-right',
      

  } 
    toastr.success("{{ Session::get('message')}}");

</script>
@endif


    <div class="page-inner">
        <div class="page-section">
            <div class="card card-fluid">
                <div class="card-header bg-muted">หน่วยงาน /<a
                        href="{{ route('learn', ['department_id' => $depart->department_id]) }}">หมวดหมู่</a>/  จัดการใบประกาศ</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table w3-hoverable">
                            <thead>
                                <tr class="bg-infohead">
                                    <th class="align-middle" style="width:5%"> ลำดับ </th>
                                    <th class="align-middle" style="width:30%">หมวดหมู่ (ไทย) </th>
                                    <th class="align-middle" style="width:30%">หมวดหมู่ (อังกฤษ) </th>

                                    <th class="align-middle" style="width:5%">สถานะ</th>
                                    <th class="align-middle" style="width:5%">กระทำ</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <script>
                            $(document).ready(function() {
                                var table = $('#datatable').DataTable({

                                    lengthChange: false,
                                    responsive: true,
                                    info: true,
                                    pageLength: 20,
                                    language: {
                                        info: "ลำดับที่ _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                                        infoEmpty: "ไม่พบรายการ",
                                        infoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
                                        paginate: {
                                            first: "หน้าแรก",
                                            last: "หน้าสุดท้าย",
                                            previous: "ก่อนหน้า",

                                            next: "ถัดไป"
                                        }
                                    },

                                });


                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <header class="page-title-bar">
            <button type="button" class="btn btn-success btn-floated btn-add" onclick="window.location=''" data-toggle="tooltip"
                title="เพิ่ม"><span class="fas fa-plus"></span></button>
        </header>
    </div>
    
    
@endsection
