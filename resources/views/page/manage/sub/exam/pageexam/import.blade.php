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
                <div class="card-header bg-muted"><a href="{{ route('exampage', [$subs->subject_id]) }}"
                        style="text-decoration: underline;">หมวดหมู่</a> / <a href=""
                        style="text-decoration: underline;">จัดการวิชา</a> / <i>คลังข้อสอบ</i></div><!-- /.card-header -->
                <!-- .card-body -->
                <div class="card-body">
                    <form id="uploadForm" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="fileexcel">เลือกไฟล์รายชื่อ <span
                                    class="badge badge-warning">Required</span></label>
                            <a class="ml-3"
                                href="https://view.officeapps.live.com/op/view.aspx?src=https%3A%2F%2Felearning.tcct.or.th%2Fadmin%2Fupload-files%2F%25E0%25B8%2582%25E0%25B9%2589%25E0%25B8%25AD%25E0%25B8%25AA%25E0%25B8%25AD%25E0%25B8%259A.xlsx&wdOrigin=BROWSELINK"
                                target="_blank">ไฟล์ตัวอย่าง
                            </a>
                        </div>

                        <div class="custom-file">
                            <input type="hidden" name="subject_id" value="{{ $subs->subject_id }}" />
                            <input type="file" name="fileexcel" id="fileexcel" class="custom-file-input"
                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                multiple>
                            <label class="custom-file-label" for="fileexcel">Choose files</label>
                        </div>

                        <div class="form-actions text-center">
                            <button type="submit" class="btn  btn-lg btn-primary "><i class="fas fa-save"></i>
                                นำเข้าไฟล์ข้อสอบ
                            </button><br>&nbsp;
                            <img src="{{ asset('upload/file/questionadd.png') }}">
                        </div>
                    </form>
                </div>
                <script>
                    $(document).ready(function() {
                        $('#uploadForm').on('submit', function(e) {
                            e.preventDefault();

                            var formData = new FormData(this);

                            $.ajax({
                                url: '{{ route('Questionimport', ['subject_id' => $subs]) }}',
                                type: 'POST',
                                data: formData,
                                dataType: 'json',
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    console.log(response); // ดูค่า response ในคอนโซล
                                    if (response.message) {
                                        // แสดง SweetAlert เมื่อการนำเข้าสำเร็จ
                                        Swal.fire({
                                            title: 'Excel Successful',
                                            text: 'ข้อมูล Excel ถูกบันทึกเรียบร้อย',
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        }).then(function(result) {
                                            // หลังจากกดปุ่ม OK
                                            if (result.isConfirmed) {
                                                // ทำสิ่งที่คุณต้องการหลังจากกด OK
                                            }
                                        });
                                    } else {
                                        alert('Import failed: ' + response.error);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    alert('Import failed: ' + error);
                                }
                            });
                        });
                    });
                </script>

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
    <div class="modal fade" id="importSuccessModal" tabindex="-1" role="dialog" aria-labelledby="importSuccessModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importSuccessModalLabel">Import Successful</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="table-responsive ">
                        Import Successful
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
