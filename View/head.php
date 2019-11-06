<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>User's tasks</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
        table.tasks {
            width: 100%;
        }

        table.tasks thead {
            background-color: #eee;
            text-align: left;
        }

        table.tasks thead th {
            border: solid 1px #fff;
            padding: 3px;
        }

        table.tasks tbody td {
            border: solid 1px #eee;
            padding: 3px;
        }

        a, a:hover, a:active, a:visited {
            color: blue;
            text-decoration: underline;
        }
    </style>
</head>
<body>
<section class="panel-content">