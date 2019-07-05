<?PHP

    include("../../config.php");

    if(isset($_POST['userId'])) {
        $userId = $_POST['userId'];
        
        $usernameQuery = mysqli_query($con, "SELECT username FROM users WHERE id = '$userId'");
        $userRow = mysqli_fetch_array($usernameQuery);
        $username = $userRow['username'];

        $userQuery = mysqli_query($con, "DELETE FROM users WHERE id = '$userId'");

        $playlistQuery = mysqli_query($con, "SELECT id FROM playlists WHERE owner = '$username'");

        while($userRow = mysqli_fetch_array($playlistQuery)) {
            $playlistId = $userRow['id'];
            $songsQuery = mysqli_query($con, "DELETE FROM playlistSongs WHERE playlistId = '$playlistId'");
        }

        $playlistQuery = mysqli_query($con, "DELETE FROM playlists WHERE owner = '$username'");
    } else {
        echo "Playlist id was not passed into deletePlaylist.php";
    }

?>