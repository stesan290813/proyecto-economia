<?php
session_start();
switch ($_GET["action"]){

    case 'count':
        include("../class/class_connection.php");
        $conexion = new Connection();
        
        $sql = $conexion->executeQuery("SELECT COUNT(txt_nombre) as cantidad FROM Producto");
        $cantidad = $conexion->getRow($sql);
        //$conexion->closeConnection();
        $response = array("status"=>200, "cantidad"=>$cantidad["cantidad"]);

        echo json_encode($response);
        break;


    case 'search':

        include("../class/class_connection.php");
        $conexion = new Connection();

        $sql = sprintf("
            SELECT P.num_producto_pk, P.txt_nombre, P.txt_descripcion, P.precio, P.txt_foto, D.txt_nombre as depto 
            FROM Producto P
            INNER JOIN Departamento D 
            ON P.num_depto_fk = D.num_depto_pk WHERE MATCH (P.txt_nombre,P.txt_descripcion) AGAINST ('%s' IN NATURAL LANGUAGE MODE)",stripslashes($_POST["product"]));

        $result = $conexion->executeQuery($sql);
        $a = $conexion->countRegisters($result);
        if($a>0){
            $row = $conexion->getRow($result);
            $respuesta = array( 'status' => 200,
                                'name' => $row["txt_nombre"],
                                'depto' => $row["depto"],
                                'description' => $row["txt_descripcion"],
                                'price' => $row["precio"],
                                'photo' => $row["txt_foto"]
                              );
            echo json_encode($respuesta);
        }else{
            $respuesta = array( 'status' => 500,
                                'mensaje' => "No hay resultados!"
                              );
            echo json_encode($respuesta);
        }
    break;

    case 'load-image':
        if(isset($_FILES["file"])){
            $file = $_FILES["file"];
            $nombre = $file["name"];
            $tipo = $file["type"];
            $ruta_provisional = $file["tmp_name"];
            $size = $file["size"];
            $dimensiones = getimagesize($ruta_provisional);
            $width = $dimensiones[0];
            $height = $dimensiones[1];
            $carpeta = "../img/myproducts/";
            
            if ($tipo != 'image/jpg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif'){
              echo "Error, el archivo no es una imagen"; 
            }

            else if ($size > 1024*1024){
              echo "Error, el tamaño máximo permitido es un 1MB";
            }

            else if ($width > 500 || $height > 500){
                echo "Error la anchura y la altura maxima permitida es 500px";
            }

            else if($width < 60 || $height < 60){
                echo "Error la anchura y la altura mínima permitida es 60px";
            }

            else{
                $src = $carpeta.$nombre;
                $final = substr($src, 3);
                $_SESSION["ruta"] = $final;
                move_uploaded_file($ruta_provisional, $src);
                echo "<img src='$final' alt='Producto' class='img-responsive' width='250' height='180'>";
            }
        }else{
            echo "No se encontro el archivo";
        }
        
    break;

    case 'save':
        include("../class/class_connection.php");
        include("../class/class_product.php");
        $producto = new Product(
                        $_POST["slc-depto"],
                        $_POST["name"],
                        $_POST["description"],
                        $_POST["price"],
                        $_POST["discount"],
                        $_POST["tax"],
                        $_SESSION["ruta"]
                    );
        $conexion = new Connection();
        $producto->agregarProducto($conexion,$_POST["cant"],$_SESSION['userCode']);
        $conexion->closeConnection();
    break;

    case 'index':
        include("../class/class_connection.php");
        include("../class/class_product.php");
        $conexion = new Connection();
        echo $_POST["id"];
        Product::mostrarProductos($conexion,$_POST["id"]);
    break;

    case 'shop':
        
        $ids = explode(",", $_POST["ids"][0]);
        //print_r($ids);
        $data = array();
        //print_r($ids);
        for($i=0;$i<count($ids);$i++){
            $data[$i] = preg_replace("/[^0-9]+/", "", $ids[$i]);
        }
        //print_r($data);
        $_SESSION["products"] = $data;
        print_r($_SESSION["products"]);
        
        
    break;

    case 'orders':
        include("../class/class_connection.php");
        include("../class/class_product.php");
        $conexion = new Connection();
        $ids = "";
        for($i=0;$i<count($_SESSION["products"]);$i++){
            $ids .= "num_producto_pk = ".$_SESSION["products"][$i]." OR ";
        }
        $condicion = substr($ids, 0, -4);
        $sql = "SELECT txt_nombre, txt_descripcion, precio FROM Producto WHERE ".$condicion;

        
        $result2 = $conexion->executeQuery("SELECT sum(precio) as total FROM Producto WHERE ".$condicion);
        $total = $conexion->getRow($result2);
        $_SESSION["total_compra"] = $total;

        $result = $conexion->executeQuery($sql);
        echo '<table class="table table-hover table-condensed">
                  <tr>
                    <td colspan="4" align="center" class="table-primary">
                      <h4 class="panel-title">Lista de pedidos</h4>
                    </td>
                  </tr>
                  <tr class="table-primary">
                    <td align="center">Nombre</td>
                    <td align="center">Descripcion</td>
                    <td align="center">Cantidad</td>
                    <td align="center">Precio</td>                  
                  </tr>';
        if($result){
            while ($row = $conexion->getRow($result)){

            ?>
                <tr>
                  <td align="center"><?php echo $row["txt_nombre"];?></td>
                  <td align="center"><?php echo $row["txt_descripcion"];?></td>
                  <td align="center"><?php echo 1;?></td>
                  <td align="center">$ <?php echo $row["precio"];?></td>
                </tr>
            <?php
            }
            echo '<tr class="table-warning">
                      <td align="center" colspan="3">Total</td>
                      <td align="center" id="total">$ '.number_format((float)$total[0], 2, '.', '').'</td>
                  </tr>            
                </table>';
        }
        
    break;


    case 'buy':
        include("../class/class_connection.php");
        $conexion = new Connection();
        $ids = "";
        for($i=0;$i<count($_SESSION["products"]);$i++){
            $ids .= "num_producto_pk = ".$_SESSION["products"][$i]." OR ";
        }
        $condicion = substr($ids, 0, -4);
        $sql = "SELECT precio FROM Producto WHERE ".$condicion;
        $result = $conexion->executeQuery($sql);
        $products = $_SESSION["products"];
        
        while($row = $conexion->getRow($result)){
            
            $precios[] = $row["precio"]."\n";
            
        }
        for($i=0;$i<count($products);$i++){
            for($j=0;$j<count($precios);$j++){
                
            }

            $sql2 = sprintf(
                "INSERT INTO Productos_X_Usuario(Usuario_num_usuario_fk, Producto_num_producto_fk, num_accion_fk, cantidad, total)
                VALUES (%s,%s,%s,%s,%s); ",
                stripslashes($_SESSION["userCode"]),
                stripslashes($products[$i]),
                stripslashes(1),
                stripslashes(1),
                stripslashes($precios[$i])
            );

            $r = $conexion->executeQuery($sql2);
            $a = $conexion->countRegisters($r);

            if($r>0){
                $sql3 = sprintf(
                    "SELECT monto_disponible FROM Usuario WHERE num_usuario_pk = '%s'",
                    stripslashes($_SESSION["userCode"])
                );
                $r2 = $conexion->executeQuery($sql3);
                $monto = $conexion->getRow($r2);
                $total = $monto["monto_disponible"] - $_SESSION["total_compra"]["total"];
                if($tota<0){
                    $respuesta = array("status"=>500,"error"=>"El total es mayor que su saldo!");
                    echo json_encode($respuesta);
                }else{
                    $sql4 = sprintf(
                        "UPDATE Usuario SET monto_disponible = $total WHERE num_usuario_pk = '%s'",
                        stripslashes($_SESSION["userCode"])
                    );
                    $r3 = $conexion->executeQuery($sql4);
                    if($r3>0){
                        session_start();
                        $_SESSION["products"] = 0;
                        $_SESSION["cash"] = $total;
                        echo json_encode(array("status"=>200,"data"=>"Compra realizada con exito!"));
                    }
                }
            }
        }

    break;

    case 'indexedDB':
        include("../class/class_connection.php");
        include("../class/class_product.php");
        $conexion = new Connection();
        Product::mostrarProductosLogin($conexion);
        $conexion->closeConnection();
    break;
    
    default:
        echo "Accion Inválida";
        break;
}

?>