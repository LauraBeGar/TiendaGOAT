<?php
if (!isset($_SESSION['email'])) {
    header('Location: /');
    exit();
}