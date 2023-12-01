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
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"> <a href="{{ route('learn', ['department_id' => $depart]) }}"
                        style="text-decoration: underline;">หมวดหมู่</a>
                    / <a href="{{ route('suppage', ['department_id' => $depart]) }}"
                        style="text-decoration: underline;">จัดการวิชา</a>
                    /
                    <a href="{{ route('lessonpage', [$depart, $subs]) }}"
                        style="text-decoration: underline;"><i>{{ $subs->subject_th }}</i></a> /
                    สื่อเสริม</a>
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
                                    <th class="align-middle" style="width:20%"> ชื่อ (ไทย) </th>
                                    <th class="align-middle w3-hide-small" style="width:20%"> ชื่อ (อังกฤษ) </th>
                                    <th class="align-middle" style="width:10%"> ชนิดสื่อ </th>
                                    <th class="align-middle" style="width:10%"> สถานะ </th>
                                    <th class="align-middle" style="width:10%"> กระทำ</th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            @php
                                $s = 0;
                            @endphp

                            <tbody>
                                @foreach ($supplys->sortBy('supplymentary_id') as $item)
                                    @php
                                        $s++;
                                    @endphp
                                    <tr>
                                        <td><a href="#" target="_blank">{{ $s }}</a></td>
                                        <td><a href="" target="_blank">{{ $item->title_th }}</a></td>
                                        <td><a href="" target="_blank">{{ $item->title_en }}</a></td>
                                        <td>{{ $item->type->content_th }}</td>

                                        <td class="align-middle"> <label
                                                class="switcher-control switcher-control-success switcher-control-lg">
                                                <input type="checkbox" class="switcher-input switcher-edit"
                                                    {{ $item->supplymentary_status == 1 ? 'checked' : '' }}
                                                    data-supplymentary-id="{{ $item->supplymentary_id }}">
                                                <span class="switcher-indicator"></span>
                                                <span class="switcher-label-on" data-on="ON">เปิด</span>
                                                <span class="switcher-label-off text-red" data-off="OFF">ปิด</span>
                                            </label>
                                        </td>


                                        <script src="{{ asset('/javascript/vendor/jquery/jquery.min.js') }}"></script>

                                        <script>
                                            $(document).ready(function() {
                                                $(document).on('change', '.switcher-input.switcher-edit', function() {
                                                    var supplymentary_status = $(this).prop('checked') ? 1 : 0;
                                                    var supplymentary_id = $(this).data('supplymentary-id');
                                                    console.log('supplymentary_status:', supplymentary_status);
                                                    console.log('supplymentary_id:', supplymentary_id);
                                                    $.ajax({
                                                        type: "GET",
                                                        dataType: "json",
                                                        url: '{{ route('changeStatusSupplymentary') }}',
                                                        data: {
                                                            'supplymentary_status': supplymentary_status,
                                                            'supplymentary_id': supplymentary_id
                                                        },
                                                        success: function(data) {
                                                            console.log(data.message); // แสดงข้อความที่ส่งกลับ
                                                        },
                                                        error: function(xhr, status, error) {
                                                            console.log('ข้อผิดพลาด');
                                                        }
                                                    });
                                                });
                                            });
                                        </script>



                                        <td class="align-middle">
                                            <a
                                                href="{{ route('edit_supplyLessform', [$depart,$subs,$lesson,'supplymentary_id' => $item]) }}"><i
                                                    class="far fa-edit fa-lg text-success" data-toggle="tooltip"
                                                    title="แก้ไข"></i></a>
                                            <a href="{{ route('destroy_supplyform', ['supplymentary_id' => $item]) }}"
                                                onclick="deleteRecord(event)"
                                                rel="หน่วยการเรียนรู้ที่ 1 การคิดแยกแยะระหว่างผลประโยชน์ส่วนตนและผลประโยชน์ส่วนรวม"
                                                class="switcher-delete" data-toggle="tooltip" title="ลบข้อมูล"><i
                                                    class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody><!-- /tbody -->

                        </table><!-- /.table -->
                        <script>
                            $(document).ready(function() {
                                var table = $('#datatable2').DataTable({
                                    lengthChange: false,
                                    responsive: true,
                                    info: false,
                                    language: {
                                        url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Thai.json",
                                        infoEmpty: "ไม่พบรายการ",
                                        infoFiltered: "(ค้นหาจากทั้งหมด _MAX_ รายการ)",
                                        paginate: {
                                            first: "หน้าแรก",
                                            last: "หน้าสุดท้าย",
                                            previous: "ก่อนหน้า",
                                            next: "ถัดไป" // ปิดการแสดงหน้าของ DataTables
                                        }
                                    }
                                });
                
                                $('#myInput').on('keyup', function() {
                                    table.search(this.value).draw();
                                });
                            });
                        </script>
                    </div><!-- /.table-responsive -->
                </div><!-- /.card-body -->
                <header class="page-title-bar">
                    <!-- floating action -->
                    <input type="hidden" name="__id" />
                    <button type="button" class="btn btn-success btn-floated btn-add" data-toggle="tooltip"
                        title="เพิ่ม"><span
                            onclick="window.location='{{ route('add_supplyLessform', [$depart, 'subject_id' => $subs, 'lesson_id' => $lesson]) }}'"
                            class="fas fa-plus"></span></button>
                    <!-- /floating action -->
                </header><!-- /.page-title-bar -->
            </div><!-- /.card -->


        </div><!-- /.page-section -->
    </div><!-- /.page-inner -->
@endsection
