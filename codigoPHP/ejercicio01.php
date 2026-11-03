<html>
    <head></head>
    <body>
        <h1><a href='../indexProyectoTema4.php'>volver</a></h1>
        <?php //para ver errores
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        ?>
        <?php
        require_once '../core/ConexionDB.php'; //conectar al archivo para obetener conexion a la base de datos
        $atributes= [
            'AUTOCOMMIT', 'ERRMODE' , 'CASE' , 'CLIENT_VERSION', 'CONNECTION_STATUS',
            'ORACLE_NULLS', 'PERSISTENT', 'PREFETCH', 'SERVER_INFO', 'SERVER_VERSION', 'TIMEOUT'
        ]; //propiedades
            try{
                $miDB = new PDO($host,$USER,$PASSWORD); //conectando a la base de datos
                echo "<h2>Conexion Establecida</h2><br>";
                echo "<h3>Porpiedades</h3>";
                foreach ($atributes as $atributo) { //para mostrar las propiedades
                echo "PDO: ATTR: ".$atributo.": ";
                    try {
                        echo '<span class="azul">'.$miDB->getAttribute( constant( "PDO::ATTR_$atributo" ) ) . "</span><br>";
                    } catch (PDOException $e ) {
                        echo '<span class="rojo"> <b>Error: </b>'.$e->getMessage().' <b>con código de error:</b> '.$e->getCode()."</span><br>"; //en caso de excepccion en alguna propiedad
                    }
                }
            }catch(PDOException $e){
                echo $e->getMessage()."<br>";
            }
            try{ //mostrado excepcion de cuando no hay una base de datos
                $hoste="mysql:host=10.199.9.174;dbname=DBSGVDWESProyectoTema";
                $miDBe1 = new PDO($hoste,$USER,$PASSWORD);
            }catch(PDOException $e){
                echo "<h2>Error Base de datos</h2><br>";
                echo $e->getMessage()."<br>";
            }
            try{ //mostrando excepcion de cuando el usuario es erroneo
                $USERe="3";
                $miDBe2 = new PDO($host,$USERe,$PASSWORD);
            }catch(PDOException $e){
                echo "<h2>Error Usuario</h2><br>";
                echo $e->getMessage()."<br>";
            }
            try{ //mostrando excepcion de cuando la contraseña es erronea
                $PASSWORDe="3";
                $miDBe3 = new PDO($host,$USER,$PASSWORDe);
            }catch(PDOException $e){
                echo "<h2>Error Contraseña</h2><br>";
                echo $e->getMessage()."<br>";
            }
            finally {
            // Cierra la conexion con la base de datos
                unset($Transaccion);
            }
        ?>
        <footer>
            <p><time datetime="2026-09-14">2026-2027</time> IES LOS SAUCES. ©Todos los derechos reservados</p>
            <p>Santiago González Vicente. 03/11/2026</p>
            <a href="https://github.com/CuentaEducaSantiago/SGVDWESProyectoTema4" target="_blank" rel="noopener"><i class="fa fa-github" style="font-size:40px; margin-right: 15px;"></i></a>
            <a href="../indexProyectoTema4.php"><i class="fa fa-home" style="font-size:40px; margin-right: 15px;"></i></a>
        </footer>
    </body>
</html>