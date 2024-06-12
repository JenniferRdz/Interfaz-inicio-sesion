<?php
include('conexion.php');

// Verificar si se recibieron las variables a través del método POST
if (isset($_POST['correo']) && isset($_POST['clave'])) {
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];

    // Asegurarse de que la conexión se haya establecido correctamente
    if ($conn === false) {
        die("Error en la conexión a la base de datos: " . print_r(sqlsrv_errors(), true));
    }

    // Consulta SQL para verificar si el correo existe
    $sql = "SELECT clave FROM Cliente WHERE correo = ?";
    $params = array($correo);
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt === false) {
        die("Error al preparar la consulta: " . print_r(sqlsrv_errors(), true));
    }

    // Ejecutar la consulta
    if (sqlsrv_execute($stmt)) {
        // Verificar si se encontró un usuario con el correo proporcionado
        if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            // Verificar si la clave es correcta
            $hashedPassword = $row['clave'];
            if (password_verify($clave, $hashedPassword)) {
                echo "Inicio de sesión exitoso!";
                header('LOCATION: home.php');
            } else {
                echo "Clave incorrecta.";
                header('LOCATION: login.html');

            }
        } else {
            echo "El usuario no existe.";
            header('LOCATION: login.html');
        }
    } else {
        die("Error al ejecutar la consulta: " . print_r(sqlsrv_errors(), true));
    }

    // Liberar recursos
    sqlsrv_free_stmt($stmt);
} else {
    echo "Por favor, proporcione correo y clave.";
    header('LOCATION: login.html');
}

// Cerrar la conexión
sqlsrv_close($conn);



// if ($valor == 2){

//     $sql = "SELECT * FROM Cliente WHERE correo='$correo'";
//     $result = $conn->query($sql);
//     if ($result->num_rows > 0) {
//         $row = $result->fetch_assoc();
//         if ($clave == $row['clave']) {
//             if($row['nivel_cuenta'] == 5){
//                 echo 'bienvenido admin';
//                 $_SESSION['nivel_cuenta'] = $row['nivel_cuenta'];
//                 $_SESSION['nombre'] = $row['nombre'];
//                 header('LOCATION: home.php');
//             exit(); 
//             } else {
//                 echo 'bienvenido';
//             $_SESSION['nombre'] = $correo;
//             header('LOCATION: home.php');
//             exit();

//             }
             
//         } else {
//             echo('
// <h1> Constrasena incorrecta</h1>
// <p>volver a intentar</p>
// <form action="login.html" method="get">
//         <button type="submit" class="button">volver a intentar</button>
//     </form>

// ');
//         }
//     } else {
//         echo('
//         <h1> Constrasena incorrecta</h1>
//         <p>volver a intentar</p>
//         <form action="login.html" method="get">
//                 <button type="submit" class="button">volver a intentar</button>
//             </form>
        
//         ');
//     }

// }

// else {
//     echo("entra al registro");
//     $sql = "SELECT * FROM Cliente WHERE correo='$correo'";
//     echo("se realiza el query");
//     $result = $conn->query($sql);
//     if ($result->num_rows > 0) {
//         echo("entra en el primer if");
//         $row = $result->fetch_assoc();
//         if ($clave == $row['clave']) {
//             print("bienvenido usuario");
            
//         } else {
//             echo "Contraseña incorrecta";
//         }
//     } else {
//         $sql = "INSERT INTO Cliente (nombre,apellido, correo, clave) VALUES ('$nombre','$apellido', '$correo', '$clave')";
//         echo "registro exitoso";
//         $result = $conn->query($sql);
//         echo "registro exitoso";  
              
//     }
    
// }

