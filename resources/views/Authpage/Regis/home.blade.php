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

</head>
{{-- @php

try {
  $connonName = 'mysql';
  DB::connection()->getPdo($connonName);
  echo "เชื่อมต่อฐานข้อมูล MySQL สำเร็จ!";
} catch (\Exception $e) {
  die("ไม่สามารถเชื่อมต่อฐานข้อมูล MySQL: " . $e->getMessage());
}
@endphp  --}}
{{-- @php
    use Illuminate\Support\Facades\DB;

    try {
        $connectionName = 'oracle';
        $dbName = DB::connection($connectionName)->select('SELECT ora_database_name FROM dual')[0]->ora_database_name;
        echo "Connected successfully to Oracle database named: $dbName";
    } catch (\Exception $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
@endphp  --}}
{{-- @php
try {
  $ldap_host = env('LDAP_HOST');
  $ldap_port = env('LDAP_PORT');
  $ldap_connection = ldap_connect($ldap_host, $ldap_port);

  if ($ldap_connection) {
      $username = 'boonyarit_soo'; // Replace with the username you want to check
      $base_dn = "ou=users,dc=nacc,dc=go,dc=th"; // Update with your LDAP base DN

      // Set LDAP options using values from the environment variables
      ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, env('LDAP_PROTOCOL_VERSION'));
      ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, env('LDAP_REFERRALS'));

      $bind = ldap_bind($ldap_connection, "cn=$username,$base_dn", 'f3*Z29$Q%It^');

      if ($bind) {
          echo "Username $username exists in LDAP.";
      } else {
          echo "Username $username does not exist in LDAP.";
      }

      ldap_close($ldap_connection);
  } else {
      echo 'LDAP connection failed';
  }
} catch (\Exception $e) {
  echo 'Connection failed: ' . $e->getMessage();
}
@endphp --}}


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
                    <select class="form-control w-100 fadeIn first" name="department_id" id="department_id"
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

            <div class="form-group row" id='sch'>
                <div class="col-sm-4" align="right">
                    <label class="control-label fadeIn first"><span class="required">*</span> สถานศึกษา
                    </label>
                </div>
                <div class="col-sm-7" align="left">
                    <select class="form-control w-100 fadeIn first" name="extender_id" id="extender_id" required="">
                        <option value="" selected disabled>-- เลือกสถานศึกษา --</option>
                    </select>

                </div>

            </div>
            <div class="form-group row" id='sch1' style="display: none;">
                <div class="col-sm-4" align="right">
                    <label class="control-label fadeIn first"><span class="required">*</span> สถานศึกษาย่อย
                    </label>
                </div>
                <div class="col-sm-7" align="left">
                    <select class="form-control w-100 fadeIn first" name="extender_1_id" id="extender_1_id"
                        required="">
                        <option value="" selected disabled>-- เลือกสถานศึกษา --</option>
                    </select>
                </div>

            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var sch1Div = document.getElementById('sch1');
                    document.getElementById('department_id').addEventListener('change', function() {
                        var selectedDepartmentCode = this.value;
                        var schoolSelect = document.getElementById('extender_id');

                        schoolSelect.innerHTML = '<option value="" selected disabled>-- เลือกสถานศึกษา --</option>';
                        var extender2 = {!! $extender2Json !!};
                        if (selectedDepartmentCode == '5') {
                            extender2.forEach(function(exten) {
                                if (exten.item_group_id == 2) {
                                    var option = document.createElement('option');
                                    option.value = exten.extender_id;
                                    option.textContent = exten.name;
                                    schoolSelect.appendChild(option);
                                    sch1Div.style.display = 'none';
                                }
                            });
                        } else {
                            extender2.forEach(function(exten) {
                                if (exten.item_group_id == 1 && exten.item_parent_id == null) {
                                    var option = document.createElement('option');
                                    option.value = exten.extender_id;
                                    option.textContent = exten.name;
                                    schoolSelect.appendChild(option);
                                    sch1Div.style.display = '';
                                }
                            });
                        }

                    });
                    document.getElementById('extender_id').addEventListener('change', function() {
                        var selectedextender_idCode = this.value;
                        var schoolSelect1 = document.getElementById('extender_1_id');
                        schoolSelect1.innerHTML =
                            '<option value="" selected disabled>-- เลือกสถานศึกษา --</option>';
                        var extender_1 = {!! $extender_1Json !!};
                        var foundMatch = false;
                        extender_1.forEach(function(exten1) {
                            if (exten1.item_group_id == 1 && exten1.item_parent_id ==
                                selectedextender_idCode) {
                                var option1 = document.createElement('option');
                                option1.value = exten1.extender_id;
                                option1.textContent = exten1.name;
                                schoolSelect1.appendChild(option1);
                                foundMatch = true;
                            }

                        });
                        if (!foundMatch) {
                            var option1 = document.createElement('option');
                            option1.value = 'default_value'; // Provide a suitable default value
                            option1.textContent = 'Default School Name'; // Provide a suitable default name
                            schoolSelect1.appendChild(option1);
                        }
                        sch1Div.style.display = foundMatch ? '' : 'none';
                    });


                });
            </script>
            <div class="form-group row">
                <div class="col-sm-4" align="right">
                    <label class="control-label fadeIn second"><span class="required">*</span> รหัสบัตรประชาชน</label>
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
                <a  href="{{ asset('uplade/แบบฟอร์มการขอ-เปลี่ยนสิทธิ์ฯ.pdf') }}"  target="_blank" for="submit_path" class="btn btn-info">ดาวโหลด เอกสารขอเป็น Admin <i class="fa fa-file fadeIn fourth"></i></a>
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





            <input type="submit" class="fadeIn fourth" value="Log In">

        </form>

        @if (Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
        @endif
        @if (Session::has('fail'))
            <div class="alert alert-danger">{{ Session::get('fail') }}</div>
        @endif
    </div>

</div>
