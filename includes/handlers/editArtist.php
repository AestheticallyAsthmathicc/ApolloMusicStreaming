<?PHP
   include("../config.php");
?>

<head>
   <link rel="stylesheet" href="../../assets/css/style.css">
   <script src="../../assets/js/script.js"></script>
</head>

<div class="editContainer">
   <h2>Add/Update Artist</h2>
   <form id="form" method="POST" enctype="multipart/form-data">
      <p>
         <label for="idArtist">ID</label>
         <input id="idArtist" name="idArtist" type="text" placeholder="e.g. 1" required>
      </p>
      <label for="name">Name</label>
      <input id="name" name="name" type="text" placeholder="e.g. Tame Impala" required>
      <p>
         <label for="image">Arist Image</label>

         <input type="file" value="Upload Image" name="image" id="image">
      </p>
      <p>
         <input type="submit" value="Upload Image" name="submit">
      </p>
   </form>
   <hr>
</div>

<?php
   if(isset($_POST['submit'])){

      $id = $_POST['idArtist'];
      $name = $_POST['name'];

      $path = $_FILES['image']['name'];
      $file_size = $_FILES['image']['size'];
      $file_tmp = $_FILES['image']['tmp_name'];
      $file_type = $_FILES['image']['type'];
      $file_ext = pathinfo($path, PATHINFO_EXTENSION);
      
      $expensions= array("jpeg","jpg","png");

      $folder_name = strtolower($name);
      $folder_name = str_replace(" ", "-", $folder_name);
      
      $file_name = "artist." . $file_ext;

      $fullDirectory = "music/" . $folder_name;

      $folderCreaton = "../../assets/" . $fullDirectory;

      if (!file_exists($folderCreaton)) {
         mkdir($folderCreaton, 0777, true);
         echo "folder created!";
      }

      $fullDirectory = "music/" . $folder_name . "/" . $file_name;

      if(in_array($file_ext, $expensions) === false){
         echo "<p class='errorsAdmin'>FFile format not allowed, please choose a JPEG, jpg or PNG file!</p>";
         exit();
      }
      
      if($file_size > 20971520) {
         echo "<p class='errorsAdmin'>File size must be excately 20 MB!</p>";
         exit();
      }

      
      if(empty($errors)==true) {
         move_uploaded_file($file_tmp, "../../assets/music/" . $folder_name . "/" . $file_name);

         $idQuery = mysqli_query($con, "SELECT id FROM artists WHERE id = '$id'");

         if(mysqli_num_rows($idQuery) == 0) {
            $addArtist = mysqli_query($con, "INSERT INTO artists (`id`, `name`, `artistPic`) VALUES ('$id', '$name', '$fullDirectory')");
            echo "<p class='errorsAdmin'>Succesfully ddded!</p>";
         } else if (mysqli_num_rows($idQuery) == 1) {
            $addArtist = mysqli_query($con, "UPDATE artists SET id = '$id', name = '$name', artistPic = '$fullDirectory'");
            echo "<p class='errorsAdmin'>Succesfully updated!</p>";
         } else {
            echo "<p class='errorsAdmin'>Duplicate IDs!</p>";
         }

         echo "<script> openPage('adminArtists.php?term=' . term); </script>";
      } else {
         echo "<p class='errorsAdmin'>Unknown error occured!</p>";
      }
   }
?>