<?php

$title = "Upload new Image";

$content = '<form action="" method="post" enctype="multipart/form-data">
    <label for="file">Filename: </label>
    <input type="file" name="file" id="file"><br/>
    <input type="submit" name="submit" value="submit">
   </form>';

if(isset($_POST["submit"]))
{    
$fileType = $_FILES["file"]["type"];
$fileName = $_FILES["file"]["name"];

  if(($fileType == "image/gif") ||
        ($fileType == "image/jpeg") ||
        ($fileType == "image/jpg") ||
        ($fileType == "image/png"))
  {
    if(file_exists("Images/Coffee/".$fileName))
    {
        echo "File already exists";
    }
    else{
        move_uploaded_file($_FILES["file"]["tmp_name"], "Images/Coffee/".$fileName);
        echo "Uploaded in " . "Images/Coffee/".$fileName;
    }
  }
}
include './Template.php';
?>

