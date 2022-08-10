<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>پنل مدیریت - @yield('title')</title>
    <meta name="description" content="ایران استخدام">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/admin/css/fontiran.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/admin/img/logo.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/admin/img/logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/admin/img/logo.png">
    <link rel="stylesheet" href="/assets/admin/vendors/css/base/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/admin/vendors/css/base/seenboard-1.0.css">
    <link rel="stylesheet" href="/assets/admin/css/animate/animate.min.css">
    <link rel="stylesheet" href="/assets/admin/css/owl-carousel/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/admin/css/owl-carousel/owl.theme.min.css">
    <link rel="stylesheet" href="/assets/admin/css/bootstrap-select/bootstrap-select.css">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="/assets/admin/vendors/js/base/jquery.min.js"></script>
</head>
<body id="page-top">
<!-- Begin Preloader -->
<div id="preloader">
    <div class="canvas">
        <img src="/assets/admin/img/logo.png" alt="logo" class="loader-logo">
        <div class="spinner"></div>
    </div>
</div>
<div class="page">
    <header class="header">
        <nav class="navbar fixed-top">
            <div class="search-box">
                <button class="dismiss"><i class="ion-close-round"></i></button>
                <form id="searchForm" action="#" role="search">
                    <input type="search" placeholder="جستجو کنید ..." class="form-control">
                </form>
            </div>
            <div class="navbar-holder d-flex align-items-center align-middle justify-content-between">
                <!-- Begin Logo -->
                <div class="navbar-header">
                    <!-- Toggle Button -->
                    <a id="toggle-btn" href="#" class="menu-btn active">
                        <span></span>
                        <span></span>
                        <span></span>
                    </a>
                    <!-- End Toggle -->
                </div>
                <!-- End Logo -->
                <!-- Begin Navbar Menu -->
                <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center pull-right">
                    <!-- Search -->
                    <li class="nav-item d-flex align-items-center" style="display: none !important;"><a id="search" href="#"><i class="la la-search"></i></a></li>
                    <!-- End Search -->
                    <!-- Begin Notifications -->
                    <li class="nav-item dropdown"><a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><i class="la la-bell @if(isset($Notifications) && count($Notifications) > 0) animated infinite swing @endif"></i>@if(isset($Notifications) && count($Notifications) > 0)<span class="badge-pulse"></span>@endif</a>
                        <ul aria-labelledby="notifications" class="dropdown-menu notification">
                            <li>
                                <div class="notifications-header">
                                    <div class="notifications-overlay"></div>
                                    <img src="/assets/admin/img/notifications/01.jpg" alt="..." class="img-fluid">
                                </div>
                            </li>
                            @php $i = 0 @endphp

                            <li>
                                <a rel="nofollow" href="/admin/notification" class="dropdown-item all-notifications text-center">مشاهده همه اعلانها</a>
                            </li>
                        </ul>
                    </li>
                    <!-- End Notifications -->
                </ul>
                <!-- End Navbar Menu -->
            </div>
        </nav>
    </header>

    <div class="page-content d-flex align-items-stretch">
        <div class="default-sidebar">
            @include('admin.layout.sidebar')
        </div>

        <div class="content-inner">
            <div class="container-fluid" style="min-height: 1000px">
                @yield('page')
            </div>
            <footer class="main-footer" style="display: none;">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 d-flex align-items-center justify-content-xl-start justify-content-lg-start justify-content-md-start justify-content-center">
                        <p class="text-gradient-02"></p>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 d-flex align-items-center justify-content-xl-end justify-content-lg-end justify-content-md-end justify-content-center">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="documentation.html">مستندات</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="changelog.html">آپدیت ها</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </footer>

            <a href="#" class="go-top"><i class="la la-arrow-up"></i></a>
        </div>
    </div>
    @include('admin.layout.modal')

    @include('admin.layout.modal')
</div>
<script src="/assets/admin/vendors/js/base/core.min.js"></script>
<script src="/assets/admin/vendors/js/nicescroll/nicescroll.min.js"></script>
<script src="/assets/admin/vendors/js/owl-carousel/owl.carousel.min.js"></script>
<script src="/assets/admin/vendors/js/noty/noty.min.js"></script>
<script src="/assets/admin/vendors/js/app/app.min.js"></script>
<script src="/assets/admin/js/app/contact/contact.min.js"></script>
<script src="/assets/admin/vendors/js/bootstrap-select/bootstrap-select.js"></script>
@yield('script')
<script>
    $('.ck').each( function () {
        CKEDITOR.replace( this.id );
    });
</script>
<script>
    $(document).ready(function () {
        $('.bootstrap-tagsinput input').keydown(function( event ) {
            if ( event.which == 13 ) {
                $(this).blur();
                $(this).focus();
                return false;
            }
        });
    });
</script>
<script>
    $('.delete-item').click(function (e) {
        e.stopPropagation();
        e.preventDefault();
        $('#modal-delete').modal('show');
        let url = $(this).attr('href');
        $('#modal-delete').find('a').attr('href',url);
    })
</script>
<script>
    $('.confirm-item').click(function (e) {
        e.stopPropagation();
        e.preventDefault();
        $('#modal-confirm').modal('show');
        let url = $(this).attr('href');
        $('#modal-confirm').find('a').attr('href',url);
    })
</script>
<script>
            if($('#menu-{!! $section ?? '' !!}').find('ul').length > 0)
                $('#menu-{!! $section ?? '' !!}').find('a:first').attr('aria-expanded','true');
            $('#menu-{!! $section ?? '' !!}').find('a:first').next().addClass('show');
            $.each($('#menu-{!! $section ?? '' !!}').find('a'), function () {
                if($(this).attr('href') === '{!! $url ?? '' !!}') {
                    $(this).addClass('active');
                }
            });
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
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
</script>
</body>
</html>
