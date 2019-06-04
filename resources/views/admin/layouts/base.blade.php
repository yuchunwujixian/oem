<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') | {{ config('config_base.site_name') }}管理后台</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="/plugins/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/plugins/AdminLTE/AdminLTE.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="/plugins/AdminLTE/skins/skin-blue.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="/libs/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    {{--dataTabels--}}
    {{--<link href="/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet">--}}
    <link href="/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">

    {{--loding--}}
    <link href="/dist/css/load/load.css" rel="stylesheet">
    <link href="/plugins/bootstrap-select-1.13.2/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <!-- iCheck -->
    <link rel="stylesheet" href="/plugins/iCheck/square/blue.css">
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css" >
    @yield('css')
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div id="loading">
    <div id="loading-center">
        <div id="loading-center-absolute">
            <div class="object" id="object_four"></div>
            <div class="object" id="object_three"></div>
            <div class="object" id="object_two"></div>
            <div class="object" id="object_one"></div>
        </div>
    </div>
</div>
<div class="wrapper">

    <!-- Main Header -->
    @include('admin.layouts.mainHeader')
            <!-- Left side column. contains the logo and sidebar -->
    @include('admin.layouts.mainSidebar')
            <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            {{--<h1>--}}
              {{--@yield('pageHeader')--}}
              {{--<small>@yield('pageDesc')</small>--}}
            {{--</h1>--}}
            {{--<ol class="breadcrumb">--}}
              {{--<li><a href="/admin"><i class="fa fa-dashboard"></i> 控制面板</a></li>--}}
              {{--<li class="active">Here</li>--}}
            {{--</ol>--}}
            <h6>
              {{--  @if(Request::is('admin/log-viewer*'))
                    仪表盘
                @else
                    {!! Breadcrumbs::render(Route::currentRouteName()) !!}
                @endif--}}

            </h6>
        </section>

        <!-- Main content -->
        <section class="content">

            @yield('content')
                    <!-- Your Page Content Here -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Control Sidebar -->
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.0 -->
<script src="/js/jquery-2.0.0/jquery.min.js"></script>

<!-- Bootstrap 3.3.6 -->
<script src="/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/plugins/AdminLTE/app.min.js"></script>

<!-- dataTables -->
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="/plugins/tokenfield/dist/bootstrap-tokenfield.min.js"></script>
<script src="/plugins/bootstrap-select-1.13.2/dist/js/bootstrap-select.min.js"></script>
<!-- iCheck -->
<script src="/plugins/iCheck/icheck.min.js"></script>
<script src="/plugins/toastr/toastr.min.js"></script>
{!! Toastr::render() !!}
        <!-- Main Footer -->
@include('admin.layouts.mainFooter')
<script>
    loadShow = function(){
        $("#loading").show();
    };
    loadFadeOut=function(){
        $("#loading").fadeOut(500);
    };
    //select美化
    $('.selectpicker').selectpicker({
        width : 'auto'
    });
    //提示工具
    $("[data-toggle='tooltip']").tooltip();
    //全局ajax提交 csrf验证
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $('input:not(.origin)').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '10%' // optional
    });
    //定位提示信息位置为头部右侧
    toastr.options = {"positionClass":"toast-top-right"};
</script>
@yield('js')
</body>
</html>
