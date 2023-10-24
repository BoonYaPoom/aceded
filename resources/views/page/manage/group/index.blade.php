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
                        href="{{ route('learn', ['department_id' => $depart->department_id]) }}">หมวดหมู่</a>/  จัดการหลักสูตร</div>
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

                                @foreach($courses as $index => $item)
                                @php
                                    $indexnum = $index +1 ;
                                @endphp
                                <tr>
                                    <td><a href="#">{{$indexnum }}</a></td>
                                    <td><a href="{{ route('courpag', [$depart,'group_id' => $item->group_id]) }}">{{$item->group_th}}</a></td>
                                    <td><a href="{{ route('courpag', [$depart,'group_id' => $item->group_id]) }}">{{$item->group_en}}</a></td>

                                    <td class="align-middle"> <label
                                        class="switcher-control switcher-control-success switcher-control-lg">
                                        <input type="checkbox" class="switcher-input switcher-edit"
                                            {{ $item->group_status == 1 ? 'checked' : '' }}
                                            data-group-id="{{ $item->group_id }}">
                                        <span class="switcher-indicator"></span>
                                        <span class="switcher-label-on">ON</span>
                                        <span class="switcher-label-off text-red">OFF</span>
                                    </label></td>
                  
                                <script>
                                    $(document).ready(function() {
                                        $(document).on('change', '.switcher-input.switcher-edit', function() {
                                            var group_status = $(this).prop('checked') ? 1 : 0;
                                            var group_id = $(this).data('group-id');
                                            console.log('group_status:', group_status);
                                            console.log('group_id:', group_id);
                                            $.ajax({
                                                type: "GET",
                                                dataType: "json",
                                                url: '{{ route('changeStatusGroup') }}',
                                                data: {
                                                    'group_status': group_status,
                                                    'group_id': group_id
                                                },
                                                success: function(data) {
                                                    console.log(data.message); 
                                                },
                                                error: function(xhr, status, error) {
                                                    console.log('ข้อผิดพลาด');
                                                }
                                            });
                                        });
                                    });
                                </script>


                                    <td class="align-middle">
                                        <a href="{{ route('editcour', [$depart,'group_id' => $item->group_id]) }}">
                                            <i class="far fa-edit fa-lg text-success" data-toggle="tooltip"
                                                title="แก้ไข"></i></a>
                                        <a href="{{ route('deletecour', [$depart,'group_id' => $item->group_id]) }}"
                                            onclick="deleteRecord(event)"
                                           
                                            rel="รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย" class="switcher-delete"
                                            data-toggle="tooltip" title="ลบข้อมูล">
                                            <i class="fas fa-trash-alt fa-lg text-warning "></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
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
            <button type="button" class="btn btn-success btn-floated btn-add" onclick="window.location='{{route('createcour', [$depart->department_id])}}'" data-toggle="tooltip"
                title="เพิ่ม"><span class="fas fa-plus"></span></button>
        </header>
    </div>
    
    
@endsection
