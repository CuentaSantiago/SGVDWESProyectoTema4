<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ejercicio 3</title>
        <style>
            table, td, tr, th{
                border: 3px solid black;
                border-collapse: collapse;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="webroot/css/estilos.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <header>
            <h2>Ejercicio 3</h2>
        </header>
        <main>
        <h1><a href='../indexProyectoTema4.php'>volver</a></h1>
                <?php
                    ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL);
                    require_once '../core/ConexionDB.php'; //archivo para conexion a la base de datos
                    require_once'../core/231018libreriaValidacion.php'; //archivo para validaciones
                    $miDB = new PDO($host,$USER,$PASSWORD); //conexion a la base de datos
                ?>
            <div class="ejercicio">
                <?php
                        $entradaOk = true;// Variable que nos indica que todo va bien
                        $aErrores = [
                            'Dnombre' => '',
                            'Ddescripcion' => '',
                            'DFechaCreacion' => '',
                            'Dsaldo' => '',
                            'DFechaBaja' => ''
                        ];// Array donde recogemos los mensajes de error
                        $aRespuestas = [
                            'Dnombre' => '',
                            'Ddescripcion' => '',
                            'DFechaCreacion' => '',
                            'Dsaldo' => '',
                            'DFechaBaja' => ''
                        ];// Array donde recogeremos las respuestas correctas (si $entradaOK)
                        try{
                            if(isset($_POST["submit"])){
                                $aRespuestas['Dnombre'] = $_POST['Dnombre'] ?? '';
                                $aRespuestas['Ddescripcion'] = $_POST['Ddescripcion'] ?? '';
                                $aRespuestas['DFechaCreacion'] = $_POST['DFechaCreacion'] ?? '';
                                $aRespuestas['Dsaldo'] = $_POST['Dsaldo'] ?? '';
                                $aRespuestas['DFechaBaja'] = $_POST['DFechaBaja'] ?? '';
                                $aErrores['Dnombre'] = validacionFormularios::comprobarAlfabetico($aRespuestas['Dnombre'],100,0,1);
                                $aErrores['Ddescripcion'] = validacionFormularios::comprobarAlfabetico($aRespuestas['Ddescripcion'],100,0,1);
                                $aErrores['DFechaCreacion'] = validacionFormularios::validarFecha($aRespuestas['DFechaCreacion'],"01/01/2027","01/01/1900", 1);
                                $aErrores['Dsaldo'] = validacionFormularios::comprobarFloat($aRespuestas['Dsaldo'],100,0,1);
                                $aErrores['DFechaBaja'] = validacionFormularios::validarFecha($aRespuestas['DFechaBaja'],"01/01/2027","01/01/1900", 1);
                            foreach ($aErrores as $campo => $valor) {
                                if($valor !== null){
                                    $entradaOk = false;
                                }
                            }
                        } else{
                            $entradaOk = false;     // Si el formulario no se ha rellenado nunca.
                        }
                                // Tratamiento del formulario
                        if($entradaOk){
                            $aRespuestas['Dnombre'] = $_POST['Dnombre'] ?? '';
                            $aRespuestas['Ddescripcion'] = $_POST['Ddescripcion'] ?? '';
                            $aRespuestas['DFechaCreacion'] = $_POST['DFechaCreacion'] ?? '';
                            $aRespuestas['Dsaldo'] = $_POST['Dsaldo'] ?? '';
                            $aRespuestas['DFechaBaja'] = $_POST['DFechaBaja'] ?? '';
                            $sqlInsert = <<<sql
                                INSERT INTO T02_DEPARTAMENTO (T02_CodDepartamento, T02_DescDepartamento, T02_FechaCreacionDepartamento, T02_VolumenDeNegocio, T02_FechaBajaDepartamento)
                                VALUES (?, ?, ?, ?, ?)
                            sql;
                            
                            $consultaInsert = $miDB->prepare($sqlInsert);
                            $consultaInsert->bindParam(1, $aRespuestas['Dnombre']);
                            $consultaInsert->bindParam(2, $aRespuestas['Ddescripcion']);
                            $consultaInsert->bindParam(3, $aRespuestas['DFechaCreacion']);
                            $consultaInsert->bindParam(4, $aRespuestas['Dsaldo']);
                            $consultaInsert->bindParam(5, $aRespuestas['DFechaBaja']);
                            
                            if($consultaInsert->execute()){
                                echo '<p class="exito">¡El departamento ha sido insertado correctamente en la Base de Datos!</p>';
                            }
                        }
                        else{
                        ?>
                    <form name="input" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        Introduce un departamento: <input type="text" id="Dnombre" name="Dnombre" style="text-transform:uppercase" maxlength="3" value="<?php echo htmlspecialchars($aRespuestas['Dnombre']); ?>" required/>
                        <?php
                        // Mostrar mensajes de error (si los hay y el formulario no se muestra por primera vez)
                        if(!empty($aErrores['Dnombre'])) {echo "<p><span style='color:red; display:block; font-size:13px;'>{$aErrores['Dnombre']}</span></p>";}
                        ?>
                        <br>
                        Introduce su descripcion: <input type="text" id="Ddescripcion" name="Ddescripcion"  value="<?php echo htmlspecialchars($aRespuestas['Ddescripcion']); ?>" required/>
                        <?php
                        // Mostrar mensajes de error (si los hay y el formulario no se muestra por primera vez)
                        if(!empty($aErrores['Ddescripcion'])) {echo "<span style='color:red; display:block; font-size:13px;'>{$aErrores['Ddescripcion']}</span>";}
                        ?>
                        <br>
                        Introduce una fecha de creacion: <input type="date" id="DFechaCreacion" name="DFechaCreacion" value="<?php echo htmlspecialchars($aRespuestas['DFechaCreacion']); ?>" required/>
                        <?php
                        // Mostrar mensajes de error (si los hay y el formulario no se muestra por primera vez)
                        if(!empty($aErrores['DFechaCreacion'])) {echo "<span style='color:red; display:block; font-size:13px;'>{$aErrores['DFechaCreacion']}</span>";}
                        ?>
                        <br>
                        Introduce un volumen de departamento: <input type="number" id="Dsaldo" name="Dsaldo" value="<?php echo htmlspecialchars($aRespuestas['Dsaldo']); ?>" step="any" required/>
                        <?php
                        // Mostrar mensajes de error (si los hay y el formulario no se muestra por primera vez)
                        if(!empty($aErrores['Dsaldo'])) {echo "<span style='color:red; display:block; font-size:13px;'>{$aErrores['Dsaldo']}</span>";}
                        ?>
                        <br>
                        Introduce una fecha de baja de un departamento: <input type="date" id="DFechaBaja" name="DFechaBaja" value="<?php echo htmlspecialchars($aRespuestas['DFechaBaja']); ?>"/>
                        <?php
                        // Mostrar mensajes de error (si los hay y el formulario no se muestra por primera vez)
                        if(!empty($aErrores['DFechaBaja'])) {echo "<span style='color:red; display:block; font-size:13px;'>{$aErrores['DFechaBaja']}</span>";}
                        ?>
                        <br>
                        <input type="submit" name="submit" value="Enviar"/>
                    </form> 
            </div>
            <?php
            } // Fin si ($entradaOK)
            }catch(PDOException $e){//para atrapar excepciones
                echo $e->getMessage()."<br>";
            }
            finally {
            // Cierra la conexion con la base de datos
                unset($Transaccion);
            }
            ?>
        </main>
        <footer>
            <div>
            <p><time datetime="2026-10-22">2026-2027</time> IES LOS SAUCES. ©Todos los derechos reservados</p>
            <p>Santiago González Vicente. 14/09/2026</p>
            <a href="../indexProyectoTema4.php"><i class="fa fa-home" style="font-size:40px; margin-right: 15px;"></i></a>
            </div>
        </footer>
    </body>
</html>
