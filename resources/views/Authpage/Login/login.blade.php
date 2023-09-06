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


      <link rel="stylesheet" href="{{ asset('/stylesheets/logincss/logincss.css') }}">

  </head>

  @php
  use Illuminate\Support\Facades\DB;
  
  try {
      $connectionName = 'oracle';
      $dbName = DB::connection($connectionName)->select("SELECT ora_database_name FROM dual")[0]->ora_database_name;
      echo "Connected successfully to Oracle database named: $dbName";
  } catch (\Exception $e) {
      echo 'Connection failed: ' . $e->getMessage();
  }
  @endphp
  
  <div class="wrapper fadeInDown">
      <div id="formContent">
          <!-- Tabs Titles -->
          <h2 class="active">
              <a class="navbar-brand" href="{{ route('homelogin') }}">Sign In</a>
          </h2>
          <h2 class="inactive underlineHover">
              <a class="navbar-brand" href="{{ route('homeRegis') }}">Sign Up </a>
          </h2>

          <!-- Icon -->
          <div class="fadeIn first">
              <img src="{{ asset('lac/logo.png') }}" id="icon" alt="User Icon" />
          </div>

          <!-- Login Form -->
          <form action="{{ route('login-user') }}" method="post" accept-charset="utf-8">
              @csrf

              <input type="text" class="fadeIn second" name="username" id="username" placeholder="รหัสผู้ใช้"
                  aria-label="Email" aria-describedby="username" required
                  data-msg="กรุณากรอกอีเมล์ให้ถูกต้อง ลองอีกครั้ง" data-error-class="u-has-error"
                  data-success-class="u-has-success">

              <span class="text-danger">
                  @error('username')
                      {{ $message }}
                  @enderror
              </span>

              <input type="password" class="fadeIn third" name="password" id="password" placeholder="********"
                  aria-label="Password" aria-describedby="signinPasswordLabel" required
                  data-msg="กรุณากรอกรหัสผ่านให้ถูกต้อง ลองอีกครั้ง" data-error-class="u-has-error"
                  data-success-class="u-has-success">

              <span class="text-danger">
                  @error('password')
                      {{ $message }}
                  @enderror
              </span>
              <br>
              <div class="row mb-3">
                  <div class="col-6">
                      <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="remember-me" onclick="myFunction()">
                          <label class="form-check-label" for="remember-me">Remember Me</label>
                      </div>

                  </div>

              </div>

              <br>
              <input type="submit" class="fadeIn fourth" value="Log In">

          </form>
          <script>
              function myFunction() {
                  var x = document.getElementById("password");
                  if (x.type === "password") {
                      x.type = "text";
                  } else {
                      x.type = "password";
                  }
              }
          </script>
          @if (Session::has('message'))
              <div class="alert alert-success">{{ Session::get('message') }}</div>
          @endif
          @if (Session::has('fail'))
              <div class="alert alert-danger">{{ Session::get('fail') }}</div>
          @endif
      </div>

  </div>
