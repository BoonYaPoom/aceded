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

        <!-- .page-section -->
        <div class="page-section">
            <!-- .card -->
            <div class="card card-fluid">
                <!-- .card-header -->
                <div class="card-header bg-muted"><a href="{{route('exampage', [$subs->subject_id])}}"
                        style="text-decoration: underline;">หมวดหมู่</a> / <a
                        href=""
                        style="text-decoration: underline;">จัดการวิชา</a> / <i>คลังข้อสอบ</i></div><!-- /.card-header -->
                <!-- .card-body -->
                <div class="card-body">
                    <form action="{{ route('Questionimport') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" />

                        <div class="form-group">
                            <label for="fileexcel">เลือกไฟล์รายชื่อ <span
                                    class="badge badge-warning">Required</span></label> <a class="ml-3"
                                href="{{ Storage::disk('external')->url('file/ข้อสอบ.xlsx') }}">ไฟล์ตัวอย่าง </a>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="fileexcel" id="fileexcel" class="custom-file-input"
                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                multiple> <label class="custom-file-label" for="fileexcel-customInput">Choose files</label>
                        </div>
                </div>
                <div class="form-actions text-center">
                    <button type="submit" class="btn  btn-lg btn-primary "><i class="fas fa-save"></i> นำเข้าไฟล์ข้อสอบ
                    </button><br>&nbsp;
                    <img src="{{ Storage::disk('external')->url('file/questionadd.png') }}">
                </div>
                <div>

                </div>
                </form><!-- .table-responsive -->
                <div class="table-responsive d-none">
                    <!-- .table -->
                    <table id="datatable2" class="table w3-hoverable">
                        <!-- thead -->
                        <thead>
                            <tr class="bg-infohead">
                                <th class="align-middle" style="width:5%"> ข้อที่ </th>
                                <th class="align-middle" style="width:25%"> คำถาม </th>
                                <th class="align-middle" style="width:10%"> ตัวเลือกที่1 </th>
                                <th class="align-middle" style="width:10%"> ตัวเลือกที่2 </th>
                                <th class="align-middle" style="width:10%"> ตัวเลือกที่3 </th>
                                <th class="align-middle" style="width:10%"> ตัวเลือกที่4 </th>
                                <th class="align-middle" style="width:10%"> ตัวเลือกที่5 </th>
                                <th class="align-middle" style="width:10%"> เฉลย </th>
                                <th class="align-middle" style="width:10%"> คำอธิบาย </th>
                            </tr>
                        </thead><!-- /thead -->
                        <!-- tbody -->
                        <tbody>
                        </tbody><!-- /tbody -->
                    </table><!-- /.table -->
                </div><!-- /.table-responsive -->
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div><!-- /.page-section -->

    <!-- .page-title-bar -->

    </div><!-- /.page-inner -->
@endsection
