<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ asset('index2.html') }}"><b>User </b>Management</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form id="loginForm" action="{{ asset('index3.html') }}" method="post">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

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

    <script>
        $(document).ready(function() {
            $('#loginForm').submit(function(e){ 
                e.preventDefault();

                      $('#loginForm .is-invalid').removeClass('is-invalid')
                      $('#loginForm .invalid-feedback').remove()
                      $('#loginForm').find('button:submit')
                        .attr('disabled', 'disabled')
                        .text('Signing In...')

                $.ajax({
                    url: `{{ config('app.api_url') }}login`,
                    method: 'POST',
                    dataType: 'JSON',
                    data: $('#loginForm').serializeArray(),
                    success: response => {
                        document.cookie = `access-token=${response.access_token}`
                        document.cookie = `user=${JSON.stringify(response.user)}`

                        window.location.href = 'http://localhost/userfrontend/public/admin/dashboard';
                    }
                }).always(() => {
                    $('#loginForm').find('button:submit')
                      .removeAttr('disabled')
                      .text('Sign In')
                });
            });
        });
    </script>
</body>

</html>