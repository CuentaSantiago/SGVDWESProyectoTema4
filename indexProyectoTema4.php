<!DOCTYPE html>
<html lang="es">
    <!--
    Autor: Santiago González Vicente
    Fecha Modificacion: 2026-09-28
    Descripcion: Indice DAW2
    -->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--       <link rel="shortcut icon" type="image/jpg" href="webroot/favicon/favicon.ico">--> 
        <link rel="stylesheet" type="text/css" href="webroot/css/estilos.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Santiago González Vicente</title>
    </head>
    <body>
        <header>
            <h1>UT4: TÉCNICAS DE ACCESO A DATOS EN PHP</h1>
        </header>
        <table>
            <tbody>
                <tr>
                    <th>Creacion Base de datos y Usuario</th>
                    <th><a href="mostrarcodigo/mostrarCreaDBSGVDWESProyectoTema4.php">Mostrar</a></th>
                </tr>
                <tr>
                    <th>Creacion Tabla</th>
                    <th><a href="mostrarcodigo/mostrarCargaInicialDBSGVDWESProyectoTema4.php">Mostrar</a></th>
                </tr>
                <tr>
                    <th>Borrar Base de datos y Usuario</th>
                    <th><a href="mostrarcodigo/mostrarBorraDBSGVDWESProyectoTema4.php">Mostrar</a></th>
                </tr>
                <tr>
                    <th>Libreria</th>
                    <th><a href="mostrarcodigo/231018libreriaValidacion.php">Mostrar</a></th>
                </tr>
            </tbody>
        </table><br>
        <table>
            <thead>
                <tr>
                    <th>Nº Ejercicio</th>
                    <th>Enunciado</th>
                    <th>Ejecutar</th>
                    <th>Visualizar copdigo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Conexión a la base de datos con la cuenta usuario y tratamiento de errores.</td>
                    <td><a href="codigoPHP/ejercicio01.php">Ejecutar</a></td>
                    <td><a href="mostrarcodigo/muestraEjercicio01.php">Mostrar</a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Mostrar el contenido de la tabla Departamento y el número de registros.</td>
                    <td><a href="codigoPHP/ejercicio02.php">Ejecutar</a></td>
                    <td><a href="mostrarcodigo/muestraEjercicio02.php">Mostrar</a></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td> Formulario para añadir un departamento a la tabla Departamento con validación de entrada y
                    control de errores.</td>
                    <td><a href="codigoPHP/ejercicio03.php">Ejecutar</a></td>
                    <td><a href="mostrarcodigo/muestraEjercicio03.php">Mostrar</a></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Formulario de búsqueda de departamentos por descripción (por una parte del campo
                    DescDepartamento, si el usuario no pone nada deben aparecer todos los departamentos).</td>
                    <td><a href="codigoPHP/ejercicio04.php">Ejecutar</a></td>
                    <td><a href="mostrarcodigo/muestraEjercicio04.php">Mostrar</a></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Pagina web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones
                    insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno.</td>
                    <td><a href="codigoPHP/ejercicio05.php">Ejecutar</a></td>
                    <td><a href="mostrarcodigo/muestraEjercicio05.php">Mostrar</a></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Pagina web que cargue registros en la tabla Departamento desde un array departamentosnuevos
                    utilizando una consulta preparada. (Después de programar y entender este ejercicio, modificar los
                    ejercicios anteriores para que utilicen consultas preparadas). Probar consultas preparadas sin bind,
                    pasando los parámetros en un array a execute. .</td>
                    <td><a href="codigoPHP/ejercicio06.php">Ejecutar</a></td>
                    <td><a href="mostrarcodigo/muestraEjercicio06.php">Mostrar</a></td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Página web que toma datos (código y descripción) de un fichero xml y los añade a la tabla
                    Departamento de nuestra base de datos. (IMPORTAR). El fichero importado se encuentra en el
                    directorio .../tmp/ del servidor</td>
                    <td><a href="codigoPHP/ejercicio07.php">Ejecutar</a></td>
                    <td><a href="mostrarcodigo/muestraEjercicio07.php">Mostrar</a></td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Página web que toma datos (código y descripción) de la tabla Departamento y guarda en un
                        fichero departamento.xml. (COPIA DE SEGURIDAD / EXPORTAR). El fichero exportado se
                        encuentra en el directorio .../tmp/ del servidor.</td>
                    <td><a href="codigoPHP/ejercicio08.php">Ejecutar</a></td>
                    <td><a href="mostrarcodigo/muestraEjercicio08.php">Mostrar</a></td>
                </tr>
            </tbody>
        </table>
        <footer>
            <p><time datetime="2026-09-14">2026-2027</time> IES LOS SAUCES. ©Todos los derechos reservados</p>
            <p>Santiago González Vicente. 14/09/2026</p>
            <a href="https://github.com/CuentaEducaSantiago/SGVDWESProyectoTema4" target="_blank" rel="noopener"><i class="fa fa-github" style="font-size:40px; margin-right: 15px;"></i></a>
            <a href="../indexProyectoDWES.php"><i class="fa fa-home" style="font-size:40px; margin-right: 15px;"></i></a>
        </footer>
    </body>
</html>