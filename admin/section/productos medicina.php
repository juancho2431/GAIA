<?php include("../template/cabecera.php");?>
<?php
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtnameofproduct=(isset($_POST['txtnameofproduct']))?$_POST['txtnameofproduct']:"";
$txtimagen=(isset($_FILES['txtimagen']['name']))?$_FILES['txtimagen']['name']:"";
$txtprice=(isset($_POST['txtprice']))?$_POST['txtprice']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include("../config/bd.php");

switch($accion){
        case"Agregar":

           $sentenciaSQL= $conexion ->prepare("INSERT INTO medicina_artesanal (nombre, imagen,precio) VALUES (:nombre, :imagen, :precio);");
           $sentenciaSQL->bindParam(':nombre',$txtnameofproduct);


           $fecha= new DateTime();
           $nombreArchivo=($txtimagen!="")?$fecha ->getTimestamp()."_".$_FILES["txtimagen"]["name"]:"imagen.jpg";
           $tmpimagen=$_FILES["txtimagen"]["tmp_name"];

           if($tmpimagen!=""){

                move_uploaded_file($tmpimagen,"../../img/".$nombreArchivo);
           }
           $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
           $sentenciaSQL->bindParam(':precio',$txtprice);
           $sentenciaSQL->execute();

           header("Location:productos medicina.php");
           break;

            case"Modificar":
                $sentenciaSQL= $conexion->prepare("UPDATE medicina_artesanal SET nombre=:nombre WHERE id=:id");
                $sentenciaSQL->bindParam(':nombre', $txtnameofproduct);
                $sentenciaSQL->bindParam(':id', $txtID);
                $sentenciaSQL->execute();
                
                if($txtimagen!=""){
                    $sentenciaSQL= $conexion->prepare("UPDATE medicina_artesanal SET imagen=:imagen WHERE id=:id");
                    $sentenciaSQL->bindParam(':imagen', $txtimagen);
                    $sentenciaSQL->bindParam(':id', $txtID);
                    $sentenciaSQL->execute(); 
                }

            
                $sentenciaSQL= $conexion->prepare("UPDATE medicina_artesanal SET precio=:precio WHERE id=:id");
                $sentenciaSQL->bindParam(':precio', $txtprice);
                $sentenciaSQL->bindParam(':id', $txtID);
                $sentenciaSQL->execute(); 
                header("Location:productos medicina.php");              
                break;

            case "Cancelar":
                header("Location:productos medicina.php");
                break;

            case "Seleccionar":
                $sentenciaSQL= $conexion->prepare("SELECT * FROM medicina_artesanal WHERE id=:id");
                $sentenciaSQL->bindParam(':id', $txtID);
                $sentenciaSQL->execute();
                $Productos=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

                $txtnameofproduct=$Productos['nombre'];
                $txtimagen=$Productos['imagen'];
                $txtprice=$Productos['precio'];
                break;
                
            case "Borrar":

                $sentenciaSQL= $conexion->prepare("SELECT imagen FROM medicina_artesanal WHERE id=:id");
                $sentenciaSQL->bindParam(':id', $txtID);
                $sentenciaSQL->execute();
                $Productos=$sentenciaSQL->fetch(PDO::FETCH_LAZY); 
                
                if(isset($Productos["imagen"]) &&($Productos["imagen"]!="imagen.jpg")){

                    if(file_exists("../../img/".$Productos["imagen"])){

                        unlink("../../img/".$Productos["imagen"]);
                    }

                }
                $sentenciaSQL= $conexion->prepare("DELETE FROM medicina_artesanal WHERE id=:id");
                $sentenciaSQL->bindParam(':id', $txtID);
                $sentenciaSQL->execute();
                header("Location:productos medicina.php");
                break; 
        
}
$sentenciaSQL= $conexion->prepare("SELECT * FROM medicina_artesanal");
$sentenciaSQL->execute();
$listaProductos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="col-md-5">

    <div class="card">
        <div class="card-header">
            Datos del Producto
        </div>
        <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
        <div class = "form-group">
    <label for="txtID">ID</label>
    <input type="hidden" class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID"  placeholder="Escribe el ID">
    </div>
    <div class = "form-group">
    <label for="txtnameofproduct">Nombre producto</label>
    <input type="text" required class="form-control" value="<?php echo $txtnameofproduct; ?>" name="txtnameofproduct" id="txtnameofproduct"  placeholder="Escribe el producto">
    </div>
<div class = "form-group">
    <label for="txtimagen">Imagen</label>

    <br/>

    <?php
        if($txtimagen!=""){?>
            <img class="img-tumbnail rounded" src="../../img/<?php echo $txtimagen;?>" width="50" alt="" srcset"">
    
    <?php }?>
<br/>
    <input type="file" required class="form-control" value="<?php echo $txtimagen; ?>" name="txtimagen" id="txtimagen"  placeholder="Seleccione una imagen">
    </div>

    <div class = "form-group">
    <label for="txtprice">Precio</label>
    <input type="number" required class="form-control" value="<?php echo $txtprice;?>" name="txtprice" id="txtprice"  placeholder="Escribe el Precio">
    </div>

    <div class="btn-group" role="group" aria-label="">
        <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-success">agregar</button>
        <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Modificar" class="btn btn-info">modificar</button>
        <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Borrar" class="btn btn-danger">borrar</button>
    </div>
    </form>
    
        </div>

    </div>

    
    
</div>
<div class="col-md-7">
    <table class="table table-bordered">
        <thead>
            <tr>
                
                <th>Nombre producto</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>

        <?php foreach($listaProductos as $productos) { ?>
            <tr>
                
                <td><?php echo $productos['nombre']; ?></td>
                <td>
                <img src="../../img/<?php echo $productos['imagen']; ?>" width="50" alt="" srcset"">  
                </td>
                <td><?php echo $productos['precio']; ?></td>

                <td>
                <form method="post">
                    <input type="hidden" name="txtID" id="txtID" value="<?php echo $productos['id']; ?>">
                    <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>
                    <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>
                
        </form>
                </td>
            </tr>
         <?php } ?>  
        </tbody>
    </table>
</div>

<?php include("../template/pie.php");?>