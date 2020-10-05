<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" crossorigin="anonymous">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <?php 
        session_start();
        define('REMOTE_URL','http://school.local');
        require_once("../API/Database.php");
        require_once("../API/Settings.php");
    ?>
</head>
<body>
<table class="table table-responsive-sm">
    <thead>
    <tr>
        <th scope="col">Naam</th>
        <th scope="col">Jaar</th>
        <th scope="col">Title</th>
        <th scope="col">Role</th>
        <th scope="col"><a class="btn btn-create" href="<?php echo REMOTE_URL?>/admin-kanidaten/create.php"><i class="fas fa-plus"></i></a></th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td>Naam volledig</td>
            <td>Jaar</td>
            <td>Title</td>
            <td>Role</td>
            <td>
                <a class="btn btn-sm d-inline-block" href="<?php echo REMOTE_URL?>/admin-kanidaten/select.php"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm d-inline-block" href="<?php echo REMOTE_URL?>/admin-kanidaten/edit.php"><i class="fas fa-pencil-alt"></i></a>
                <button class="btn btn-sm" id="delete-btn"><i class="fas fa-trash"></i></button>
            </td>
        </tr>
    </tbody>
</table>
</body>
</html>