<?PHP
   include("../config.php");

   $numSongs = mysqli_query($con, "SELECT id FROM songs");
   $songsNumbers = mysqli_num_rows($numSongs) + 1;
?>

<head>
   <link rel="stylesheet" href="../../assets/css/style.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="../../assets/js/script.js"></script>
</head>

<div class="editContainer">
   <h2>Add/Update Songs</h2>
   <form id="form" method="POST" enctype="multipart/form-data">
      <p>
         <label for="idSong">ID</label>
         <input id="idSong" name="idSong" type="text" placeholder="e.g. 123" value="<?PHP echo $songsNumbers ?>" required>
      </p>
      <label for="title">Title</label>
      <input id="title" name="title" type="text" placeholder="e.g. Tame Impala" value="<?php echo isset($_POST['title']) ? $_POST['title'] : '' ?>" required>
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
      <label for="album">Album</label>
      <select name="album" id="album">
         <?PHP
            $albumsList  = mysqli_query($con, "SELECT * FROM albums ORDER BY title ASC");
            while($rowAlbums = mysqli_fetch_array($albumsList)) {
               echo "
                  <option value=" . $rowAlbums['id'] . ">" . $rowAlbums['title'] . "</option>
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
      <label for="duration">Duration</label>
      <input id="duration" name="duration" type="text" placeholder="e.g. 6:12" required>
      
      <label for="albumOrder">Album Order</label>
      <input id="albumOrder" name="albumOrder" type="text" placeholder="e.g. 6" required>

      <p>
         <label for="song">Song File</label>

         <input type="file" value="Upload Song" name="song" id="song">
      </p>
      <p>
         <input type="submit" value="ADD/UPDATE" name="submit">
      </p>
   </form>
   <hr>
</div>

<?php
   if(isset($_POST['submit'])){

      $id = $_POST['idSong'];
      $title = $_POST['title'];
      $artist = $_POST['artist'];
      $album = $_POST['album'];
      $genre = $_POST['genre'];
      $duration = $_POST['duration'];
      $albumOrder = $_POST['albumOrder'];

      if(!is_numeric($id)) {
         echo "<p class='errorsAdmin'>Please entered a valid ID!</p>";
         exit();
      }

      if(!is_numeric($albumOrder)) {
        echo "<p class='errorsAdmin'>Please entered a number for album order!</p>";
        exit();
     }

      $path = $_FILES['song']['name'];
      $file_size = $_FILES['song']['size'];
      $file_tmp = $_FILES['song']['tmp_name'];
      $file_type = $_FILES['song']['type'];
      $file_ext = pathinfo($path, PATHINFO_EXTENSION);
      
      $expensions= array("mp3","m4a","flac");

      $artistNameQuery = mysqli_query($con, "SELECT name FROM artists WHERE id = '$artist'");
      $rowArtist = mysqli_fetch_array($artistNameQuery);
      $artistName = $rowArtist['name'];

      $folder_name = strtolower($artistName);
      $folder_name = str_replace(" ", "-", $folder_name);

      $file_name = strtolower($title);
      $file_name = str_replace(" ", "-", $file_name);
      
      $file_name = $file_name . "." . $file_ext;

      $fullDirectory = "assets/music/" . $folder_name . "/" . $file_name;

      if(in_array($file_ext, $expensions) === false){
         echo "<p class='errorsAdmin'>FFile format not allowed, please choose a JPEG, jpg or PNG file!</p>";
         exit();
      }

      if(!preg_match("/^(?:([0-5]?\d):)?([0-5]?\d)$/", $duration)) {
         echo "<p class='errorsAdmin'>Enter the correct duration MM:SS for example: 2:52!</p>";
         exit();
      }
      
      if($file_size > 104857600) {
         echo "<p class='errorsAdmin'>File size must be 100 MB or smaller!</p>";
         exit();
      }
      
      if(empty($errors)==true) {
         move_uploaded_file($file_tmp, "../../assets/music/" . $folder_name . "/" . $file_name);

         $idQuery = mysqli_query($con, "SELECT id FROM songs WHERE id = '$id'");

         if(mysqli_num_rows($idQuery) == 0) {
            $addArtist = mysqli_query($con, "INSERT INTO songs ( id, title, artist, album, genre, duration, path, albumOrder, plays) VALUES ( '$id', '$title', '$artist', '$album', '$genre', '$duration', '$fullDirectory', '$albumOrder', 0)");
            echo "<p class='errorsAdmin'>Succesfully ddded!</p>";
         } else if (mysqli_num_rows($idQuery) == 1) {
            $addArtist = mysqli_query($con, "UPDATE songs SET title='$title', artist='$artist', album='$album', genre='$genre', duration='$duration', path='$fullDirectory', albumOrder='$albumOrder', plays=0 WHERE id='$id'");
            echo "<p class='errorsAdmin'>Succesfully updated!</p>";
         } else {
            echo "<p class='errorsAdmin'>Duplicate IDs!</p>";
         }
      } else {
         echo "<p class='errorsAdmin'>Unknown error occured!</p>";
      }
   }
?>