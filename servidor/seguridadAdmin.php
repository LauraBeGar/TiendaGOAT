<?php

// Validar permisos (solo administradores y editores pueden acceder)
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 1)) {
    header("Location: index.php");
    exit();
}