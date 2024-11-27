<?php

    session_start();
    include ("database_e.php");
	$DB= new Database();
    $idusuario=isset($_POST["idusuario"])? sanitize($_POST["idusuario"]):"";
    $nombre=isset($_POST["nombre"])? sanitize($_POST["nombre"]):"";
    $login=isset($_POST["login"])? sanitize($_POST["login"]):"";
    $clave=isset($_POST["clave"])? sanitize($_POST["clave"]):"";
    $imagen=isset($_POST["imagen"])? sanitize($_POST["imagen"]):"";
	
	
    switch($_GET["op"])
    {
        case 'guardaryeditar':

            if(!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
            {
                $imagen = $_POST["imagenactual"];
            }
            else
            {
                $ext = explode(".",$_FILES["imagen"]["name"]);
                if($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
                {
                    $imagen = round(microtime(true)).'.'.end($ext);
                    move_uploaded_file($_FILES['imagen']['tmp_name'], "../files/usuarios/" . $imagen);
                }
            }

            //Hash SHA256 en la contraseña
            $clavehash = hash("SHA256",$clave);

            if (empty($idusuario)){
                $rspta=$usuario->insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$_POST['permiso']);
                echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
            }
            else {
                $rspta=$usuario->editar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$_POST['permiso']);
                echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
            }
        break;

        case 'desactivar':
                $rspta = $usuario->desactivar($idusuario);
                echo $rspta ? "Usuario desactivado" : "Usuario no se pudo desactivar";
        break;

        case 'activar':
            $rspta = $usuario->activar($idusuario);
            echo $rspta ? "Usuario activado" : "Usuario no se pudo activar";
        break;

        case 'mostrar':
            $rspta = $usuario->mostrar($idusuario);
            echo json_encode($rspta);
        break;

        case 'listar':
            $rspta = $usuario->listar();
            $data = Array();
            while ($reg = $rspta->fetch_object()) {
                $data[] = array(
                    "0"=> ($reg->condicion) ? 
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')"><li class="fa fa-close"></li></button>'
                        :
                        '<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><li class="fa fa-pencil"></li></button>'.
                        ' <button class="btn btn-primary" onclick="activar('.$reg->idusuario.')"><li class="fa fa-check"></li></button>'
                        ,
                    "1"=>$reg->nombre,
                    "2"=>$reg->tipo_documento,
                    "3"=>$reg->num_documento,
                    "4"=>$reg->telefono,
                    "5"=>$reg->email,
                    "6"=>$reg->login,
                    "7"=>"<img src='../files/usuarios/".$reg->imagen."' height='50px' width='50px'>",
                    "8"=>($reg->condicion) ?
                         '<span class="label bg-green">Activado</span>'
                         :      
                         '<span class="label bg-red">Desactivado</span>'
                );
            }
            $results = array(
                "sEcho"=>1, //Informacion para el datable
                "iTotalRecords" =>count($data), //enviamos el total de registros al datatable
                "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
                "aaData" =>$data
            );
            echo json_encode($results);
        break;

        case 'permisos':
            //obtenemos los permisos de la tabla permisos
            require_once '../modelos/Permiso.php';
            $permiso = new Permiso();
            $rspta = $permiso->listar();

            //Obtener los permisos del usuario
            $id=$_GET['id'];
            $marcados = $usuario->listarmarcados($id);
            
            //declaramos el array para almacenar todos los permisos marcados
            $valores = array();

            //Almacenar los permisos asignados al usuario en el array
            while ($per = $marcados->fetch_object()) 
            {
                array_push($valores,$per->idpermiso);
            }

            while($reg = $rspta->fetch_object())
            {
                $sw = in_array($reg->idpermiso, $valores) ? 'checked' : '';

                echo '<li> 
                        <input type="checkbox" '.$sw.' name="permiso[]" value="'.$reg->idpermiso.'">'
                        .$reg->nombre.
                    '</li>';
            }
        break;


        case 'verificar':
            $logina = $_POST['logina'];
            $clavea = $_POST['clavea'];
			
            //Desencriptar clave SHA256
            $clavehash = hash("SHA256",$clavea);
			
			
			$res = $DB->verificar($logina, $clavehash);
			$fetch = $res->fetch_object();
			 if(isset($fetch))
            {
				//Declarando variables de session
                $_SESSION['idusuario'] = $fetch->idusuario;
                $_SESSION['nombre'] = $fetch->nombre;
                $_SESSION['imagen'] = $fetch->imagen;
                $_SESSION['login'] = $fetch->login;
				//Obtenemos los permisos del usuario
				$DB0 = new Database();
				$res0 = $DB0->listarmarcados($fetch->idusuario);
				
				//Array para almacenar los permisos
                $valores= array();

                while($per = $res0->fetch_object())
                {
                    array_push($valores, $per->idpermiso);
                }
				
				//Determinando los accesos del usuario
                in_array(1,$valores) ? $_SESSION['Serie (Repeticiones)'] = 1 : $_SESSION['Serie (Repeticiones)'] = 0;
                in_array(2,$valores) ? $_SESSION['Lotes'] = 1 : $_SESSION['Lotes'] = 0;
				in_array(3,$valores) ? $_SESSION['CLxSE (SEI)'] = 1 : $_SESSION['CLxSE (SEI)'] = 0;
                in_array(4,$valores) ? $_SESSION['Error Secuencia'] = 1 : $_SESSION['Error Secuencia'] = 0;
				in_array(5,$valores) ? $_SESSION['Historial Envase'] = 1 : $_SESSION['Historial Envase'] = 0;
                in_array(6,$valores) ? $_SESSION['Historial Llenado'] = 1 : $_SESSION['Historial Llenado'] = 0;
				in_array(7,$valores) ? $_SESSION['Kardex'] = 1 : $_SESSION['Kardex'] = 0;
                in_array(8,$valores) ? $_SESSION['Primero D'] = 1 : $_SESSION['Primero D'] = 0;
				in_array(9,$valores) ? $_SESSION['Alta Remito'] = 1 : $_SESSION['Alta Remito'] = 0;
                in_array(10,$valores) ? $_SESSION['Remitos Cant-ED'] = 1 : $_SESSION['Remitos Cant-ED'] = 0;
				in_array(11,$valores) ? $_SESSION['Remitos'] = 1 : $_SESSION['Remitos'] = 0;
				in_array(12,$valores) ? $_SESSION['Remitos Cant-ED-Vol'] = 1 : $_SESSION['Remitos Cant-ED-Vol'] = 0;
                in_array(13,$valores) ? $_SESSION['ABM Serie'] = 1 : $_SESSION['ABM Serie'] = 0;
				in_array(14,$valores) ? $_SESSION['Envases Cliente (Cap)'] = 1 : $_SESSION['Envases Cliente (Cap)'] = 0;
                in_array(15,$valores) ? $_SESSION['Envases Cliente'] = 1 : $_SESSION['Envases Cliente'] = 0;
				in_array(16,$valores) ? $_SESSION['Vencimientos'] = 1 : $_SESSION['Vencimientos'] = 0;
				in_array(17,$valores) ? $_SESSION['Historial Envase Old'] = 1 : $_SESSION['Historial Envase Old'] = 0;
				in_array(18,$valores) ? $_SESSION['Partida'] = 1 : $_SESSION['Partida'] = 0;
				in_array(19,$valores) ? $_SESSION['Remitos Granel-Vol'] = 1 : $_SESSION['Remitos Granel-Vol'] = 0;
				in_array(20,$valores) ? $_SESSION['AlquilerEnvases'] = 1 : $_SESSION['AlquilerEnvases'] = 0;
				in_array(21,$valores) ? $_SESSION['Alta Remito SI'] = 1 : $_SESSION['Alta Remito SI'] = 0;
				in_array(22,$valores) ? $_SESSION['Remitos Cant-ED v2'] = 1 : $_SESSION['Remitos Cant-ED v2'] = 0;
				in_array(23,$valores) ? $_SESSION['BM Remito'] = 1 : $_SESSION['BM Remito'] = 0;
				in_array(24,$valores) ? $_SESSION['Partidav2'] = 1 : $_SESSION['Partidav2'] = 0;
				in_array(25,$valores) ? $_SESSION['GasesEspeciales'] = 1 : $_SESSION['GasesEspeciales'] = 0;
				in_array(26,$valores) ? $_SESSION['Error Secuencia GE'] = 1 : $_SESSION['Error Secuencia GE'] = 0;
				in_array(27,$valores) ? $_SESSION['Historial Envase GE'] = 1 : $_SESSION['Historial Envase GE'] = 0;
				in_array(28,$valores) ? $_SESSION['Alta Remito GE'] = 1 : $_SESSION['Alta Remito GE'] = 0;
				in_array(29,$valores) ? $_SESSION['Remitos Cant-ED GE'] = 1 : $_SESSION['Remitos Cant-ED GE'] = 0;
				in_array(30,$valores) ? $_SESSION['Remitos GE'] = 1 : $_SESSION['Remitos GE'] = 0;
				in_array(31,$valores) ? $_SESSION['Remitos Cant-ED-Vol GE'] = 1 : $_SESSION['Remitos Cant-ED-Vol GE'] = 0;
				in_array(32,$valores) ? $_SESSION['ABM Serie GE'] = 1 : $_SESSION['ABM Serie GE'] = 0;
				in_array(33,$valores) ? $_SESSION['Envases Cliente (Cap) GE'] = 1 : $_SESSION['Envases Cliente (Cap) GE'] = 0;
				in_array(34,$valores) ? $_SESSION['Envases Cliente GE'] = 1 : $_SESSION['Envases Cliente GE'] = 0;
				in_array(35,$valores) ? $_SESSION['Remitos Granel-Vol GE'] = 1 : $_SESSION['Remitos Granel-Vol GE'] = 0;
				in_array(36,$valores) ? $_SESSION['AlquilerEnvases GE'] = 1 : $_SESSION['AlquilerEnvases GE'] = 0;
				in_array(37,$valores) ? $_SESSION['Alta Remito SI GE'] = 1 : $_SESSION['Alta Remito SI GE'] = 0;
				in_array(38,$valores) ? $_SESSION['Remitos Cant-ED v2 GE'] = 1 : $_SESSION['Remitos Cant-ED v2 GE'] = 0;
				in_array(39,$valores) ? $_SESSION['BM Remito GE'] = 1 : $_SESSION['BM Remito GE'] = 0;
				in_array(40,$valores) ? $_SESSION['Partida GE'] = 1 : $_SESSION['Partida GE'] = 0;
			}
			echo json_encode($fetch); //Retornando JSON
					
			
			/*
            $rspta = $usuario->verificar($logina, $clavehash);

            $fetch = $rspta->fetch_object();

            if(isset($fetch))
            {
                //Declarando variables de session
                $_SESSION['idusuario'] = $fetch->idusuario;
                $_SESSION['nombre'] = $fetch->nombre;
                $_SESSION['imagen'] = $fetch->imagen;
                $_SESSION['login'] = $fetch->login;

                //Obtenemos los permisos del usuario
                $permisos = $usuario->listarmarcados($fetch->idusuario);

                //Array para almacenar los permisos
                $valores= array();

                while($per = $permisos->fetch_object())
                {
                    array_push($valores, $per->idpermiso);
                }

                //Determinando los accesos del usuario
                in_array(1,$valores) ? $_SESSION['escritorio'] = 1 : $_SESSION['escritorio'] = 0;
                in_array(2,$valores) ? $_SESSION['articulo'] = 1 : $_SESSION['articulo'] = 0;
				in_array(3,$valores) ? $_SESSION['almacen'] = 1 : $_SESSION['almacen'] = 0;
                in_array(4,$valores) ? $_SESSION['compras'] = 1 : $_SESSION['compras'] = 0;
                in_array(5,$valores) ? $_SESSION['ventas'] = 1 : $_SESSION['ventas'] = 0;
                in_array(6,$valores) ? $_SESSION['acceso'] = 1 : $_SESSION['acceso'] = 0;
                in_array(7,$valores) ? $_SESSION['consultac'] = 1 : $_SESSION['consultac'] = 0;
                in_array(8,$valores) ? $_SESSION['consultav'] = 1 : $_SESSION['consultav'] = 0;
				in_array(9,$valores) ? $_SESSION['consultas'] = 1 : $_SESSION['consultas'] = 0;
            }
			
            echo json_encode($fetch); //Retornando JSON
			*/
        break;

        case 'salir':
            session_unset(); //Limpiamos las variables de sesion
            session_destroy(); //Destriumos la sesion
            header("Location: ../index.php");
        break;

    }

?>