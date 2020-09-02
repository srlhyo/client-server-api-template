<?php

// a script to upload an image and save it in the project

// a form to upload the file
// fetch the file
// do some checks to make sure that conditions are met
// save the file in the specified folder
// redirect the user to the form page

if(isset($_POST["submit"])){
    var_dump($file = $_FILES["file"]);
    echo "<br>";
    echo "<br>";
    $name = $file["name"];    
    $type = $file["type"];    
    $tmp_name = $file["tmp_name"];    
    $error = $file["error"];    
    $size = $file["size"];
    
    $fileInfo = explode(".", $name);
    $fileExtension = strtolower(end($fileInfo));
    $isExtension = array("jpg", "jpeg", "png", "pdf");

    if(in_array($fileExtension, $isExtension)) {
        if($error === 0) {
            if($size < 30000) {
                echo $finalFile = $fileInfo[0] . "." . $fileExtension;
                move_uploaded_file($tmp_name, "uploads/" . $finalFile);
                // header("Location: index.php");

            } else {
                echo "File is too big!";
            }
        } else {
            echo "Sorry, there in an error.";
        }
    } else {
        echo "Invalid file extension";
    }

    
}

?>
    
<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="file">
    <button type="submit" name="submit">submit</button>
</form>
