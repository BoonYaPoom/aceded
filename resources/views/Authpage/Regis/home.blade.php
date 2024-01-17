<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- End Required meta tags -->
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

    <link href="{{ asset('/stylesheets/theme/stylesheets/theme.min.css') }}" rel="stylesheet" data-skin="default">
    <link href="{{ asset('/stylesheets/theme/stylesheets/theme-dark.min.css') }}" rel="stylesheet" data-skin="dark">
    <link rel="stylesheet" href="{{ asset('/stylesheets/theme/stylesheets/custom.css') }}">
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
            background-color: #3063A0;
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


    <link rel="stylesheet" href="{{ asset('/stylesheets/logincss/register.css') }}">
    <script src="{{ asset('/javascript/vendor/jquery/jquery.min.js') }}"></script>
</head>

<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->
        {{-- <h2 class="inactive underlineHover">
            <a class="navbar-brand" href="{{ route('homelogin') }}">Sign In</a>
        </h2> --}}

        <h2 class="active">
            <a class="navbar-brand" href="{{ route('homeRegis') }}">Request</a>
        </h2>
        <div class="fadeIn first">
            <h3>ขอรหัสเป็น Admin สถานศึกษา</h3>

            <img src="{{ asset('LOGO/logo.png') }}" style="width: 40%; " id="icon" alt="User Icon" />

        </div>

        <br>
        <!-- Login Form -->

        <form action="{{ route('storeregisRequest', $uid) }}" method="POST" enctype="multipart/form-data"
            accept-charset="utf-8">
            @csrf
            <div class="form-group row">
                <div class="col-sm-4" align="right">
                    <label class="control-label fadeIn first"><span class="required">*</span> หน่วยงาน
                    </label>
                </div>
                <div class="col-sm-7" align="left">
                    <select class="form-control w-100 fadeIn first" name="departmentselect" id="departmentselect"
                        required="">
                        <option value="" selected disabled>-- เลือกหน่วยงาน --</option>
                        @foreach ($depart->sortBy('department_id') as $de)
                            @if ($de->department_id < 6)
                                <option value="{{ $de->department_id }}">{{ $de->name_th }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row" id='sch1' style="display: none;">
                <div class="col-sm-4" align="right">
                    <label class="control-label fadeIn first"><span class="required">*</span> สังกัด
                    </label>
                </div>
                <div class="col-sm-7" align="left">
                    <select id="extender_id" name="extender_id" class="form-control w-100 fadeIn first">
                        <option value="" selected disabled>-- เลือกสังกัด --</option>
                    </select>
                </div>
            </div>

            <div class="form-group row" id="sch2" style="display: none;">

                <div class="col-sm-4" align="right">
                    <label class="control-label fadeIn first"><span class="required">*</span> หน่วยงาน
                    </label>
                </div>
                <div class="col-sm-7" align="left">
                    <select id="extender_id2" name="extender_id2" class="form-control w-100 fadeIn first">
                        <option value="" selected disabled>-- เลือกหน่วยงาน --</option>
                    </select>
                </div>
            </div>

            <div class="form-group row" id="sch3" style="display: none;">
                <div class="col-sm-4" align="right">
                    <label class="control-label fadeIn first"><span class="required">*</span> หน่วยงานย่อย
                    </label>
                </div>
                <div class="col-sm-7" align="left">
                    <select id="extender_id3" name="extender_id3" class="form-control w-100 fadeIn first">
                        <option value="" selected disabled>-- เลือกหน่วยงานย่อย --</option>
                    </select>
                </div>
            </div>
            <div class="form-group row" id="sch4" style="display: none;">
                <div class="col-sm-4" align="right">
                    <label class="control-label fadeIn first"><span class="required">*</span>
                    </label>
                </div>
                <div class="col-sm-7" align="left">
                    <select id="extender_id4" name="extender_id4" class="form-control w-100 fadeIn first">
                        <option value="" selected disabled>-- เลือกหน่วยงานย่อย --</option>
                    </select>
                </div>
            </div>
            <div class="form-group row" id="sch5" style="display: none;">
                <label for="extender_id5" class="col-md-2"> </label>
                <div class="col-md-9 mb-3">
                    <select id="extender_id5" name="extender_id5" class="form-control w-100 fadeIn first">
                        <option value="" selected disabled>-- เลือกหน่วยงานย่อย --</option>
                    </select>
                </div>
            </div>
            @include('Authpage.Regis.jsregis')

            <div class="form-group row">
                <div class="col-sm-4" align="right">
                    <label class="control-label fadeIn second"><span class="required">*</span>
                        รหัสบัตรประชาชน</label>
                </div>
                <div class="col-sm-4" align="left">
                    <input type="text" name="citizen_id" value="" id="citizen_id"
                        class="form-control fadeIn second" maxlength="20" required="">
                    <div id="errorDub" class="required" style="display:none; font-size: 14px;padding-top: 4px">
                    </div>
                    @error('citizen_id')
                        <span class="badge badge-warning">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-4" align="right">
                    <label class="control-label fadeIn second"><span class="required">*</span> ชื่อ</label>
                </div>
                <div class="col-sm-4" align="left">
                    <input type="text" name="firstname" maxlength="150" autocomplete="off" value=""
                        id="firstname" class="form-control fadeIn second" required="">
                    @error('firstname')
                        <span class="badge badge-warning">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4" align="right">
                    <label class="control-label fadeIn third"><span class="required">*</span> นามสกุล</label>
                </div>
                <div class="col-sm-4" align="left">
                    <input type="text" name="lastname" maxlength="150" autocomplete="off" value=""
                        id="lastname" class="form-control fadeIn third" required="">
                    @error('lastname')
                        <span class="badge badge-warning">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-4" align="right">
                    <label class="control-label fadeIn fourth"><span class="required">*</span> เบอร์ติดต่อ</label>
                </div>
                <div class="col-sm-4" align="left">
                    <input type="text" name="telephone" maxlength="10" autocomplete="off" value=""
                        id="telephone" class="form-control fadeIn fourth" required="">
                    @error('telephone')
                        <span class="badge badge-warning">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4" align="right">
                    <label class="control-label fadeIn fourth"><span class="required">*</span> email</label>
                </div>
                <div class="col-sm-4" align="left">
                    <input type="text" name="email" autocomplete="off" value="" id="email"
                        class="form-control fadeIn fourth" required="">
                    @error('email')
                        <span class="badge badge-warning">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4" align="right">
                    <label class="control-label fadeIn fourth"><span class="required">*</span> ตำแหน่ง</label>
                    @error('pos_name')
                        <span class="badge badge-warning">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-4" align="left">

                    <input type="text" name="pos_name" maxlength="150" autocomplete="off" value=""
                        id="pos_name" class="form-control fadeIn third" required="">
                </div>
                @error('pos_name')
                    <span class="badge badge-warning">{{ $message }}</span>
                @enderror
            </div>

            <h3 class="fadeIn fourth">แนบเอกสารขอสมัคร
                <input type="file" name="submit_path" id="submit_path" class="inputfile fadeIn fourth"
                    accept=".pdf" onchange="showFileName()" />
                <label for="submit_path">Choose a file <i class="fa fa-file fadeIn fourth"></i></label>
                @error('submit_path')
                    <span class="badge badge-warning">{{ $message }}</span>
                @enderror
            </h3>
            <a href="{{ asset('uplade/แบบฟอร์มการขอ-เปลี่ยนสิทธิ์ฯ.pdf') }}" target="_blank" for="submit_path"
                class="btn btn-info">ดาวโหลด เอกสารขอเป็น Admin <i class="fa fa-file fadeIn fourth"></i></a>
            <h5 id="submit_name"></h5>
            <script>
                function showFileName() {
                    const fileInput = document.getElementById('submit_path');
                    const fileNameSpan = document.getElementById('submit_name');

                    if (fileInput.files.length > 0) {
                        fileNameSpan.textContent = fileInput.files[0].name;
                    } else {
                        fileNameSpan.textContent = '';
                    }
                }
            </script>
            <style>
                p {
                    font-size: 12px;
                    color: red;        
                }
            </style>


            <input type="submit" class="fadeIn fourth" value="Submit">
            <p>!!!------------เมื่อกรอกข้อมูลและส่งข้อมูลเรียบร้อยแล้ว ให้รอเช็คข้อความในกล่องข้อมูลบนหน้าเว็ป เพื่อเช็คสิทธิ์------------!!!</p>
        </form>

        @if (Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
        @endif
        @if (Session::has('fail'))
            <div class="alert alert-danger">{{ Session::get('fail') }}</div>
        @endif
    </div>

</div>
