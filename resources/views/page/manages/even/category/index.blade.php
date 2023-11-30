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
    @if (Session::has('warning'))
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

            toastr.warning("{{ Session::get('warning') }}");
        </script>
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted" >
                    @if ($category->category_type == 2)
                        <a href="{{ route('manage', ['department_id' => $depart]) }}"
                            style="text-decoration: underline;">จัดการเว็บ</a> / <a
                            href="{{ route('Webpage', ['department_id' => $depart]) }}"
                            style="text-decoration: underline;">กิจกรรม</a> / <a
                            href="{{ route('acteven', ['department_id' => $depart]) }}"
                            style="text-decoration: underline;">{{ $category->category_th }}</a> 
                    @elseif ($category->category_type == 1)
                        <a href="{{ route('manage', ['department_id' => $depart]) }}"
                            style="text-decoration: underline;">จัดการเว็บ</a> / <a
                            href="{{ route('Webpage', ['department_id' => $depart]) }}"
                            style="text-decoration: underline;">ข่าว</a> / <a
                            href="{{ route('evenpage', ['department_id' => $depart]) }}"
                            style="text-decoration: underline;"><i> {{ $category->category_th }}</i></a> 
                    @endif 
                </div>
                <!-- /.card-header -->
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
                                    <th class="align-middle" style="width:30%"> ชื่อข่าว/กิจกรรม (ไทย) </th>
                                    <th class="align-middle" style="width:30%"> ชื่อข่าว/กิจกรรม (อังกฤษ)</th>
                                    <th class="align-middle" style="width:10%"> เรียงลำดับ </th>
                                    <th class="align-middle" style="width:10%"> สถานะ </th>
                                    <th class="align-middle" style="width:10%"> กระทำ</th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr -->
                                @php
                                $rowNumber = 1;
                            @endphp
                                @foreach ($webs->sortBy('sort')  as $index => $item)
                                   
                                    <tr>
                                        <td><a href="#">{{ $rowNumber++ }}</a></td>
                                        <td>{{ $item->web_th }}</td>
                                        <td>{{ $item->web_en }}</td>
                                        <td>

                                            <select name="sort" id="sort" class="form-control " data-toggle="select2"
                                                data-placeholder="เรียงลำดับ" data-allow-clear="false"
                                                data-web-id="{{ $item->web_id }}">
                                                <option value="{{ $item->sort }}" selected disabled>{{ $item->sort }}
                                                </option>
                                                @for ($i = 1; $i <= count($webs); $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>



                                        </td>

                                        <td class="align-middle"> <label
                                                class="switcher-control switcher-control-success switcher-control-lg">
                                                <input type="checkbox" class="switcher-input switcher-edit"
                                                    {{ $item->web_status == 1 ? 'checked' : '' }}
                                                    data-web-id="{{ $item->web_id }}">
                                                <span class="switcher-indicator"></span>
                                                <span class="switcher-label-on">ON</span>
                                                <span class="switcher-label-off text-red">OFF</span>
                                            </label>

                                        </td>

                                        <script>
                                            $(document).ready(function() {
                                                $(document).on('change', '.switcher-input.switcher-edit', function() {
                                                    var web_status = $(this).prop('checked') ? 1 : 0;
                                                    var web_id = $(this).data('web-id');
                                                    console.log('web_status:', web_status);
                                                    console.log('web_id:', web_id);
                                                    $.ajax({
                                                        type: "GET",
                                                        dataType: "json",
                                                        url: '{{ route('changeStatusWeb') }}',
                                                        data: {
                                                            'web_status': web_status,
                                                            'web_id': web_id
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
                                                href="{{ route('editcat', ['department_id' => $depart, 'web_id' => $item]) }}">
                                                <i class="far fa-edit fa-lg text-success" data-toggle="tooltip"
                                                    title="แก้ไข"></i></a>
                                            <a href="{{ route('destroycat', ['web_id' => $item]) }}"
                                                onclick="deleteRecord(event)"
                                                rel="จัดสัมมนา “สร้างการรับรู้แนวทางการพิจารณาการปฏิบัติทางการค้าที่เป็นธรรมเกี่ยวกับการให้สินเชื่อการค้า (Credit Term) ในพื้นที่ภาคตะวันออกเฉียงเหนือ”"
                                                class="switcher-delete" data-toggle="tooltip" title="ลบ">
                                                <i class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                        </td>
                                    </tr><!-- /tr -->
                                    <!-- tr -->
                                @endforeach
                            </tbody><!-- /tbody -->
                        </table><!-- /.table -->
                    </div><!-- /.table-responsive -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.page-section -->

        <!-- .page-title-bar -->
        <header class="page-title-bar">
            <!-- floating action -->
            <input type="hidden" name="__id" id="__id" value="4" />
            <button type="button" class="btn btn-success btn-floated btn-addwms"
                onclick="window.location='{{ route('createcat', ['department_id' => $depart, 'category_id' => $category]) }}'"
                data-toggle="tooltip" title="เพิ่ม"><span class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->

    <script>
        $(document).ready(function() {
            $(document).on('change', '#sort', function() {
                var sort = $(this).val();
                var webId = $(this).data('web-id');
                console.log('Sort:', sort);
                console.log('Web ID:', webId);
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('changeSortWeb') }}',
                    data: {
                        'sort': sort,
                        'web_id': webId
                    },
                    success: function(data) {
                        console.log(data.message); // Display the returned message
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log('An error occurred.');
                    }
                });
            });
        });
    </script>
@endsection
