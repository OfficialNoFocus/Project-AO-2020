<?php
    session_start();
    define('REMOTE_URL','http://school.local');
    require_once($_SERVER['DOCUMENT_ROOT']."/API/Database.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/API/Settings.php");
    require($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');
    if($_GET['role'] == 'photographer') {
        $graphers = (new API\Database(API\Settings::getDatabaseCredentials()))->getPhotographers();
    } 
    else {
        $graphers = (new API\Database(API\Settings::getDatabaseCredentials()))->getVideographers();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" crossorigin="anonymous">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>
<body>
<table class="table table-responsive-sm">
    <thead>
    <tr>
        <th scope="col">Naam</th>
        <th scope="col">Jaar</th>
        <th scope="col">Role</th>
        <th scope="col">Title</th>
        <th scope="col"><a class="btn btn-create" href="<?php echo REMOTE_URL?>/admin-kanidaten/create.php"><i class="fas fa-plus"></i></a></th>
    </tr>
    </thead>
    <tbody>
    <?php
        foreach($graphers as $id => $grapher) {
            echo '<tr>';
            
            foreach($grapher as $column){
                echo  "<td>".$column."</td>";
            }
            echo '
            <td>
                <a class="btn btn-sm d-inline-block" href="'.REMOTE_URL.'/admin-kanidaten/select.php?id='.$id.'"><i class="fas fa-eye"></i></a>
                <a class="btn btn-sm d-inline-block" href="'.REMOTE_URL.'/admin-kanidaten/edit.php?id='.$id.'"><i class="fas fa-pencil-alt"></i></a>
                <button class="btn btn-sm" id="delete-btn"><i class="fas fa-trash"></i></button>
            </td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
</body>
</html>