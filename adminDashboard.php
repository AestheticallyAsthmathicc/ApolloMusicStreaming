<?PHP 
    include("includes/includedFiles.php");
?>

<h1 class="pageHeadingBig">Dashboard</h1>

<div class="gridViewContainer">
	<?PHP
        $queryUsers = mysqli_query($con, "SELECT * FROM users");
        $qeuryArtists = mysqli_query($con, "SELECT * FROM artists");
        $querySongs = mysqli_query($con, "SELECT * FROM songs");
        $queryAlbums = mysqli_query($con, "SELECT * FROM albums");
        $queryPlaylists = mysqli_query($con, "SELECT * FROM playlists");
        $queryGenres = mysqli_query($con, "SELECT * FROM genres");
        
        $rowUsers = mysqli_num_rows($queryUsers);
        $rowArtists = mysqli_num_rows($qeuryArtists);
        $rowSongs = mysqli_num_rows($querySongs);
        $rowAlbums = mysqli_num_rows($queryAlbums);
        $rowPlaylists = mysqli_num_rows($queryPlaylists);
        $rowGenres = mysqli_num_rows($queryGenres);
        echo "
            <div class='gridViewItem adminView'>
                <div class='gridViewInfo'><h2 onclick='openPage(\"adminUsers.php\")' role='link' tabindex='0'>Users</h2>" . $rowUsers . "</div>
                <div class='gridViewInfo'><h2 onclick='openPage(\"adminArtists.php\")' role='link' tabindex='0'>Artists</h2>" . $rowArtists . "</div>
                <div class='gridViewInfo'><h2 onclick='openPage(\"adminAlbums.php\")' role='link' tabindex='0'>Albums</h2>" . $rowAlbums . "</div>
                <div class='gridViewInfo'><h2 onclick='openPage(\"adminSongs.php\")' role='link' tabindex='0'>Songs</h2>" . $rowSongs . "</div>
                <div class='gridViewInfo'><h2 onclick='openPage(\"adminGenres.php\")' role='link' tabindex='0'>Genres</h2>" . $rowGenres . "</div>
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