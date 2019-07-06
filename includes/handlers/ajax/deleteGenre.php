<?PHP

    include("../../config.php");

    if(isset($_POST['genreId'])) {
        $genreId = $_POST['genreId'];

        $userQuery = mysqli_query($con, "DELETE FROM genres WHERE id = '$genreId'");
    } else {
        echo "Genre id was not passed into deleteGenre.php";
    }

?>