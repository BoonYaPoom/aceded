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
                <div class="card-header bg-muted"><a href="https://aced.dlex.ai/childhood/admin/lms/department.html"
                        style="text-decoration: underline;">หมวดหมู่</a> / <a
                        href="https://aced.dlex.ai/childhood/admin/lms/subject/12.html"
                        style="text-decoration: underline;">จัดการวิชา</a> / <i></i></div><!-- /.card-header -->
                <!-- .nav-scroller -->
                <div class="nav-scroller border-bottom">
                    <!-- .nav -->
                    <div class="nav nav-tabs bg-muted h3">
                        <a class="nav-link " href="{{ route('class_page', [$depart,'course_id' => $cour]) }}"><i
                                class="fas fa-users"></i> ผู้เรียน รายวิชาเพิ่มเติม การป้องกันการทุจริต ระดับปฐมวัย </a>
                    </div><!-- /.nav -->
                </div><!-- /.nav-scroller -->
                <!-- .card-body -->
                <div class="card-body">
                    <form action="https://aced.dlex.ai/childhood/admin/lms/savedata/registeradd/"
                        enctype="multipart/form-data" method="post" accept-charset="utf-8">
                        <input type="hidden" name="__csrf_token_name" value="720927c2b99c7c37abebdf761a388b00" />

                        <div class="form-group">
                            <label for="fileexcel">เลือกไฟล์รายชื่อ <span
                                    class="badge badge-warning">Required</span></label> <a class="ml-3"
                                href="https://aced.dlex.ai/childhood/admin/upload-files/รายชือ.xlsx">ไฟล์ตัวอย่าง </a>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="fileexcel" id="fileexcel" class="custom-file-input"
                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                multiple> <label class="custom-file-label" for="fileexcel-customInput">Choose files</label>
                        </div>
                </div>
                <div class="form-actions text-center">
                    <button type="submit" class="btn  btn-lg btn-primary "><i class="fas fa-save"></i> นำเข้าไฟล์
                    </button><br>&nbsp;
                </div>
                </form><!-- .table-responsive -->
                <div class="table-responsive d-none">
                    <!-- .table -->
                    <table id="datatable2" class="table w3-hoverable">
                        <!-- thead -->
                        <thead>
                            <tr class="bg-infohead">
                                <th class="align-middle" style="width:10%"> เลือก </th>
                                <th class="align-middle" style="width:20%"> รหัส </th>
                                <th class="align-middle" style="width:30%"> ชื่อ-สกุล</th>

                                <th class="align-middle" style="width:10%"> สถานะ </th>
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
