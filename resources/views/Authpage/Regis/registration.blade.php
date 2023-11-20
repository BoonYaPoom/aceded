

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><!-- End Required meta tags -->
    <!-- Begin SEO tag -->
    <title>Administrator Management System</title>
    <meta property="og:title" content="">
    <meta name="author" content="Anti-corruption Education">
    <meta property="og:locale" content="th_TH">
    <meta name="description" content="">
    <meta property="og:description" content="">
    <link rel="canonical" href="">
    <meta property="og:url" content="">
    <meta property="og:site_name" content="">
    <script type="application/ld+json">
    {
      "name": $this->config->item('webname'),
        "description": $this->config->item('description'),
        "author":
        {
          "@type": "Anti-corruption Education",
          "name": "Anti-corruption Education"
        },
        "@type": "WebSite",
        "url": "",
        "headline": $this->config->item('webname'),
        "@context": ""
    }
    </script>
    <meta name="theme-color" content="#3063A0">
    <link href="{{ asset('/javascript/vendor/open-iconic/css/open-iconic-bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/javascript/vendor/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('/javascript/vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/javascript/vendor/flatpickr/flatpickr.min.css') }}">
    <link href="{{ asset('/stylesheets/theme/stylesheets/theme.min.css') }}" rel="stylesheet" data-skin="default">
    <link href="{{ asset('/stylesheets/theme/stylesheets/theme-dark.min.css') }}" rel="stylesheet" data-skin="dark">
    <link rel="stylesheet" href="{{ asset('/stylesheets/theme/stylesheets/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('/javascript/datatables.net/css/scroller.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/javascript/datatables.net/css/buttons.dataTables.min.css') }}">
    <link href="{{ asset('/javascript/vendor/summernote/summernote-bs4.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/javascript/vendor/nouislider/nouislider.min.css') }}">
    <link href="{{ asset('/javascript/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}"
        rel="stylesheet">

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        @font-face {
            font-family: 'DB-Heavent';
            src: url('{{ asset('fonts/DB-Heavent-v3.2.1.woff2') }}') format('woff2');

        }

        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "DB-Heavent", sans-serif;
            font-size: 1.45rem;
        }

        .bg-infohead {
            background-color: #F04A23;
            color: rgba(255, 255, 255, 0.8);
        }

        .nav-link {
            font-size: 1.45rem;
        }

        .auth-footer {
            max-width: 520px;
        }
    </style>
    <script>
        var skin = localStorage.getItem('skin');
        var unusedLink = document.querySelector('link[data-skin]:not([data-skin="' + skin + '"])');
        unusedLink.setAttribute('rel', '');
        unusedLink.setAttribute('disabled', true);
    </script>

    <script src="{{ asset('/javascript/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/javascript/vendor/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('/javascript/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/javascript/vendor/pace/pace.min.js') }}"></script>
    <script src="{{ asset('/javascript/vendor/stacked-menu/stacked-menu.min.js') }}"></script>
    <script src="{{ asset('/javascript/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('/javascript/vendor/flatpickr/plugins/monthSelect/monthSelect.js') }}"></script>
    <script src="{{ asset('/javascript/theme/theme.min.js') }}"></script>
    <script src="{{ asset('/javascript/vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('/javascript/vendor/nouislider/wNumb.js') }}"></script>
    <script src="{{ asset('/javascript/vendor/select2/js/select2-demo.js') }}"></script>
    <script src="{{ asset('/javascript/vendor/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('/javascript/vendor/masonry-layout/masonry.pkgd.min.js') }}"></script>
    <script src="{{ asset('/javascript/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('/javascript/vendor/nouislider/nouislider.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('/javascript/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('/javascript/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <!-- END PLUGINS JS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('/javascript/vendor/flatpickr/flatpickr.min.js') }}"></script>
    <!-- BEGIN PLUGINS JS -->


    <script src="{{ asset('/javascript/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/javascript/vendor/datatables/extensions/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/javascript/vendor/datatables/extensions/buttons/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/javascript/vendor/datatables/extensions/buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/javascript/vendor/datatables/extensions/buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('/javascript/datatables.net/js/dataTables.scroller.min.js?v=1.10.19') }}"></script>
    <script src="{{ asset('/javascript/datatables.net/js/dataTables.buttons.min.js?v=1.10.19') }}"></script>
    <script src="{{ asset('/javascript/datatables.net/js/jszip.min.js?v=1.10.19') }}"></script>
    <script src="{{ asset('/javascript/datatables.net/js/pdfmake.min.js?v=1.10.20') }}"></script>
    <script src="{{ asset('/javascript/datatables.net/js/vfs_fonts.js?v=1.10.20') }}"></script>
    <script src="{{ asset('/javascript/datatables.net/js/buttons.colVis.min.js?v=1.10.19') }}"></script>
    <script src="{{ asset('/javascript/datatables.net/js/dataTables.fixedHeader.min.js?v=1.10.19') }}"></script>
    <script src="{{ asset('/javascript/theme/pages/dataTables.bootstrap.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;display=swap" rel="stylesheet">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function deleteRecord(ev) {
            ev.preventDefault();
            var urlToredirect = ev.currentTarget.getAttribute('href');

            swal({
                    title: "คุณต้องการลบข้อมูล?",
                    text: "คุณจะไม่สามารถย้อนกลับได้!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location.href = urlToredirect;
                    } else {
                        swal("คุญได้ยกเลิกการลบข้อมูล!");
                    }
                });
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>




</head>


    <form action="{{ route('register-user') }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
        @csrf
        <span class="text-danger">
            @error('usertype')
                {{ $fail }}
            @enderror
        </span>
        <!-- Content Section -->
        <div class="bg-white">
            <div class="container space-2">
                <div class="row justify-content-between align-items-center mb-4">
                    <div class="col-lg">
                        <h6 class="card-header"> ข้อมูลส่วนตัว </h6>
                        <div class="card-body">

                            <!-- form row -->
                            <div class="form-row ">
                                <label for="usertype" class="col-md-3">ประเภทบุคลากร </label>
                                <div class="col-md-9 mb-3">
                                    <div class="custom-control custom-control-inline custom-radio mr-3">
                                        <input type="radio" class="custom-control-input usertypeselect" name="user_type"
                                            id="usertype1" value="1">
                                        <label class="custom-control-label" for="usertype1">บุคลากรของสำนักงาน</label>
                                    </div>
                                    <div class="custom-control custom-control-inline custom-radio mr-3">
                                        <input type="radio" class="custom-control-input usertypeselect" name="user_type"
                                            id="usertype2" value="2">
                                        <label class="custom-control-label" for="usertype2">บุคคลทั่วไป</label>
                                    </div>

                                </div>
                            </div>
                            <!-- /form row -->
                            <span class="text-danger">
                                @error('usertype')
                                    {{ $message }}
                                @enderror
                            </span>
                            <!-- form row -->
                            <div class="form-row">
                                <label for="username" class="col-md-3">Username <span
                                        class="text-primary-theme">*</span></label>
                                <div class="col-md-9 mb-3">
                                    <input required="" type="text" class="form-control form-control-sm inputuname "
                                        id="username" name="username" placeholder="Username" value="" minlength="5"
                                        maxlength="20">
                                    <small class="form-text text-muted">อีเมลตัวหรืออักษรอังกฤษความยาว 5-20 ตัวอักษร</small>
                                    <span class="err"></span>
                                </div>
                            </div>
                            <!-- /form row -->
                            <span class="text-danger">
                                @error('username')
                                    {{ $message }}
                                @enderror
                            </span>
                            <!-- form row -->
                            <div class="form-row">
                                <label for="password" class="col-md-3"> รหัสผ่าน <span
                                        class="text-primary-theme">*</span></label>
                                <div class="col-md-9 mb-3">
                                    <input required="" type="password" class="form-control form-control-sm"
                                        id="password" name="password" value="" placeholder="รหัสผ่าน" minlength="1"
                                        maxlength="20"><small class="form-text text-muted">ตัวอักษรอังกฤษและตัวเลขความยาว
                                        8-20 ตัวอักษร</small>

                                </div>
                            </div>
                            <!-- /form row -->
                            <span class="text-danger">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </span>
                            <!-- form row -->
                            <div class="form-row">
                                <label for="confirm_password" class="col-md-3"> ยืนยันรหัสผ่าน <span
                                        class="text-primary-theme">*</span></label>
                                <div class="col-md-9 mb-3">
                                    <input required="" type="password" class="form-control form-control-sm"
                                        value="" id="confirm_password" name="confirm_password"
                                        placeholder="ยืนยันรหัสผ่าน" minlength="1">
                                    <span class="err"></span>
                                </div>
                            </div>
                            <!-- /form row -->
                            <span class="text-danger">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </span>
                            <!-- form row -->
                            <div class="form-row">
                                <label for="citizen_id" class="col-md-3">เลขประจำตัวประชาชน <span
                                        class="text-primary-theme">*</span></label>
                                <div class="col-md-9 mb-3">
                                    <input required="" type="text" class="form-control form-control-sm" maxlength="13"
                                        minlength="13" id="citizen_id" name="citizen_id" placeholder="เลขประจำตัวประชาชน"
                                        value="">
                                    <span class="err"></span>
                                </div>
                            </div>
                            <!-- /form row -->
                            <span class="text-danger">
                                @error('citizen_id')
                                    {{ $message }}
                                @enderror
                            </span>
                            <!-- form row -->
                            <div class="form-row">
                                <label for="input04" class="col-md-3">เพศ</label>
                                <div class="col-md-9 mb-3">
                                    <div class="custom-control custom-control-inline custom-radio">
                                        <input type="radio" class="custom-control-input " name="gender"
                                            id="male" value="1">
                                        <label class="custom-control-label" for="male">ชาย</label>
                                    </div>
                                    <div class="custom-control custom-control-inline custom-radio">
                                        <input type="radio" class="custom-control-input " name="gender"
                                            id="female" value="2">
                                        <label class="custom-control-label" for="female">หญิง</label>
                                    </div>
                                </div>
                            </div>
                            <!-- /form row -->
                            <span class="text-danger">
                                @error('gender')
                                    {{ $message }}
                                @enderror
                            </span>
                            <!-- form row -->
                            <div class="form-row">
                                <label for="firstname" class="col-md-3">ชื่อ <span
                                        class="text-primary-theme">*</span></label>
                                <div class="col-md-9 mb-3">
                                    <input required="" type="text" class="form-control form-control-sm"
                                        value="" id="firstname" name="firstname" placeholder="ชื่อ">
                                    <span class="err"></span>
                                </div>
                            </div>
                            <!-- /form row -->
                            <span class="text-danger">
                                @error('firstname')
                                    {{ $message }}
                                @enderror
                            </span>
                            <!-- form row -->
                            <div class="form-row">
                                <label for="middlename" class="col-md-3">ชื่อกลาง </label>
                                <div class="col-md-9 mb-3">
                                    <input type="text" class="form-control form-control-sm" value=""
                                        id="middlename" name="middlename" placeholder="ชื่อกลาง">
                                    <span class="err"></span>
                                </div>
                            </div>
                            <!-- /form row -->
                            <!-- form row -->
                            <div class="form-row">
                                <label for="lastname" class="col-md-3">นามสกุล <span
                                        class="text-primary-theme">*</span></label>
                                <div class="col-md-9 mb-3">
                                    <input required="" type="text" class="form-control form-control-sm"
                                        value="" id="lastname" name="lastname" placeholder="นามสกุล">
                                    <span class="err"></span>
                                </div>
                            </div>
                            <!-- /form row -->
                            <!-- form row -->
                            <div class="form-row" id="set_pos_name">
                                <label for="pos_name" class="col-md-3">อาชีพ <span
                                        class="text-primary-theme">*</span></label>
                                <div class="col-md-9 mb-3">
                                    <input required="" type="text" class="form-control form-control-sm"
                                        id="pos_name" name="pos_name" value="" placeholder="อาชีพ">

                                </div>
                            </div>
                            <!-- /form row -->
                            <!-- form row -->
                            <div class="form-row">
                                <label for="email" class="col-md-3">อีเมล์ <span
                                        class="text-primary-theme">*</span></label>
                                <div class="col-md-9 mb-3">
                                    <input required="" type="email" class="form-control form-control-sm"
                                        value="" id="email" name="email" placeholder="อีเมล์">
                                    <span class="err"></span>
                                </div>
                            </div>
                            <!-- /form row -->
                            <span class="text-danger">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </span>
                            <!-- form row -->
                            <div class="form-row">
                                <label for="mobile" class="col-md-3">มือถือ <span
                                        class="text-primary-theme">*</span></label>
                                <div class="col-md-9 mb-3">
                                    <input required="" type="text" class="form-control form-control-sm number"
                                        value="" id="mobile" name="mobile" placeholder="มือถือ"
                                        maxlength="10">
                                    <span class="err"></span>
                                </div>
                            </div>
                            <!-- /form row -->
                            <span class="text-danger">
                                @error('mobile')
                                    {{ $message }}
                                @enderror
                            </span>
                            <!-- form row -->
                            <div class="form-row">
                                <label for="workplace" class="col-md-3">ที่อยู่ <span
                                        class="text-primary-theme">*</span></label>
                                <div class="col-md-9 mb-3">
                                    <textarea type="text" class="form-control form-control-sm" value="" id="workplace" name="workplace"
                                        placeholder="ที่อยู่ "></textarea>
                                    <span class="err"></span>
                                </div>
                            </div>
                            <!-- /form row -->
                            <span class="text-danger">
                                @error('workplace')
                                    {{ $message }}
                                @enderror
                            </span>
                            <!-- form row -->
                            <div class="form-row">
                                <label for="province_id" class="col-md-3">จังหวัด <span
                                        class="text-primary-theme">*</span></label>
                                <div class="col-md-9 mb-3">
                                  <select  id="province_id" name="province_id"
                                  class="form-control form-control-sm" data-toggle="select2" data-placeholder="จังหวัด"
                                  data-allow-clear="false">
                                  <option value="0">จังหวัด</option>
                                  @foreach ($provinces as $province)
                                  <option value="{{ $province->id }}">{{ $province->name_in_thai }}</option>
                                  @endforeach
                              </select>

                                </div>
                            </div>
                            <!-- /form row -->

                            <!-- form row -->
                            <div class="form-row" id="set_district_id">
                                <label for="district_id" class="col-md-3">เขต/อำเภอ <span
                                        class="text-primary-theme">*</span></label>
                                <div class="col-md-9 mb-3">
                                    <select  id="district_id" name="district_id" class="form-control form-control-sm" data-toggle="select2" data-placeholder="เขต/อำเภอ" data-allow-clear="false">
                                        <option value="">เขต/อำเภอ</option>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}">{{ $district->name_in_thai }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>





                            <!-- form row -->
                            <div class="form-row" id="set_subdistrict_id">
                                <label for="subdistrict_id" class="col-md-3">แขวง/ตำบล <span
                                        class="text-primary-theme">*</span></label>
                                <div class="col-md-9 mb-3">
                                    <select  id="subdistrict_id" name="subdistrict_id"
                                        class="form-control form-control-sm" data-toggle="select2"
                                        data-placeholder="แขวง/ตำบล" data-allow-clear="false">
                                        <option value="0">แขวง/ตำบล</option>
                                        @foreach ($supdist as $supdists)
                                            <option value="{{ $supdists->id }}">{{ $supdists->name_in_thai }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /form row -->



                            <!-- form row -->
                            <div class="form-row d-none" id="set_pos_level" style="display: none;">
                                <label for="pos_level" class="col-md-3">ระดับตำแหน่ง <span
                                        class="text-primary-theme">*</span></label>
                                <div class="col-md-9 mb-3">
                                    <select id="pos_level" name="pos_level" class="form-control form-control-sm"
                                        data-toggle="select2" data-placeholder="ระดับตำแหน่ง" data-allow-clear="false">
                                        <option value="0">โปรดเลือกระดับตำแหน่ง</option>
                                        <option value="1">ระดับปฏิบัติงาน </option>
                                        <option value="2">ระดับชำนาญงาน </option>
                                        <option value="3">ระดับอาวุโส </option>
                                        <option value="4">ระดับทักษะพิเศษ </option>
                                        <option value="5">ระดับปฏิบัติการ </option>
                                        <option value="6">ระดับชำนาญการ </option>
                                        <option value="7">ระดับชำนาญการพิเศษ </option>
                                        <option value="8">ระดับเชี่ยวชาญ </option>
                                        <option value="9">ระดับทรงคุณวุฒิ </option>
                                        <option value="10">ระดับอำนวยการต้น </option>
                                        <option value="11">ระดับอำนวยการสูง </option>
                                        <option value="12">ระดับบริหารต้น </option>
                                        <option value="13">ระดับบริหารสูง </option>
                                    </select>
                                </div>
                            </div>
                            <!-- /form row -->

                            <!-- form row -->
                            <div class="form-row d-none" id="set_sector_id" style="display: block;">
                                <label for="sector_id" class="col-md-3">ส่วนกลาง / ต่างจังหวัด <span
                                        class="text-primary-theme">*</span></label>
                                <div class="col-md-9 col-lg-9 mb-3">
                                    <select id="sector_id" name="sector_id" class="form-control form-control-sm"
                                        data-toggle="select2" data-placeholder="ส่วนกลาง/ต่างจังหวัด"
                                        data-allow-clear="false">
                                        <option value="0">โปรดเลือกส่วนกลาง/ต่างจังหวัด</option>
                                        <option value="1">ภาค1 </option>
                                        <option value="2">ภาค2 </option>
                                        <option value="3">ภาค3 </option>
                                        <option value="4">ภาค4 </option>
                                        <option value="5">ภาค5 </option>
                                        <option value="6">ภาค6 </option>
                                        <option value="7">ภาค7 </option>
                                        <option value="8">ภาค8 </option>
                                        <option value="9">ภาค9 </option>
                                        <option value="10">ส่วนกลาง </option>
                                    </select>
                                </div>
                            </div>
                            <!-- /form row -->

                            <!-- form row -->
                            <div class="form-row d-none" id="set_office_id" style="display: block;">
                                <label for="office_id" class="col-md-3">สำนักงาน <span
                                        class="text-primary-theme">*</span></label>
                                <div class="col-md-9 mb-3">
                                    <select id="office_id" name="office_id" class="form-control form-control-sm"
                                        data-toggle="select2" data-placeholder="สำนักงาน" data-allow-clear="false">
                                        <option value="0">โปรดเลือกสำนักงาน</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /form row -->

                        </div>
                        <div class="container">
                            <div class="form-actions text-center">
                                <button type="submit" class="btn btn-primary-theme ml-auto btn-md"><i
                                        class="far fa-save"></i> บันทึก</button>
                            </div>
                        </div>

                    </div>
                </div>




            </div>






    </form>



