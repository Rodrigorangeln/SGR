<!doctype html>
<link rel="shortcut icon" href="./imagens/logo.ico" />
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->
    <title>SGR - Nortcom</title>
<link href="./css/signin.css" rel="stylesheet">
<link href="./css/bootstrap.min.css" rel="stylesheet">
<!--
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
-->
  </head>
  
  <body class="text-center">
  <form class="form-signin" action='auth.php' method="POST">
  <img class="mb-4" src="./imagens/logo.png" alt="" width="72" height="72">
  <h1 class="h3 mb-3 font-weight-normal">Sistema de Gestão e Reparos</h1>
  <label for="inputMatricula" class="sr-only">Matricula</label>
  <input type="matricula" name="user" class="form-control" placeholder="Matrícula" required autofocus>
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" name="pass" class="form-control" placeholder="Senha" required>
  <div class="checkbox mb-3">
    <label>
      <input type="checkbox" value="remember-me"> Lembrar
    </label>
  </div>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
  <p class="mt-5 mb-3 text-muted">&copy; 2021</p> 
</form>
</body>

</html>
