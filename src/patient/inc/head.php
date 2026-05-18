<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>
        <?php
        if (defined('TITLE')) {
            echo TITLE;
        } else {
            echo 'Admin Dashboard | Money manager';
        }
        ?>
    </title>
    <meta content="<?php if (defined('PAGE_DESC')) {
                        echo PAGE_DESC;
                    } ?>" name="description">
    <meta content="<?php if (defined('KEYWORDS')) {
                        echo KEYWORDS;
                    } ?>" name="keywords">

    <!-- Favicons -->
    <link href="<?= $patientRoot ?>assets/img/logoo.png" rel="icon">
    <link href="<?= $patientRoot ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= $patientRoot ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $patientRoot ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= $patientRoot ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?= $patientRoot ?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="<?= $patientRoot ?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="<?= $patientRoot ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?= $patientRoot ?>assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main & Custom CSS Files -->
    <link href="<?= $patientRoot ?>assets/css/style.css" rel="stylesheet">
    <link href="<?= $patientRoot ?>assets/css/custom.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Aug 30 2023 with Bootstrap v5.3.1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>