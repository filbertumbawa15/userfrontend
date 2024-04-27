<!doctype html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Snippet - GoSNippets</title>
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='' rel='stylesheet'>
    <style>
        .bigIcon {
            font-size: 5em;
        }
    </style>
    <script type='text/javascript' src=''></script>
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
    <script type='text/javascript'
        src='https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js'></script>
</head>

<body oncontextmenu='return false' class='snippet-body'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <!-- by https://hostcwb.com.br/tutoriais/post/como-criar-box-shadow-com-icones-utilizando-bootstrap -->

    <div class="container">
        <div class="row mt-7 g-2 mx-5">

            <div class="col-md-3">
            </div>

            <div class="col-3">
            </div>

            <div class="col-3">
            </div>

            <div class="col-3">
            </div>

            <div class="col-3">
            </div>

            <div class="col-3">
            </div>

        </div>
        <div class="row g-2 mx-5 list-modul">

<!--             <div class="col-md-3">
                <div class=" bg-light rounded-3 shadow h-100 px-1">
                    <i class="float-end bi bi-star-fill text-info"></i>
                    <span class="d-block text-center"><i class="bigIcon bi bi-person-hearts"></i></span>
                    <span class="d-block text-center p-2 text-info">Teste com ícone de pessoa...</span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="rounded-3 shadow h-100 px-1">
                    <i class="float-end bi bi-star-fill text-secondary"></i>
                    <span class="d-block text-center"><i class="bigIcon bi bi-server"></i></span>
                    <span class="d-block text-center p-2 text-secondary">database info ...</span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="rounded-3 shadow h-100 px-1">
                    <i class="float-end bi bi-star-fill text-success"></i>
                    <span class="d-block text-center"><i class="bigIcon bi bi-star"></i></span>
                    <span class="d-block text-center p-2 text-success">star info ...</span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="rounded-3 shadow h-100 px-1">
                    <i class="float-end bi bi-star-fill text-success"></i>
                    <span class="d-block text-center"><i class="bigIcon bi bi-2-circle-fill"></i></span>
                    <span class="d-block text-center p-2 text-success">message info ...</span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="rounded-3 shadow h-100 px-1">
                    <i class="float-end bi bi-star-fill text-danger"></i>
                    <span class="d-block text-center"><i class="bigIcon bi bi-box-seam-fill"></i></span>
                    <span class="d-block text-center p-2 text-danger">box info ...</span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="rounded-3 shadow h-100 px-1">
                    <i class="float-end bi bi-star-fill text-success"></i>
                    <span class="d-block text-center"><i class="bigIcon bi bi-camera-fill"></i></span>
                    <span class="d-block text-center p-2 text-success">camera info ...</span>
                </div>
            </div> -->

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
        $(document).ready(function(){
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
                    $('.list-modul').html("")
                    $.each(response, (index, detail) => {
                        let moduleRow = $(`
                        <div class="col-md-3">
                            <div class="rounded-3 shadow h-100 px-1">
                                <span class="d-block text-center"><i class="${detail.module_icon}"></i></span>
                                <span class="d-block text-center p-2 text-secondary">${detail.modul_name}</span>
                            </div>
                        </div>
                    `)
                    $('.list-modul').append(moduleRow)
                    })
                }
            })
        });
    </script>
</body>

</html>