<?php

    session_start();
    require_once "config/db.php";
    
    if (isset($_POST['submit'])){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $position = $_POST['position'];
        $img = $_FILES['img'];
    
        $allow = array('jpg','jpeg','png');
        $extension = explode(".", $img['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt;
        $filePatch = "uploads/".$fileNew;

        if(in_array($fileActExt, $allow)){
            if($img['size'] > 0 && $img['error'] == 0){
                if (move_uploaded_file($img['tmp_name'], $filePatch)){
                    $sql = $conn->prepare("INSERT INTO users(firstname,lastname,position,img) VALUES(:firstname, :lastname, :position, :img)");
                    $sql->bindParam(":firstname",$firstname);
                    $sql->bindParam(":lastname",$lastname);
                    $sql->bindParam(":position",$position);
                    $sql->bindParam(":img",$fileNew);
                    $sql->execute();

                    if($sql){
                        $_SESSION['success'] = "Data has been inserted succesfully";
                        header("location: index.php");
                    }else{
                        $_SESSION['error'] = "Data has not been inserted succesfully";
                        header("location: index.php");
                    }
                }

            }
        }
    }
?>