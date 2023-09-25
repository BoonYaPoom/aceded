   
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
  <!-- Favicon -->
  <link href="{{ asset('/javascript/vendor/open-iconic/css/open-iconic-bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/javascript/vendor/fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('/stylesheets/select2/select2.min.css') }}">
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

    <!-- BEGIN PLUGINS JS -->

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
    <link rel="stylesheet" href="{{ asset('/stylesheets/logincss/logincss.css') }}">

</head>



    <!-- Account Sidebar Toggle Button -->

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{route('homelogin')}}">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>



            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a id="sidebarNavToggler"
                            class="btn btn-xs btn-text-secondary u-sidebar--account__toggle-bg ml-1 target-of-invoker-has-unfolds"
                            href="#sidebarContent" user_role="button" aria-controls="sidebarContent" aria-haspopup="true"
                            aria-expanded="false" data-toggle="collapse" data-target="#sidebarContent"
                            aria-label="Toggle Sidebar">
                            <span class="position-relative">
                                <span class="u-sidebar--account__toggle-text">เข้าสู่ระบบ</span>
                                <span class="fas fa-user-circle font-size-2 u-sidebar--account__toggle-text"></span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

@if(Session::has('message'))
<div class="alert alert-success">{{Session::get('message')}}</div>
@endif
@if(Session::has('fail'))
<div class="alert alert-danger">{{Session::get('fail')}}</div>
@endif
    <aside id="sidebarContent" class="u-sidebar collapse" aria-labelledby="sidebarNavToggler">
        <div class="u-sidebar__scroller">
            <div class="u-sidebar__container">
                <div class="u-header-sidebar__footer-offset">
                    <!-- Toggle Button -->
                    <div class="d-flex align-items-center pt-4 px-7">
                        <button type="button" class="close ml-auto" aria-controls="sidebarContent" aria-haspopup="true"
                            aria-expanded="false" data-unfold-event="click" data-unfold-hide-on-scroll="false"
                            data-unfold-target="#sidebarContent" data-unfold-type="css-animation"
                            data-unfold-animation-in="fadeInRight" data-unfold-animation-out="fadeOutRight"
                            data-unfold-duration="500">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <!-- End Toggle Button -->
                    <div class="js-scrollbar u-sidebar__body">
                        <div class="u-sidebar__content u-header-sidebar__content">
                            <form action="{{route('login-user')}}" method="post"
                                accept-charset="utf-8">
                                @csrf
                                <div id="login" data-target-group="idForm">
                                    <!-- Title -->
                                    <header class="text-center mb-7">
                                        <h2 class="h4 mb-0">ยินดีต้อนรับ</h2>
                                        <p>ระบบบริหารจัดการเรียนรู้ด้วยตนเอง</p>
                                    </header>
                                    <!-- End Title -->

                                    <!-- Form Group -->
                                    <div class="form-group">
                                        <div class="js-form-message js-focus-state">
                                            <label class="sr-only" for="username">รหัสผู้ใช้</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="username">
                                                        <span class="fas fa-user"></span>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" name="username" id="username"
                                                    placeholder="รหัสผู้ใช้" aria-label="Email"
                                                    aria-describedby="username" required
                                                    data-msg="กรุณากรอกอีเมล์ให้ถูกต้อง ลองอีกครั้ง"
                                                    data-error-class="u-has-error" data-success-class="u-has-success">
                                            </div>
                                        </div>
                               <span class="text-danger">
                                            @error('username')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <!-- End Form Group -->

                                    <!-- Form Group -->
                                    <div class="form-group">
                                        <div class="js-form-message js-focus-state">
                                            <label class="sr-only" for="password">รหัสผ่าน</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend viewpass" id="password">
                                                    <span class="input-group-text" id="signinPasswordLabel">
                                                        <span class="fas fa-eye" id="icon_signinPassword"></span>
                                                    </span>
                                                </div>
                                                <input type="password" class="form-control" name="password"
                                                    id="password" placeholder="********" aria-label="Password"
                                                    aria-describedby="signinPasswordLabel" required
                                                    data-msg="กรุณากรอกรหัสผ่านให้ถูกต้อง ลองอีกครั้ง"
                                                    data-error-class="u-has-error" data-success-class="u-has-success">
                                            </div>
                                            <span class="text-danger">
                                                @error('password')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <!-- End Form Group -->

                                    <div class="d-flex justify-content-end mb-4">
                                        <a class="js-animation-link small link-muted" href="javascript:;"
                                            id="linkforgotpassword" data-target="#forgotPassword"
                                            data-link-group="idForm" data-animation-in="slideInUp">ลืมรหัสผ่าน?</a>
                                    </div>

                                    <div class="mb-2">
                                        <button type="submit"
                                            class="btn btn-block btn-sm btn-primary-theme transition-3d-hover">เข้าสู่ระบบ</button>
                                    </div>
                                    <div class="mb-2 mt-4">
                                        <a class="btn btn-block btn-sm btn-secondary transition-3d-hover"
                                            href="{{route('homeRegis')}}">ลงทะเบียน</a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Footer -->

                        <!-- End Footer -->
                    </div>

                </div>
                <footer id="SVGwaveWithDots" class="svg-preloader u-sidebar__footer u-sidebar__footer--account">
                    <!-- SVG Background Shape -->
                    <div class="position-absolute right-0 bottom-0 left-0">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                            y="0px" viewBox="0 0 300 126.5" style="enable-background:new 0 0 300 126.5;"
                            xml:space="preserve" class="injected-svg js-svg-injector" data-parent="#SVGwaveWithDots">

                            <path class="wave-bottom-with-dots-0 fill-primary-theme" opacity=".6"
                                d="M0,58.9c0-0.9,5.1-2,5.8-2.2c6-0.8,11.8,2.2,17.2,4.6c4.5,2.1,8.6,5.3,13.3,7.1C48.2,73.3,61,73.8,73,69  c43-16.9,40-7.9,84-2.2c44,5.7,83-31.5,143-10.1v69.8H0C0,126.5,0,59,0,58.9z">
                            </path>
                            <path class="wave-bottom-with-dots-1 fill-primary-theme"
                                d="M300,68.5v58H0v-58c0,0,43-16.7,82,5.6c12.4,7.1,26.5,9.6,40.2,5.9c7.5-2.1,14.5-6.1,20.9-11  c6.2-4.7,12-10.4,18.8-13.8c7.3-3.8,15.6-5.2,23.6-5.2c16.1,0.1,30.7,8.2,45,16.1c13.4,7.4,28.1,12.2,43.3,11.2  C282.5,76.7,292.7,74.4,300,68.5z">
                            </path>
                            <g>
                                <circle class="wave-bottom-with-dots-2 fill-danger" cx="259.5" cy="17"
                                    r="13"></circle>
                                <circle class="wave-bottom-with-dots-1 fill-primary" cx="290" cy="35.5"
                                    r="8.5"></circle>
                                <circle class="wave-bottom-with-dots-3 fill-success" cx="288" cy="5.5"
                                    r="5.5"></circle>
                                <circle class="wave-bottom-with-dots-4 fill-warning" cx="232.5" cy="34"
                                    r="2"></circle>
                            </g>
                        </svg>
                    </div>
                    <!-- End SVG Background Shape -->
                </footer>
                <!-- End Footer -->
            </div>
        </div>
    </aside>

