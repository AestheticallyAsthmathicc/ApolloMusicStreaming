<?PHP 
    include("includes/includedFiles.php");
?>

<h1 class="pageHeadingBig">Dashboard</h1>

<div class="gridViewContainer">
	<?PHP
        $queryUsers = mysqli_query($con, "SELECT * FROM users");
        $querySongs = mysqli_query($con, "SELECT * FROM songs");
        $queryAlbums = mysqli_query($con, "SELECT * FROM albums");
        $queryPlaylists = mysqli_query($con, "SELECT * FROM playlists");
        
        $rowUsers = mysqli_num_rows($queryUsers);
        $rowSongs = mysqli_num_rows($querySongs);
        $rowAlbums = mysqli_num_rows($queryAlbums);
        $rowPlaylists = mysqli_num_rows($queryPlaylists);
        echo "
            <div class='gridViewItem adminView'>
                <div class='gridViewInfo'><h2>Users</h2>" . $rowUsers . "</div>
                <div class='gridViewInfo'><h2>Songs</h2>" . $rowSongs . "</div>
                <div class='gridViewInfo'><h2>Albums</h2>" . $rowAlbums . "</div>
                <div class='gridViewInfo'><h2>Playlists</h2>" . $rowPlaylists . "</div>
            </div>
        ";
	?>
</div>

<script>
    if(adminCheck == 0) {
        openPage('index.php');
        alert("You are trying to acces the admin panel even though you don't have permission to do so!");
    }
</script>