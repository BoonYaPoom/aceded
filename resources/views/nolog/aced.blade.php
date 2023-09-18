<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>หลักสูตรต้านทุจริตศึกษา Anti-Corruption Education</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="{{ asset('lac/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('lac/logo.png') }}" />
    <link href="{{ asset('/lac/css/css/theme.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('/lac/css/font-awesome/css/fontawesome-all.min.css') }}">



    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit|Bai+Jamjuree|Kanit">

    <style>
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Kanit", "Prompt", sans-serif
        }

        #calendar {
            max-width: 1000px;
            margin: 0 auto;
        }
    </style>
</head>

<body>

    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main">

        <!-- Pricing Section -->
        <div class="container space-top-1">
            <!-- space-top-3 -->
            <div class="row d-flex">

                <div class="col-md-12 pl-md-0">
                    <div class="mb-2 text-center">
                        <!--  -->
                       <a href="{{route('departmentwmspage') }}"> <h3 class="h3 mb-4 text-primary-theme heading-subject-text">หลักสูตรต้านทุจริตศึกษา
                            Anti-Corruption Education</h3></a>
                    </div>
                    <div class="row">

                        @foreach ($department->sortBy('department_id') as $depart)
                            @if ($depart->department_status == 1)
                                <div class="col-sm-12 col-md-6 col-lg-4 pb-3">
                                    <!-- Product -->
                                    <div class="card">
                                        <div class="position-relative  img-hover">
                                            <a href="{{ $depart->name_en }}"><img class="card-img-top"
                                                    src="{{ asset($depart->name_short_th) }}"
                                                    alt="Image Description"></a>
                                        </div>
                                        <div class="card-body pt-4 px-3 pb-0 bg-theme-second">
                                            <div class="mb-2 text-center">
                                                <a href="/childhood">
                                                    <h2 class="h5 mb-0 fix-line  text-black-70 mb-1">
                                                        {{ $depart->name_th }}</h2>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- End Product -->
                                </div>
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

    </main>
    <!-- ========== END MAIN CONTENT ========== -->
    <!-- ========== FOOTER ========== -->
    <footer class="mt-4">
        <!-- Lists -->
        <div class="border-0" style="background-color: #2A2A2A;">
            <!-- Copyright -->
            <div class="border-0 bg-theme-primary">
                <div class="container py-3 text-center">
                    <div class="row d-flex justify-content-sm-between">
                        <div class="col-sm-12 mb-sm-0">
                            <h5 class="small text-white mb-0" style="letter-spacing: 2px !important;">สงวนลิขสิทธิ์
                                โดยสำนักงานคณะกรรมการป้องกันและปราบปรามการทุจริตแห่งชาติ </h5>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Copyright -->
        </div>
    </footer>




    <!-- JS Global Compulsory -->
    <script src="{{ asset('/lac/css/font-awesome/css/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('/lac/css/font-awesome/css/jquery-migrate/dist/jquery-migrate.min.js') }}"></script>




</body>

</html>
