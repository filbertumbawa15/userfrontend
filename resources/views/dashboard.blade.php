<!doctype html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Dashboard Of User Management</title>
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='' rel='stylesheet'>
    <style>
        #main_cont {
            border-radius: 16px;
        }

        .title-name {
            padding: 32px;
            display: inline-flex;
            width: 100%;
            justify-content: space-between;
            border-radius: 12px 12px 0 0;
        }

        .company-id {
            display: flex;
            flex-direction: row;
        }

        .company-img {
            height: 80px;
            width: 80px;
            margin-right: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 26px;
            background-color: white;
        }

        .company-img img {
            max-width: 80% !important;
            max-height: 80% !important;
            width: auto;
            height: auto;
        }

        .company-name {
            max-width: 75%;
            margin-right: 16px;
            height: fit-content;
            margin: auto 0;
        }

        .company-name h3 {
            color: #fff;
            font-weight: normal;
            line-height: 21px !important;
            text-align: left !important;
        }

        .company-name h2 {
            font-size: 16px !important;
            line-height: 24px !important;
            font-weight: 600;
            text-align: left !important;
        }

        .pull-right {
            display: flex;
            flex-direction: row;
            margin: auto 0;
        }

        .pull-right a {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 13px !important;
            border-radius: 6px;
            margin-left: 8px;
            padding: 11px 15px;
            text-align: center;
        }

        .pull-right a i {
            height: 16px;
            width: 16px;
            margin-right: 4px;
            display: flex;
            align-items: center;
        }

        #header .main_title {
            font-weight: 600;
            font-size: 20px;
            line-height: 30px;
            margin-left: -8px;
        }

        #header {
            background: #f5f5f5;
            padding: 20px 40px;
            border-radius: 0 0 0 12px;
        }

        #navigation li {
            border-radius: 16px;
            border: 8px solid #f5f5f5;
            background: #fff !important;
        }

        #navigation li:hover {
            background: #00468019 !important;
        }

        #navigation li .inner {
            height: 100%;
            width: 100%;
            padding: 3px 5px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 20px rgb(0 0 0 / 5%);
            transition: transform .3s ease-in-out;
        }

        #navigation li .inner:hover {
            -webkit-transform: scale(1.1);
            transform: scale(1.1) ease-in-out;
            border-radius: 12px;
        }

        #navigation li.active {
            border-radius: 24px;
            border: 12px solid #f5f5f5;
            background: #00468019 !important;
        }

        #navigation li.active .inner {
            height: 100%;
            width: 100%;
            border-radius: 12px;
        }

        #navigation li .inner img {
            height: 80px;
            width: auto;
        }

        #navigation li .inner .carrow {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        #navigation li .inner .carrow a {
            font-weight: 500;
            font-size: 13px;
            line-height: 20px;
            color: #616161;

            width: 100%;
            overflow: hidden;
            text-align: center;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        #main {
            border-radius: 0 0 12px 12px;
        }

        #main .content .content-title {
            display: flex;
            flex-direction: column;
            padding: 16px 0px;
        }

        #main .content .content-title h2 {
            font-weight: 600;
            font-size: 20px;
            line-height: 30px;
            padding: 0px;
        }

        #main .content .content-title small {
            font-weight: 400;
            font-size: 16px;
            line-height: 28px;
            padding: 0px;
        }

        #main .content .content-title small i {
            margin-right: 8px;
        }

        #main .content .role_box {
            margin: 8px 0px;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 0 20px rgb(0 0 0 / 5%);
        }

        #main .content .role_box .rolename {
            font-size: 14px;
            line-height: 21px;
        }

        #main .content .role_box .unitname {
            font-size: 12px;
            line-height: 18px;
        }

        #main,
        .panel {
            background: #eee;
        }


        @media (max-width: 575.98px) {
            .pull-right {
                flex-direction: column;
            }

            .pull-right a {
                margin: 2px 0;
            }
        }

        @media (max-width: 459.98px) {
            .title-name {
                display: flex;
                flex-direction: column;
            }

            .company-img {
                width: 48px;
                height: 48px;
            }

            .pull-right {
                flex-direction: row;
                width: 100%;
                margin-top: 16px;
            }

            .pull-right a {
                width: 50%;
                padding: 12px 16px;
            }

            .pull-right a:nth-child(1) {
                margin: 0px 8px 0px 0px;
            }

            .pull-right a:nth-child(2) {
                margin: 0px 0px 0px 8px;
            }
        }

        .bigIcon {
            font-size: 5em;
        }

        @import url('https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Source+Sans+Pro:ital,wght@0,400;0,600;0,700;0,900;1,400;1,600;1,700;1,900&display=swap');

        #navigation,
        ol,
        ul {
            list-style: none
        }

        .link-right a:hover,
        .small-box-footer,
        a,
        a.small-box-footer,
        a:hover,
        div,
        span {
            text-decoration: none
        }

        blockquote,
        body,
        dd,
        div,
        dl,
        dt,
        fieldset,
        form,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        html,
        input,
        li,
        ol,
        p,
        pre,
        td,
        textarea,
        th,
        ul {
            margin: 0;
            padding: 0
        }

        table {
            border-collapse: collapse;
            border-spacing: 0
        }

        abbr,
        acronym,
        fieldset,
        img {
            border: 0
        }

        input {
            border: 1px solid #b0b0b0;
            padding: 3px 5px 4px;
            color: #979797;
            width: 190px
        }

        address,
        caption,
        cite,
        code,
        dfn,
        th,
        var {
            font-style: normal;
            font-weight: 400
        }

        caption,
        th {
            text-align: left
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-size: 100%;
            font-weight: 400
        }

        q:after,
        q:before {
            content: ''
        }

        .clr {
            clear: both
        }

        body,
        html {
            overflow-x: hidden !important;
            font-family: 'Source Sans Pro', sans-serif;
            -webkit-font-smoothing: antialiased;
            height: 100%;
            background: url(../img/pattern/pat_03.png) fixed, url(../img/login-bg.jpg) no-repeat fixed #f9f9f9;
            font-size: 14px;
            background-size: 5px 5px, cover
        }

        #main_cont {
            background: rgba(255, 255, 255, .3);
            padding: 20px
        }

        .company-pattern {
            background: url(../img/pattern/pat_04.png) #0052A2 !important;
        }

        #main {
            background: #eee
        }

        .well {
            background: #fff;
            background: rgba(255, 255, 255, .95);
            padding: 20px
        }

        @-webkit-keyframes slideOut {
            0% {
                top: -30px;
                opacity: 0
            }

            100% {
                top: 0;
                opacity: 1
            }
        }

        @-moz-keyframes slideOut {
            0% {
                top: -30px;
                opacity: 0
            }

            100% {
                top: 0;
                opacity: 1
            }
        }

        @-o-keyframes slideOut {
            0% {
                top: -30px;
                opacity: 0
            }

            100% {
                top: 0;
                opacity: 1
            }
        }

        @-ms-keyframes slideOut {
            0% {
                top: -30px;
                opacity: 0
            }

            100% {
                top: 0;
                opacity: 1
            }
        }

        @keyframes slideOut {
            0% {
                top: -30px;
                opacity: 0
            }

            100% {
                top: 0;
                opacity: 1
            }
        }

        .content h2,
        h1.main_title {
            font-size: 22px;
            color: #333;
            padding: 0 0 20px;
            margin: 0
        }

        #header {
            float: right;
            padding: 20px;
            background: #f9f9f9;
            min-height: 360px
        }

        #navigation {
            display: block
        }

        #navigation li,
        #navigation li.active {
            display: inline;
            height: 160px;
            color: #fff;
            border-right: #F9F9F9 10px solid;
            border-bottom: #F9F9F9 10px solid;
            padding: 0;
            cursor: pointer
        }

        #navigation li.active>.inner {
            min-height: 80px
        }

        .small-box-footer {
            position: absolute;
            text-align: center;
            padding: 3px 0;
            color: #fff;
            color: rgba(255, 255, 255, .8);
            display: block;
            font-size: 14px;
            z-index: 10;
            background: rgba(0, 0, 0, .1);
            bottom: 0;
            width: 100%
        }

        .small-box-footer:hover {
            color: #fff;
            background: rgba(0, 0, 0, .15)
        }

        #navigation li {
            background: #B0B0B0
        }

        #navigation li.admin,
        #navigation li:hover {
            background: #849696
        }

        #navigation li a:hover {
            color: #fff
        }

        #navigation li.admin:hover {
            background: #313838
        }

        #navigation li.akad,
        #navigation li.siakad {
            background: #2849b5
        }

        #navigation li.akad:hover,
        #navigation li.siakad:hover {
            background: #1F3A93
        }

        #navigation li.aset {
            background: #39cccc
        }

        #navigation li.aset:hover {
            background: #2BA7A7
        }

        #navigation li.sdm {
            background: #F56954
        }

        #navigation li.sdm:hover {
            background: #F33F24
        }

        #navigation li.keuangan {
            background: #00A65A
        }

        #navigation li.keuangan:hover {
            background: #00743E
        }

        #navigation li.h2h,
        #navigation li.keu,
        #navigation li.keuakad {
            background: #00A65A
        }

        #navigation li.h2h:hover,
        #navigation li.keu:hover,
        #navigation li.keuakad:hover {
            background: #05874B
        }

        #navigation li.dashboard {
            background: #14B7D9
        }

        #navigation li.dashboard:hover {
            background: #128AC2
        }

        #navigation li.pdpt {
            background: url(../images/icon/pdpt_small.png) left 8px no-repeat
        }

        #navigation li.pdpt:hover {
            background: #0098BD
        }

        #navigation li.pmb {
            background: #F39C12
        }

        #navigation li.pmb:hover {
            background: #CF8613
        }

        #navigation li.spmb {
            background: #F39C12
        }

        #navigation li.spmb:hover {
            background: #CF8613
        }

        #navigation li.helpdesk {
            background: #85144b
        }

        #navigation li.helpdesk:hover {
            background: #590E32
        }

        #navigation li.alumni,
        #navigation li.cac {
            background: #932ab6
        }

        #navigation li.alumni:hover,
        #navigation li.cac:hover {
            background: #71208C
        }

        #navigation li.kemahasiswaan {
            background: #5FDCA9
        }

        #navigation li.kemahasiswaan:hover {
            background: #0FB290
        }

        #navigation li .inner {
            padding: 10px
        }

        .content {
            float: left;
            padding-bottom: 10px;
            width: 100%;
            height: auto
        }

        .content div#img_admin,
        .content div#img_akad,
        .content div#img_alum,
        .content div#img_aset,
        .content div#img_password,
        .content div#img_pdpt,
        .content div#img_perpus,
        .content div#img_pmb,
        .content div#img_profil,
        .content div#img_sdm,
        .content div#img_siakad,
        .content div#img_spmb {
            width: 32px;
            height: 32px;
            padding-top: 25px;
            margin-right: 15px
        }

        #navigation li>.icon {
            position: absolute;
            top: auto;
            bottom: 5px;
            right: 5px;
            z-index: 0;
            font-size: 90px;
            color: rgba(0, 0, 0, .15)
        }

        .content div#img_admin {
            background: url(../images/icon/admin.png) center center no-repeat
        }

        .content div#img_akad,
        .content div#img_siakad {
            background: url(../images/icon/akad.png) center center no-repeat
        }

        .content div#img_pdpt {
            background: url(../images/icon/pdpt.png) center center no-repeat
        }

        .content div#img_pmb,
        .content div#img_spmb {
            background: url(../images/icon/pmb.png) center center no-repeat
        }

        .content div#img_profil {
            background: url(../images/icon/profil.png) center center no-repeat
        }

        .content div#img_password {
            background: url(../images/icon/password.png) center center no-repeat
        }

        .content div#img_h2h,
        .content div#img_kemhs,
        .content div#img_keu {
            background: url(../images/icon/keu.png) center center no-repeat;
            width: 32px;
            height: 32px;
            padding-top: 25px;
            margin-right: 15px
        }

        .content div#img_sdm {
            background: url(../images/icon/peg.png) center center no-repeat
        }

        .content div#img_alum {
            background: url(../images/icon/ucc.png) center center no-repeat
        }

        .content div#img_aset {
            background: url(../images/icon/aset.png) center center no-repeat
        }

        .content div#img_perpus {
            background: url(../images/icon/perpus.png) center center no-repeat
        }

        .content h2 {
            float: left;
            padding: 20px
        }

        .panel {
            float: left;
            width: 100%;
            padding: 0;
            background: #eee;
            box-shadow: none;
            border: none;
            overflow-y: auto;
            overflow-x: hidden;
            margin-top: -150%;
            opacity: 0;
            -webkit-transition: opacity .6s ease-in-out;
            -moz-transition: opacity .6s ease-in-out;
            -o-transition: opacity .6s ease-in-out;
            -ms-transition: opacity .6s ease-in-out;
            transition: opacity .6s ease-in-out
        }

        .panel:target {
            opacity: 1;
            margin-top: 0
        }

        .title-name {
            background: #01740B;
            padding: 10px 20px;
            cursor: pointer
        }

        .link-right {
            margin-top: 10px
        }

        .link-right a {
            padding: 5px 10px;
            background: rgba(0, 0, 0, .2)
        }

        .link-right a:hover {
            color: #fff;
            background: rgba(0, 0, 0, .4)
        }

        .role_box {
            padding: 20px;
            background: right 20px center no-repeat #fff;
            border-bottom: 1px solid #ddd;
            float: left;
            width: 100%;
            color: #999;
            line-height: 1;
            cursor: pointer;
            transition: .5s
        }

        .role_box:hover {
            background: #0052A2;
            color: #fff
        }

        .role_box:hover span.rolename {
            color: #fff
        }

        span.role_container {
            padding: 5px 0;
            cursor: pointer
        }

        table.role_container td {
            padding: 5px 0
        }

        span.rolename {
            font-weight: 700;
            color: #0052A2
        }

        #admin:target~#header #navigation #link-admin,
        #akad:target~#header #navigation #link-akad,
        #out:target~#header #navigation #link-out,
        #profil:target~#header #navigation #link-profil {
            background: #000;
            color: #fff
        }

        #bottom {
            float: left;
            position: relative
        }

        #bottom span {
            float: left;
            margin-right: 15px;
            padding-left: 20px;
            cursor: pointer
        }

        .logo-menu .img-menus img,
        .logo-menus {
            margin: 0;
            padding: 0
        }

        #bottom span:hover {
            text-decoration: underline;
            color: red
        }

        #bottom span.profil {
            background: url(../img/icon/profil_small.png) left center no-repeat
        }

        #bottom span.password {
            background: url(../img/icon/password_small.png) left center no-repeat
        }

        #bottom span.out {
            background: url(../img/icon/out_small.png) left center no-repeat
        }

        .error {
            color: red
        }

        .success {
            color: green
        }

        .logo-menus {
            height: auto;
            max-height: 125px;
            overflow: hidden;
            width: 100%;
            background: 0 0
        }

        div.img-menus {
            height: 100px;
            max-height: 100px !important;
            overflow: hidden;
            width: 50%;
            background: #FFF
        }

        .login-bottom {
            background: url(../img/elba/elba_03.png) top no-repeat;
            display: block;
            height: 35px;
            position: relative;
            margin: 0 auto;
            padding: 0 auto
        }

        a {
            color: #fff;
            font-size: 18px
        }

        .teks-colorid01 {
            color: #0052A2
        }

        .teks-colorid02 {
            color: #ffcc2a
        }

        .teks-colorid03 {
            color: #20915E
        }

        .teks-colorid04 {
            color: #015C9B
        }

        .teks-white {
            color: #FFF
        }

        .margin-up10px {
            margin-top: 10px
        }

        .margin-up20px {
            margin-top: 20px
        }

        .margin-up30px {
            margin-top: 30px
        }

        .background-01 {
            background: #015593
        }

        .border-bottom-dotted {
            height: 3px;
            padding-top: 5px;
            border-bottom: 1px dotted #CCC;
            width: 90%;
            left: 0
        }

        .title-name img {
            float: left;
            height: 50px
        }

        .title-name .company-name {
            display: inline-block
        }

        .title-name .company-name h1 {
            text-transform: uppercase;
            font-size: 24px;
            font-weight: 700;
            color: #fff
        }

        .title-name .company-name h2 {
            text-transform: uppercase;
            font-size: 18px;
            color: #fff
        }

        .title-name .link-right {
            float: right
        }

        @media (max-width: 768px) {
            #main_cont {
                padding: 0 !important
            }

            .title {
                display: none
            }

            .title-name .link-right {
                float: none
            }
        }

        @media (max-width: 546px) {
            .title-name img {
                float: none;
                height: 120px
            }

            .title-name,
            .title-name .company-name {
                text-align: center
            }
        }

        .icon-locked {
            position: absolute;
            right: 10px;
            bottom: 5px;
            font-size: 20px
        }

        body,
        html,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: "Poppins"
        }
    </style>
    <script type='text/javascript' src=''></script>
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
    <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js'></script>
</head>

<body oncontextmenu='return false' class='snippet-body'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <!-- by https://hostcwb.com.br/tutoriais/post/como-criar-box-shadow-com-icones-utilizando-bootstrap -->

    <div class="container" style="min-height:100vh">
        <div class="row g-2 mx-5 list-modul">
            <div id="id_cont" class="col-md-10 col-md-push-1 center-block center-self-block" style="margin-top:186px;margin-bottom:20px">
                <div class="title-name company-pattern company-pattern-custom">
                    <div class="company-id">
                        <div class="company-img">
                            <img src="assets/img/usi.png">
                        </div>
                        <div class="company-name">
                            <h3>Sistem Informasi Akademik</h3>
                            <h2>Siantar</h2>
                            <h3>https://unsi.ac.id/</h3>
                        </div>
                    </div>
                    <div class="pull-right link-right">
                        <a href="https://unsi.ac.id/dashboard/profile"><i class="ion ion-person"></i> Halaman Profil</a>
                        <a href="https://unsi.ac.id/admin/logout" class="out"><i class="ion ion-log-out"></i> Keluar</a>
                    </div>
                </div>
                <div id="main">
                    <div id="header" class="col-sm-12 col-xs-12">
                        <h1 class="main_title">Selamat Datang Administrator (Super Administrator)</h1>

                    </div>
                    <div class="clr"></div>
                </div>

            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- Sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Script -->
    <script src="{{ asset('dist/js/script.js') }}"></script>

    <script type='text/javascript'>
        $(document).ready(function() {
            const accessToken = getCookie('access-token')
            const userdata = JSON.parse(getCookie('user'))
            $.ajax({
                url: `{{ config('app.api_url') }}checkaccessmodule/${userdata.uuid}`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    // $('.list-modul #id_cont').html("")
                    $.each(response, (index, detail) => {
                        let moduleRow = $(`
                        <div class="col-md-3">
                            <div class="rounded-3 shadow h-100 px-1">
                                <a href="/admin/${detail.folder}"><span class="d-block text-center"><i class="bigIcon ${detail.module_icon}"></i></span></a>
                                <span class="d-block text-center p-2 text-secondary">${detail.modul_name}</span>
                            </div>
                        </div>
                    `)
                        $('.list-modul #id_cont #main #header').append(moduleRow)
                    })
                }
            })
        });
    </script>
</body>

</html>