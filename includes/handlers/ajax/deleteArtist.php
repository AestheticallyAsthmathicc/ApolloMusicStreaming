<?PHP

    include("../../config.php");

    if(isset($_POST['artistId'])) {
        $artistId = $_POST['artistId'];

        $artistSongDeleteQuery = mysqli_query($con, "DELETE FROM songs WHERE artist = '$artistId'");
        $artistAlbumDeleteQuery = mysqli_query($con, "DELETE FROM albums WHERE artist = '$artistId'");
        $artistDeleteQuery = mysqli_query($con, "DELETE FROM artists WHERE id = '$artistId'");
    } else {
        echo "Song id was not passed into deleteSongs.php";
    }

?>