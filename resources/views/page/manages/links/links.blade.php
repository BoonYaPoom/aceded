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
                <div class="card-header bg-muted"><a href="{{ route('manage', ['department_id' => $depart]) }}" style="text-decoration: underline;">จัดการเว็บ</a> / <a
                        href="{{ route('linkpage', ['department_id' => $depart]) }}" style="text-decoration: underline;">ลิงค์ที่น่าสนใจ</a> </div><!-- /.card-header -->
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
                                    <th class="align-middle" style="width:30%"> ลิงค์ที่น่าสนใจ </th>
                                    <th class="align-middle" style="width:10%"> เรียงลำดับ </th>
                                    <th class="align-middle" style="width:10%"> สถานะ </th>
                                    <th class="align-middle" style="width:10%"> กระทำ</th>
                                </tr>
                            </thead><!-- /thead -->
                            <!-- tbody -->
                            <tbody>
                                <!-- tr -->
                                @php 
                                $l = 1;
                                
                                @endphp
                                @foreach ($links as $item)
                                
                                    <tr>
                                        <td>{{ $l++ }}</td>
                                        <td>{{ $item->links_title }}</td>
                                        <td><select name="sort" id="sort" class="form-control" data-toggle="select2"
                                                data-placeholder="เรียงลำดับ" data-allow-clear="false"
                                                data-links-id="{{ $item->links_id }}">
                                                <option value="{{ $item->sort }}" selected disabled>{{ $item->sort }}</option>
                                                @for ($i = 1; $i <= count($links); $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </td>
                                        
                                    <script>
                                        $(document).ready(function() {
                                            $(document).on('change', '#sort', function() {
                                                var sort = $(this).val();
                                                var linksId = $(this).data('links-id');
                                                console.log('Sort:', sort);
                                                console.log('links ID:', linksId);
                                                $.ajax({
                                                    type: "GET",
                                                    dataType: "json",
                                                    url: '{{ route('changeSortIink') }}',
                                                    data: {
                                                        'sort': sort,
                                                        'links_id': linksId
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

                                    <td class="align-middle">
                                        <label class="switcher-control switcher-control-success switcher-control-lg">
                                            <input type="checkbox" class="switcher-input switcher-edit"
                                            {{ $item->links_status == 1 ? 'checked' : '' }} 
                                                data-links-id="{{  $item->links_id }}">
                                            <span class="switcher-indicator"></span>
                                            <span class="switcher-label-on" >ON</span>
                                            <span class="switcher-label-off text-red" >OFF</span>
                                        </label>
                                  </td>
                                 
                         
                            <script>
                                $(document).ready(function() {
                                    $(document).on('change', '.switcher-input.switcher-edit', function() {
                                        var links_status = $(this).prop('checked') ? 1 : 0;
                                        var links_id = $(this).data('links-id');
                                        console.log('links_status:', links_status);
                                        console.log('links_id:', links_id);
                                        $.ajax({
                                            type: "GET",
                                            dataType: "json",
                                            url: '{{ route('changeStatusLinks') }}',
                                            data: {
                                                'links_status': links_status,
                                                'links_id': links_id
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
                                            <a href="{{ Route('editlink', ['links_id' => $item->links_id]) }}">
                                                <i class="far fa-edit fa-lg text-success" data-toggle="tooltip"
                                                    title="แก้ไข"></i></a>
                                            <a href="{{ Route('destorylink', ['links_id' => $item->links_id]) }}"
                                                onclick="deleteRecord(event)" rel="จุลสาร" class="switcher-delete"
                                                data-toggle="tooltip" title="ลบ">
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
            <button type="button" class="btn btn-success btn-floated btn-addwms"
                onclick="window.location='{{ route('linkcreate', ['department_id' => $depart]) }}'" data-toggle="tooltip" title="เพิ่ม"><span
                    class="fas fa-plus"></span></button>
            <!-- /floating action -->
        </header><!-- /.page-title-bar -->
    </div><!-- /.page-inner -->
@endsection
