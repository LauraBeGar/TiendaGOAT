<?php

// Validar permisos (solo administradores y editores pueden acceder)
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2)) {
    header("Location: /");
    exit();
}