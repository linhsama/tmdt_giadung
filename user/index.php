<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="dynamicTitle">BEE shop</title>
    <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../assets/vendor/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/boxicons-2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="../assets/vendor/datatables/css/1_dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="../assets/vendor/datatables/css/2_buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
</head>

<body>
<header>
        <img src="../user/images/poster.webp" alt="">
</header>
    <?php require_once 'components/header.php' ?>
    <?php require_once 'components/main.php' ?>
    <?php require_once 'components/footer.php' ?>

    <script src="../assets/vendor/jquery-3.7.1.js"></script>
    <script src="../assets/vendor/bootstrap-5.2.3-dist/js/bootstrap.min.js"></script>
    <script src="../assets/vendor/sweetalert2@11.js"></script>
    <script src="../assets/vendor/datatables/js/1_jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables/js/2_dataTables.bootstrap5.min.js"></script>
    <script src="../assets/js/header.js"></script>
    <script src="../assets/js/main.js"></script>

</body>

</html>