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


    <!-- .page-inner -->
    <div class="page-inner">
        <!-- .form -->
        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('manage') }}"
                        style="text-decoration: underline;">จัดการเว็บ</a> / <a href="{{ route('hightpage') }}"
                        style="text-decoration: underline;"> ภาพประชาสัมพันธ์ </a> /<i> แก้ไขข้อมูล</i></div>
                <!-- /.card-header -->
                <!-- .card-body -->
                <div class="card-body">
                    <!-- .form-group -->
                    <div class="form-group">
                        @foreach ($hights as $highlight)
                            <div class="row mb-5">
                                
                                <div class="col-lg-10">
                                    <img src="{{ asset('upload/banner/' . $highlight->highlight_path) }}"
                                    alt="{{ $highlight->highlight_path }}" style="width:100%">
                                    <img src="{{ Storage::disk('external')->url('banner/' . $highlight->highlight_path) }}"
                                    style="width:100%">
                                </div>

                                <div class="col-lg-1">
                                    <label class="switcher-control switcher-control-success switcher-control-lg">
                                        <input type="checkbox" class="switcher-input switcher-edit"
                                            {{ $highlight->highlight_status == 1 ? 'checked' : '' }}
                                            data-highlight-id="{{ $highlight->highlight_id }}">
                                        <span class="switcher-indicator"></span>
                                        <span class="switcher-label-on" data-on="ON">เปิด</span>
                                        <span class="switcher-label-off text-red" data-off="OFF">ปิด</span>
                                    </label>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        $(document).on('change', '.switcher-input.switcher-edit', function() {
                                            var highlight_status = $(this).prop('checked') ? 1 : 0;
                                            var highlight_id = $(this).data('highlight-id');
                                            console.log('highlight_status:', highlight_status);
                                            console.log('highlight_id:', highlight_id);
                                            $.ajax({
                                                type: "GET",
                                                dataType: "json",
                                                url: '{{ route('changeStatus') }}',
                                                data: {
                                                    'highlight_status': highlight_status,
                                                    'highlight_id': highlight_id
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
                                <div class="col-lg-1">
                                    <a href="{{ route('destoryban', ['highlight_id' => $highlight->highlight_id]) }}"
                                        onclick="deleteRecord(event)" rel="ภาพประชาสัมพันธ์" class="switcher-delete"
                                        data-toggle="tooltip" title="ลบ"><i
                                            class="fas fa-trash-alt fa-lg text-warning "></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div><!-- .form-group -->

                    <form action="{{ route('storeban') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="highlight_path">ภาพประชาสัมพันธ์ </label> <input type="file" class="form-control"
                                id="highlight_path" accept="image/*" name="highlight_path" placeholder="ภาพประชาสัมพันธ์	"
                                accept="banner/*">
                        </div><!-- /.form-group -->
                        @error('highlight_path')
                            <span class="badge badge-warning">{{ $message }}</span>
                        @enderror

                        <!-- .form-group -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->
            <!-- .form-actions -->
            <div class="form-actions">
                <button class="btn btn-lg btn-primary ml-auto" type="submit"><i class="far fa-save"></i>
                    บันทึก</button>
            </div><!-- /.form-actions -->
            </form>

        </div><!-- /.page-section -->
    </div><!-- /.page-inner -->
@endsection
