<?PHP

    include("../../config.php");

    if(isset($_POST['albumId'])) {
        $albumId = $_POST['albumId'];

        $albumSongDeleteQuery = mysqli_query($con, "DELETE FROM songs WHERE album = '$albumId'");
        $albumDeleteQuery = mysqli_query($con, "DELETE FROM albums WHERE id = '$albumId'");
    } else {
        echo "Song id was not passed into deleteSongs.php";
    }

?>