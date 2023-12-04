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

        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{ route('departmentwmspage') }}"
                        style="text-decoration: underline;">จัดการเว็บ</a> / <a href="{{ route('dataci') }}"
                        style="text-decoration: underline;"> โลโก้</a> /<i> แก้ไขข้อมูล</i></div><!-- /.card-header -->
                <!-- .card-body -->
                <div class="card-body">
                    @foreach ($genaral as $item)
                        <div class="form-group">
                            <div class="col-lg-10">
                                <img src="{{ asset($item->detail) }}" style="width:80%">
                            </div>

                        </div>

                        <form method="POST" action="{{ route('updategenDP', [$depart, $item->id]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <label for="detail">โลโก้ ( ขนาด 585px * 350px )</label> <input type="file" class="form-control" id="detail"
                                name="detail" placeholder="โลโก้" accept=" image/jpeg, image/png">
                                <small class="form-text text-muted">{{$item->detail}}</small>
                            @error('detail')
                                <span class="badge badge-warning">{{ $message }}</span>
                            @enderror
                </div><!-- /.form-group -->
                @endforeach
            </div>
            <div class="form-actions">
                <button class="btn btn-lg btn-primary ml-auto" type="submit">
                    <i class="far fa-save"></i> บันทึก</button>
            </div>

            </form>
        </div>
    </div>
@endsection
