<!doctype html>
<html lang="en">

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
    <link rel="icon" type="image/png" href="{{ asset('upload/logo/logo.png') }}">
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

    <link rel="stylesheet" href="{{ asset('/w3/w3.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        @font-face {
            font-family: 'DB-Heavent';
            src: url('{{ asset('fonts/DB-Heavent-v3.2.1.woff2') }}') format('woff2'),
                url('{{ asset('fonts/DB-Heavent-v3.2.1.woff') }}') format('woff'),
                url('{{ asset('fonts/DB-Heavent-v3.2.1.ttf') }}') format('truetype');

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
            background-color: {{ $depart->color }};
            color: rgba(255, 255, 255, 0.8);
        }

        .text-primary {
            color: {{ $depart->color }} !important;
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

<body>


    @include('layouts.department.layout.header')
    @include('layouts.department.layout.navadmin')


    @yield('contentdepartment')


    @include('layouts.department.layout.footer')
</body>

</html>
