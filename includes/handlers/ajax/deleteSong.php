<?PHP

    include("../../config.php");

    if(isset($_POST['songId'])) {
        $songId = $_POST['songId'];

        $songQuery = mysqli_query($con, "DELETE FROM songs WHERE id = '$songId'");
    } else {
        echo "Song id was not passed into deleteSongs.php";
    }

?>