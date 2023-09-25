


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


<div class="form-actions text-center">
                                        
    <a href="{{ route('homelogin') }}"
        class="btn btn-primary-theme ml-auto btn-md">กลับหน้า Login</a>
</div>

    <div class="bg-white">
        <div class="container space-2">
            <div class="row justify-content-between align-items-center mb-4">
                <div class="col-lg">

                    <div>
                        <!--class="card-body"-->
                            <div id="step-0" class="tab-pane " user_role="tabpanel" aria-labelledby="step-0">


                                <h4 class="card-header"> เงื่อนไขการใช้บริการระบบแพลตฟอร์มต้านทุจริตศึกษา
                                    ของสำนักงานคณะกรรมการป้องกันและปราบปรามการทุจริตแห่งชาติ</h4>
                                <div>
                                    <div id="step-0" class="tab-pane " user_role="tabpanel" aria-labelledby="step-0">

                                        <ul class="list-group">


                                            <li class="list-group-item">1. การสมัครสมาชิก ไม่ต้องเสียค่าใช้จ่ายใด ๆ ทั้งสิ้น
                                            </li>
                                            <li class="list-group-item">2. ผู้สมัครจะต้องกรอกข้อมูลรายละเอียดต่าง ๆ
                                                ตามจริงให้ครบถ้วน ทั้งนี้เพื่อประโยชน์แก่ตัวผู้สมัคร
                                                หากตรวจพบว่าข้อมูลของผู้สมัครไม่เป็นความจริง สำนักงาน ป.ป.ช.
                                                จะระงับการใช้งานของผู้สมัครโดยไม่ต้องแจ้งให้ทราบล่วงหน้า</li>
                                            <li class="list-group-item">3. ผู้ใดแอบอ้าง หรือกระทำการใด ๆ
                                                อันเป็นการละเมิดสิทธิส่วนบุคคล โดยใช้ข้อมูลของผู้อื่นมาแอบอ้างสมัครสมาชิก
                                                เพื่อให้ได้สิทธิมาซึ่งการเป็นสมาชิก
                                                ถือเป็นความผิดต้องรับโทษตามที่กฎหมายกำหนดไว้</li>
                                            <li class="list-group-item">4. ข้อมูลส่วนบุคคลของผู้สมัครที่ได้ลงทะเบียน
                                                หรือผ่านการใช้งานของเว็บไซต์ของสำนักงาน ป.ป.ช. ทั้งหมดนั้น
                                                ผู้สมัครยินยอมให้สำนักงาน ป.ป.ช.
                                                ใช้ข้อมูลของผู้สมัครสมาชิกในงานที่เกี่ยวข้อง</li>
                                            <li class="list-group-item">5. สำนักงาน ป.ป.ช.
                                                ขอรับรองว่าจะเก็บข้อมูลของผู้สมัครไว้เป็นความลับอย่างดีที่สุด
                                                โดยจะมินำไปเปิดเผยที่ใด และ/หรือเพื่อประโยชน์ทางการค้า
                                                หรือประโยชน์ทางด้านอื่น ๆ โดยไม่ได้รับความยินยอม
                                                นอกจากจะได้รับหมายศาลหรือหนังสือทางราชการ ซึ่งขึ้นอยู่กับดุลพินิจของสำนักงาน
                                                ป.ป.ช.</li>
                                            <li class="list-group-item">6.
                                                ผู้สมัครต้องปฏิบัติตามข้อกำหนดและเงื่อนไขการให้บริการของเว็บไซต์สำนักงานคณะกรรมการป้องกันและปราบปรามการทุจริตแห่งชาติโดยเคร่งครัด
                                                เพื่อความปลอดภัยในข้อมูลส่วนบุคคลของผู้สมัคร
                                                ในกรณีที่ข้อมูลส่วนบุคคลดังกล่าวถูกโจรกรรมโดยวิธีการทางอิเล็กทรอนิกส์
                                                หรือสูญหาย เสียหายอันเนื่องจากสาเหตุสุดวิสัยหรือไม่ว่ากรณีใด ๆ ทั้งสิ้น
                                                สำนักงาน ป.ป.ช. ขอสงวนสิทธิ์ในการปฏิเสธความรับผิดจาก เหตุดังกล่าวทั้งหมด
                                            </li>
                                            <li class="list-group-item">7. ผู้สมัครจะต้องรักษารหัสผ่าน
                                                หรือชื่อเข้าใช้งานในระบบสมาชิกเป็นความลับ
                                                และหากมีผู้อื่นสามารถเข้าใช้จากทางชื่อของผู้สมัครได้ ทางสำนักงาน ป.ป.ช.
                                                จะไม่รับผิดชอบใด ๆ ทั้งสิ้น</li>

                                            <li class="list-group-item">
                                                ข้าพเจ้าผู้สมัครได้อ่านเงื่อนไขการสมัครแล้วและยินยอมให้สำนักงาน ป.ป.ช.
                                                ตรวจสอบข้อมูลส่วนตัว และ/หรือข้อมูลอื่นใดที่ผู้สมัครระบุในการสมัครสมาชิก
                                                และตกลงยินยอมผูกพันและปฏิบัติตามข้อตกลงและเงื่อนไขต่าง ๆ
                                                ตามที่ระบุไว้ในข้อตกลงดังกล่าว รวมทั้งข้อตกลงและเงื่อนไขอื่น ๆ
                                                ที่ทางสำนักงาน ป.ป.ช. เห็นสมควร</li>

                                            <li class="list-group-item text-center"><b>Disclaimer</b><br>
                                                สำนักงานคณะกรรมการป้องกันและปราบปรามการทุจริตแห่งชาติจัดทำโครงการพัฒนาระบบฝึกอบรมและเรียนรู้ด้านการแข่งขันทางการค้าผ่านสื่ออิเล็กทรอนิกส์
                                                (สำนักงานคณะกรรมการป้องกันและปราบปรามการทุจริตแห่งชาติ)
                                                เพื่อให้ผู้ประกอบธุรกิจ ประชาชนทั่วไป และผู้ที่เกี่ยวข้อง
                                                สามารถเข้าใจและปฏิบัติตามกฎหมายได้อย่างถูกต้อง ทั้งนี้
                                                คำอธิบายและความเห็นของผู้สอนเป็นเพียงตัวอย่างเพื่อการศึกษาเท่านั้นซึ่งคำวินิจฉัยหรือความเห็นของคณะกรรมการการแข่งขันทางการค้าอาจแตกต่างไปโดยขึ้นอยู่กับข้อเท็จจริงที่ปรากฏในแต่ละกรณี
                                            </li>
                                        </ul>




                                        <div class="custom-control custom-checkbox mt-3 text-center">
                                            <input type="checkbox" class="custom-control-input" id="acceptterms"
                                                name="acceptterms" value="1">
                                            <label class="custom-control-label font-weight-bold" for="acceptterms">
                                                ยอมรับเงื่อนไข </label>
                                        </div>



                                    </div>

                                </div>
                                <div class="container d-none" id="nextbutton">
                                    <div class="form-actions text-center">
                                        
                                        <a href="{{ route('homeregis') }}"
                                            class="btn btn-primary-theme ml-auto btn-md">ถัดไป</a>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <input type="hidden" value="" onclick="this.select()" style="width:100%">
<footer class="footer"> &copy; 2023 All Rights Reserved. Anti-corruption Education
</footer>
<style>
    html, body {
      height: 100%;
      margin: 0;
    }

    .wrapper {
      min-height: 100%;
      display: flex;
      flex-direction: column;
    }

    .content {
      flex: 1;
    }

    .footer {
      background-color: #f8f9fa;
      padding: 20px;
      text-align: center;
    }
  </style>

                </div>

                <script>
                    $(function() {

                        $("#acceptterms").on("change", function() {
                            if ($(this).is(':checked')) {
                                $("#nextbutton").removeClass('d-none');
                            } else $("#nextbutton").addClass('d-none');
                        });
                    })
                </script>
      