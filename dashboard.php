<?php

global $wpdb;
$data = $wpdb->get_results("SELECT * FROM contact_form");


if(isset($_GET['id']))
{
    $wpdb->delete("contact_form",['id' => $_GET['id']]);
    $a = explode("&&",$_SERVER['REQUEST_URI']);
    header("location:".$a[0]);
}



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table class="table m-auto" style="width: 80%;">
        <tr>
            <th>name</th>
            <th>email</th>
            <th>subject</th>
            <th>Action</th>
        </tr>
        <tr>
        <?php foreach($data as $dd):?>
            <td><?php echo $dd->name; ?></td>
            <td><?php echo $dd->email; ?></td>
            <td><?php echo $dd->subject ;?></td>
            <td>
            <a href="" class="btn btn-outline-success"   value="<?php echo $dd->id;?>">Response</a>
                <a class="btn btn-outline-danger" href="<?php echo $_SERVER['REQUEST_URI'];?>&&id=<?php echo $dd->id;?>" >Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>