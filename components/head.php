<?php 
    require_once("$location_index/config/connect.php");
    session_start();

    include "$location_index/backend/function/csrf-token.php";
    $token = generateCSRFToken();

?>

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $location_index?>/src/assets/css/output.css">
    <link rel="stylesheet" href="<?php echo $location_index?>/node_modules/flowbite/dist/flowbite.min.css">
    <link rel="shortcut icon" href="<?php echo $location_index?>/src/assets/images/favicon.ico" type="image/x-icon">

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            background: linear-gradient(-45deg, #2ecc7d, #158799 , #33a7d0, #33a7d0);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            /* height: 100vh; */
        }

        @keyframes gradient {
            0% {
                background-position: 20% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 20% 50%;
            }
        }

        main{
            min-height: 100dvh;
        }
        /* ::-webkit-scrollbar {
            display: none;
        } */

    </style>
    <script>
        document.body.classList.toggle('dark');

        tailwind.config = {
            darkMode: false,
            theme: {
                extend: {
                    colors: {
                        blue: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"},
                        primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#22B4CB","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"}
                    }
                },
                fontFamily: {
                    'body': [
                    'Inter', 
                    'ui-sans-serif', 
                    'system-ui', 
                    '-apple-system', 
                    'system-ui', 
                    'Segoe UI', 
                    'Roboto', 
                    'Helvetica Neue', 
                    'Arial', 
                    'Noto Sans', 
                    'sans-serif', 
                    'Apple Color Emoji', 
                    'Segoe UI Emoji', 
                    'Segoe UI Symbol', 
                    'Noto Color Emoji'
                ],
                'sans': [
                    'Inter', 
                    'ui-sans-serif', 
                    'system-ui', 
                    '-apple-system', 
                    'system-ui', 
                    'Segoe UI', 
                    'Roboto', 
                    'Helvetica Neue', 
                    'Arial', 
                    'Noto Sans', 
                    'sans-serif', 
                    'Apple Color Emoji', 
                    'Segoe UI Emoji', 
                    'Segoe UI Symbol', 
                    'Noto Color Emoji'
                ]
                }
            }
        }
    </script>

    <!-- for chart -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

    <!-- for datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css" />
    <link rel="stylesheet" href="<?php echo $location_index?>/node_modules/datatables.net-dt/css/dataTables.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> -->

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/css/tw-elements.min.css" /> -->
    <!-- <script src="https://cdn.tailwindcss.com/3.3.0"></script> -->
    <link rel="stylesheet" href="<?php echo $location_index?>/node_modules/tw-elements/css/tw-elements.min.css">
    <!-- <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet" /> -->

    <style>
        input{
          color: black !important;
        }

        [class^="select-dropdown-container-"] {
            background-color: white !important; /* Example style */
        }
    </style>
    <title>
        <?php
            if(isset($title)){echo $title;}
            else{echo "EksTaba";}
        ?>
    </title>
</head>