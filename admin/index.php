<?php

session_start();
if($_POST){
  if(($_POST['usuario']=="gaiabyjuan")&&($_POST['contrasenia']=="tusitioweb")){
      
    $_SESSION['usuario']="ok";
    $_SESSION['nombreUsuario']="gaiabyjuan";
    header('Location:Inicio.php');
  }else{
  $mensaje="Error:el usuario o contraseña son incorrectos";
  }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      <div class="container">
          <div class="row">

            <div class="col-md-4">
                
            </div>

              <div class="col-md-4">
<br><br><br>
              <div class="card">
                  <div class="card-header">
                      Login
                  </div>
                  <div class="card-body">
                    <?php if(isset($mensaje)) {?>
                      <div class="alert alert-danger" role="alert">
                        <?php echo $mensaje;?>
                      </div>
                      <?php }?>

                    <form method="POST">
                    <div class = "form-group">
                    <label>Usuario</label>
                    <input type="text" class="form-control" name="usuario" aria-describedby="emailHelp" placeholder="Escribe tu Usuario">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                    <label>Contraseña: </label>
                    <input type="password" class="form-control" name="contrasenia" placeholder="Escribe tu Contraseña">
                    </div>
                    <button type="submit" class="btn btn-primary">Entrar al administrador</button>
                    </form>
                    
                    
                  </div>
                  
              </div>
            
              </div>
              
          </div>
      </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>