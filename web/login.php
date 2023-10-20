<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Log in - Brand</title>
    <?php include_once'head.php';?>
	
</head>

<body>
    <?php include_once'menu.php';?>
	
    <section class="py-5">
        <div class="container py-5">
            <div class="row mb-4 mb-lg-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <p class="fw-bold text-success mb-2">Login</p>
                    <h1 class="fw-light titulo">Bienvenido</h1>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body text-center d-flex flex-column align-items-center">
                            <div class="bs-icon-xl bs-icon-circle bs-icon-primary shadow bs-icon my-4"><img class="rounded img-fluid" src="assets/img/icono2.png"></div>
                            <form method="post" data-bs-theme="light">
                                <div class="mb-3"><input class="form-control" type="text" name="usuario" placeholder="Usuario" id="sign-email" onkeypress="return runScript(event)"></div>
                                <div class="mb-3"><input class="form-control" type="password" name="password" placeholder="Contraseña" id="sign-password" onkeypress="return runScript(event)"></div>
                                <div id="msg"></div>
                                <div class="mb-3"><button class="btn btn-primary shadow d-block w-100" type="button" onclick="login();" id="sign-login">INGRESAR</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php include_once'footer.php';?>
<script>
    function runScript(e) {
        if (e.keyCode == 13) {
            login();
            return false;
        }
    }
    function login() {
        if($("#sign-email").val() != "" && $("#sign-password").val() != "") {
            $("#sign-login").attr("disabled", true);
            $("#sign-login").addClass("disabled");
            $.ajax({
                type: 'POST',
                url: 'server/',
                data: 'o=1&e='+$("#sign-email").val()+'&p='+$("#sign-password").val(),
                dataType: 'json',
                success: function(data) {
                    $("#sign-login").attr("disabled", false);
                    $("#sign-login").removeClass("disabled");
                    if(data.msg == "OK") {
                        window.location.assign('./');
                    }
                    else {
                        $("#msg").html('<div class="alert alert-warning" role="alert">'+data.msg+'</div>');
                        setTimeout(() => {
                            $("#msg").html("");
                        }, 5000);
                    }
                }
            });

            }
            else {
                $("#msg").html('<div class="alert alert-warning" role="alert">Debe ingresar su usuario y contraseña.</div>');
                setTimeout(() => {
                    $("#msg").html("");
                }, 5000);
            }
        }
</script>