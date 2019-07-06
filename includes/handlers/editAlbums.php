<?PHP
   include("../config.php");
?>

<head>
   <link rel="stylesheet" href="../../assets/css/style.css">
   <script src="../../assets/js/script.js"></script>
</head>

<div class="editContainer">
   <h2>Add/Update Albums</h2>
   <form id="form" method="POST" enctype="multipart/form-data">
      <p>
         <label for="idAlbum">ID</label>
         <input id="idAlbum" name="idAlbum" type="text" placeholder="e.g. 123" required>
      </p>
      <p>
         <label for="title">Title</label>
         <input id="title" name="title" type="text" placeholder="e.g. Currents" required>
      </p>
      <label for="artist">Artist</label>
      <select name="artist" id="artist">
         <?PHP
            $artistsList  = mysqli_query($con, "SELECT * FROM artists ORDER BY name ASC");
            while($row = mysqli_fetch_array($artistsList)) {
               echo "
                  <option value=" . $row['id'] . ">" . $row['name'] . "</option>
               ";
            }
         ?>
      </select>
      <label for="genre">Genre</label>
      <select name="genre" id="genre">
         <?PHP
            $genreList  = mysqli_query($con, "SELECT * FROM genres ORDER BY name ASC");
            while($row = mysqli_fetch_array($genreList)) {
               echo "
                  <option value=" . $row['id'] . ">" . $row['name'] . "</option>
               ";
            }
         ?>
      </select>
      <p>
         <label for="image">Artwork Image</label>

         <input type="file" value="Upload Image" name="image" id="image">
      </p>
      <p>
         <input type="submit" value="ADD/UPDATE Album" name="submit">
      </p>
   </form>
   <hr>
</div>

<?php
   if(isset($_POST['submit'])){

      $id = $_POST['idAlbum'];
      $title = $_POST['title'];
      $artistId = $_POST['artist'];
      $genreId = $_POST['genre'];

      if(!is_numeric($id)) {
         echo "<p class='errorsAdmin'>Please entered a valid ID!</p>";
         exit();
      }

      $artistNameQuery = mysqli_query($con, "SELECT name FROM artists WHERE id = '$artistId'");
      $rowArtist = mysqli_fetch_array($artistNameQuery);
      $name = $rowArtist['name'];

      $path = $_FILES['image']['name'];
      $file_size = $_FILES['image']['size'];
      $file_tmp = $_FILES['image']['tmp_name'];
      $file_type = $_FILES['image']['type'];
      $file_ext = pathinfo($path, PATHINFO_EXTENSION);
      
      $expensions= array("jpeg","jpg","png");

      $folder_name = strtolower($name);
      $folder_name = str_replace(" ", "-", $folder_name);

      $title_name = strtolower($title);
      $title_name = str_replace(" ", "", $title_name);
      
      $file_name = $title_name . "." . $file_ext;

      $folderCreaton = "../../assets/images/artwork/" . $folder_name;

      if (!file_exists($folderCreaton)) {
         mkdir($folderCreaton, 0777, true);
      }

      $fullDirectory = $folderCreaton . "/" . $file_name;

      $fullDirectory = str_replace("../../", "", $fullDirectory);

      if(in_array($file_ext, $expensions) === false){
         echo "<p class='errorsAdmin'>FFile format not allowed, please choose a MP4, M4A or FLAC file!</p>";
         exit();
      }
      
      if($file_size > 20971520) {
         echo "<p class='errorsAdmin'>File size must be excately 20 MB!</p>";
         exit();
      }

      
      if(empty($errors)==true) {
         move_uploaded_file($file_tmp, "../../assets/images/artwork/" . $folder_name . "/" . $file_name);
         
         $idQuery = mysqli_query($con, "SELECT id FROM albums WHERE id = '$id'");

         if(mysqli_num_rows($idQuery) == 0) {
            $addArtist = mysqli_query($con, "INSERT INTO albums (`id`, `title`, `artist`, `genre`, `artworkPath`) VALUES ('$id', '$title', '$artistId', '$genreId', '$fullDirectory')");
            echo "<p class='errorsAdmin'>Succesfully ddded!</p>";
         } else if (mysqli_num_rows($idQuery) == 1) {
            $addArtist = mysqli_query($con, "UPDATE albums SET title = '$title', artist = '$artistId', genre= '$genreId', artworkPath = '$fullDirectory' WHERE id = '$id'");
            echo "<p class='errorsAdmin'>Succesfully updated!</p>";
         } else {
            echo "<p class='errorsAdmin'>Duplicate IDs!</p>";
         }
      } else {
         echo "<p class='errorsAdmin'>Unknown error occured!</p>";
      }
   }
?>