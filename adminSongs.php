<?PHP 
    include("includes/includedFiles.php");

    if(isset($_GET['term'])) {
        $term = urldecode($_GET['term']);
    } else {
        $term = "";
    }
?>

<h1 class="pageHeadingBig">Songs Dashboard</h1>

<div class="searchContainer">

    <h4>Search for songs via song, artist or album name</h4>
    <input type="text" class="searchInput" value="<?PHP echo $term; ?>" placeholder="Enter here..."
        onfocus="this.selectionStart = this.selectionEnd = this.value.length;">
    <!-- onfocus="this.selectionStart = this.selectionEnd = this.value.length;" is a workaround to make the focus move to the end of the input field -->

</div>

<div class="artistsContainer borderBottom tracklistContainer">
    <h2>Results</h2>

    <?PHP

        $songsQuery = mysqli_query($con, "SELECT * FROM songs WHERE lower(title) LIKE lower('$term%')");

        echo "
            <h1 class='pageHeadingBig'>Search via Song name<h1>
            <div class='tableContainer'>
            <table class='tableBody'>
                <tr>
                    <th class='tableHeading'>ID</th>
                    <th class='tableHeading'>Title</th>
                    <th class='tableHeading'>Artist</th>
                    <th class='tableHeading'>Album</th>
                    <th class='tableHeading'>Genre</th>
                    <th class='tableHeading'>Duration</th>
                    <th class='tableHeading'>Path</th>
                    <th class='tableHeading'>Album Order</th>
                    <th class='tableHeading'>Plays</th>
                    <th class='tableHeading'>Delete</th>
        ";

        if(mysqli_num_rows($songsQuery) == 0) {
            echo "<span class='noResults showError'> No songs found matching " . $term . "</span>";
        }

        while($row = mysqli_fetch_array($songsQuery)) {
            $artistId = $row['artist'];
            $genreId = $row['genre'];
            $albumId = $row['album'];
            $artistQueryForSongs = mysqli_query($con, "SELECT name FROM artists WHERE id = '$artistId'");
            $rowArtists = mysqli_fetch_array($artistQueryForSongs);
            $genreQueryForSongs = mysqli_query($con, "SELECT name FROM genres WHERE id = '$genreId'");
            $rowGenre = mysqli_fetch_array($genreQueryForSongs);
            $albumQueryForSongs = mysqli_query($con, "SELECT title FROM albums WHERE id = '$albumId'");
            $rowAlbum = mysqli_fetch_array($albumQueryForSongs);
            $songId = $row['id'];
            echo "</tr>
                    <tr>
                    <td class='tableRows'> " . $songId . "</td>
                    <td class='tableRows'> " . $row['title'] . "</td>
                    <td class='tableRows'> " . $rowArtists['name'] . "</td>
                    <td class='tableRows'> " . $rowAlbum['title'] . "</td>
                    <td class='tableRows'> " . $rowGenre['name'] . "</td>
                    <td class='tableRows'> " . $row['duration'] . "</td>
                    <td class='tableRows'> " . $row['path'] . "</td>
                    <td class='tableRows'> " . $row['albumOrder'] . "</td>
                    <td class='tableRows'> " . $row['plays'] . "</td>
                    <td class='tableRows'><button onclick='deleteSong(" . $songId . ", val)' class='button button-admin'>Delete</button></td>
                  </tr>
            ";
        }

        echo "</table>
        </div>";

        //ARTSIT SEARCH RESULT

        $artistsQuery = mysqli_query($con, "SELECT * FROM artists WHERE lower(name) LIKE lower('$term%')");

    
        echo "
            <h1 class='pageHeadingBig'>Search via Artist name<h1>
            <div class='tableContainer'>
            <table class='tableBody'>
            <tr>
                <th class='tableHeading'>ID</th>
                <th class='tableHeading'>Title</th>
                <th class='tableHeading'>Artist</th>
                <th class='tableHeading'>Album</th>
                <th class='tableHeading'>Genre</th>
                <th class='tableHeading'>Duration</th>
                <th class='tableHeading'>Path</th>
                <th class='tableHeading'>Album Order</th>
                <th class='tableHeading'>Plays</th>
                <th class='tableHeading'>Delete</th>
        ";

        if(mysqli_num_rows($artistsQuery) == 0) {
            echo "<span class='noResults showError'> No artists found matching " . $term . "</span>";
        }

        $row = mysqli_fetch_array($artistsQuery);
        $artistId = $row['id'];
        $songsQueryForArtists = mysqli_query($con, "SELECT * FROM songs WHERE artist = '$artistId'");

        while($rowSongs = mysqli_fetch_array($songsQueryForArtists)) {
            if($term == "") break;
            $albumQueryForArtists = mysqli_query($con, "SELECT title FROM albums WHERE artist = '$artistId'");
            $rowAlbums = mysqli_fetch_array($albumQueryForArtists);
            $genreId = $rowSongs['genre'];
            $genreQueryForAlbums = mysqli_query($con, "SELECT name FROM genres WHERE id = '$genreId'");
            $rowGenre = mysqli_fetch_array($genreQueryForAlbums);
            $songId = $rowSongs['id'];
            echo "</tr>
                    <tr>
                    <td class='tableRows'> " . $songId . "</td>
                    <td class='tableRows'> " . $rowSongs['title'] . "</td>
                    <td class='tableRows'> " . $row['name'] . "</td>
                    <td class='tableRows'> " . $rowAlbums['title'] . "</td>
                    <td class='tableRows'> " . $rowGenre['name'] . "</td>
                    <td class='tableRows'> " . $rowSongs['duration'] . "</td>
                    <td class='tableRows'> " . $rowSongs['path'] . "</td>
                    <td class='tableRows'> " . $rowSongs['albumOrder'] . "</td>
                    <td class='tableRows'> " . $rowSongs['plays'] . "</td>
                    <td class='tableRows'><button onclick='deleteSong(" . $songId . ", val)' class='button button-admin'>Delete</button></td>
                  </tr>
            ";
        }

        echo "</table>
        </div>";

        //ALBUMS SEARCH RESULT

        $albumsQuery = mysqli_query($con, "SELECT * FROM albums WHERE lower(title) LIKE lower('$term%')");

    
        echo "
            <h1 class='pageHeadingBig'>Search via Albums name<h1>
            <div class='tableContainer'>
            <table class='tableBody'>
            <tr>
                <th class='tableHeading'>ID</th>
                <th class='tableHeading'>Title</th>
                <th class='tableHeading'>Artist</th>
                <th class='tableHeading'>Album</th>
                <th class='tableHeading'>Genre</th>
                <th class='tableHeading'>Duration</th>
                <th class='tableHeading'>Path</th>
                <th class='tableHeading'>Album Order</th>
                <th class='tableHeading'>Plays</th>
                <th class='tableHeading'>Delete</th>
        ";

        if(mysqli_num_rows($albumsQuery) == 0) {
            echo "<span class='noResults showError'> No albums found matching " . $term . "</span>";
        }

        $row = mysqli_fetch_array($albumsQuery);
        $albumId = $row['id'];
        $songsQueryForAlbums = mysqli_query($con, "SELECT * FROM songs WHERE album = '$albumId'");

        while($rowSongs = mysqli_fetch_array($songsQueryForAlbums)) {
            if($term == "") break;
            $albumQueryForAlbums = mysqli_query($con, "SELECT title, artist FROM albums WHERE id = '$albumId'");
            $rowAlbums = mysqli_fetch_array($albumQueryForAlbums);
            $genreId = $rowSongs['genre'];
            $genreQueryForAlbums = mysqli_query($con, "SELECT name FROM genres WHERE id = '$genreId'");
            $rowGenre = mysqli_fetch_array($genreQueryForAlbums);
            $artistId = $rowAlbums['artist'];
            $artistQueryForAlbums = mysqli_query($con, "SELECT name FROM artists WHERE id='$artistId'");
            $rowArtist = mysqli_fetch_array($artistQueryForAlbums);
            $songId = $rowSongs['id'];
            echo "</tr>
                    <tr>
                    <td class='tableRows'> " . $songId . "</td>
                    <td class='tableRows'> " . $rowSongs['title'] . "</td>
                    <td class='tableRows'> " . $rowArtist['name'] . "</td>
                    <td class='tableRows'> " . $rowAlbums['title'] . "</td>
                    <td class='tableRows'> " . $rowGenre['name'] . "</td>
                    <td class='tableRows'> " . $rowSongs['duration'] . "</td>
                    <td class='tableRows'> " . $rowSongs['path'] . "</td>
                    <td class='tableRows'> " . $rowSongs['albumOrder'] . "</td>
                    <td class='tableRows'> " . $rowSongs['plays'] . "</td>
                    <td class='tableRows'><button onclick='deleteSong(" . $songId . ", val)' class='button button-admin'>Delete</button></td>
                  </tr>
            ";
        }

        echo "</table>
        </div>";
    ?>

</div>


<iframe src="includes/handlers/editSongs.php" frameborder="0" scrolling="no"></iframe>


<script>
    if (adminCheck == 0) {
        openPage('index.php');
        alert("You are trying to acces the admin panel even though you don't have permission to do so!");
    }

    $(".searchInput").focus();
    var val;
    $(function () {
        //will search the stuff once entered after 1000 miliseconds aka 1 seconds bruv
        $(".searchInput").keyup(function () {
            clearTimeout(timer);
            timer = setTimeout(function () {
                val = $(".searchInput").val();
                openPage("adminSongs.php?term=" + val);
            }, 1000);
        });
    });
</script>
