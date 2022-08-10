
<!DOCTYPE html>
<!--
Item Name: SeenBoard - Web App & Admin Dashboard Template
Version: 1.0
Author: Mt.rezaei
-->
<html lang="fa">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>پنل مدیریت</title>
    <meta name="description" content="ایران استخدام">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Font Iran licence -->
    <link rel="stylesheet" href="/assets/admin/css/fontiran.css">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/admin/img/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/admin/img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/admin/img/favicon-16x16.png">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="/assets/admin/vendors/css/base/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/admin/vendors/css/base/seenboard-1.0.css">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>
<body class="bg-white">
<!-- Begin Preloader -->
<div id="preloader">
    <div class="canvas">
        <img src="/assets/admin/img/logo.png" alt="logo" class="loader-logo">
        <div class="spinner"></div>
    </div>
</div>
<!-- End Preloader -->
<!-- Begin Container -->
<div class="container-fluid no-padding h-100">
    <div class="row flex-row h-100 bg-white">
        <!-- Begin Left Content -->
        <div class="col-xl-8 col-lg-6 col-md-5 no-padding">
            <div class="seenboard-bg background-01">
                <div class="seenboard-overlay overlay-01"></div>
                <div class="authentication-col-content mx-auto">
                    <h1 class="gradient-text-01">
                        پنل مدیریت
                    </h1>
                </div>
            </div>
        </div>
        <!-- End Left Content -->
        <!-- Begin Right Content -->
        <div class="col-xl-4 col-lg-6 col-md-7 my-auto no-padding">
            <!-- Begin Form -->
            <form method="post" action={{route('do.login')}}>
                @csrf
                <div class="authentication-form mx-auto">
                <h3>ورود به پنل مدیریت</h3>
                    <div class="group material-input">
                        <input type="text" name="user_name" required>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>نام کاربری</label>
                    </div>
                    <div class="group material-input">
                        <input type="password" name="password" required>
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>رمز عبور</label>
                    </div>
                <div class="row">
                    <div class="col text-left">
                        <div class="styled-checkbox">
                            <input type="checkbox" name="remember" id="remeber">
                            <label for="remeber">مرا به خاطر بسپار</label>
                        </div>
                    </div>
              {{--      <div class="col text-right">
                        <a href="/admin/forget">فراموشی رمز عبور؟</a>
                    </div>--}}
                </div>
                <div class="sign-btn text-center">
                    <button type="submit" class="btn btn-lg btn-gradient-01">
                        ورود
                    </button>
                </div>
            </div>
            </form>
            <!-- End Form -->
        </div>
        <!-- End Right Content -->
    </div>
    <!-- End Row -->
</div>
<!-- End Container -->
<!-- Begin Vendor Js -->
<script src="/assets/admin/vendors/js/noty/noty.min.js"></script>
<script src="/assets/admin/vendors/js/base/jquery.min.js"></script>
<script src="/assets/admin/vendors/js/base/core.min.js"></script>
<!-- End Vendor Js -->
<!-- Begin Page Vendor Js -->
<script src="/assets/admin/vendors/js/app/app.min.js"></script>

</script>
@if(session('msg') != null && session('msg') != '')
    <script>
        new Noty({
            type: 'notification',
            layout: 'topLeft',
            text: '{!! session('msg') !!}',
            progressBar: true,
            timeout: 2500,
            animation: {
                open: 'animated bounceInLeft',
                close: 'animated bounceOutLeft'
            }
        }).show()
    </script>
@endif
<script>
<!-- End Page Vendor Js -->
</body>
</html>
