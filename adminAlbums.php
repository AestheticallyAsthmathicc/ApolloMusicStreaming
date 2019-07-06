<?PHP 
    include("includes/includedFiles.php");

    if(isset($_GET['term'])) {
        $term = urldecode($_GET['term']);
    } else {
        $term = "";
    }
?>

<h1 class="pageHeadingBig">Albums Dashboard</h1>

<div class="searchContainer">

    <h4>Search for an album via album or artist name</h4>
    <input type="text" class="searchInput" value="<?PHP echo $term; ?>" placeholder="Enter here..."
        onfocus="this.selectionStart = this.selectionEnd = this.value.length;">
    <!-- onfocus="this.selectionStart = this.selectionEnd = this.value.length;" is a workaround to make the focus move to the end of the input field -->

</div>

<div class="artistsContainer borderBottom tracklistContainer">
    <h2>Results</h2>

    <?PHP

        $albumsQuery = mysqli_query($con, "SELECT * FROM albums WHERE lower(title) LIKE lower('$term%')");

        echo "
            <h1 class='pageHeadingBig'>Search via Album name<h1>
            <div class='tableContainer'>
            <table class='tableBody'>
                <tr>
                    <th class='tableHeading'>ID</th>
                    <th class='tableHeading'>Title</th>
                    <th class='tableHeading'>Artist</th>
                    <th class='tableHeading'>Genre</th>
                    <th class='tableHeading'>Artwork Path</th>
                    <th class='tableHeading'>Delete</th>
        ";

        if(mysqli_num_rows($albumsQuery) == 0) {
            echo "<span class='noResults showError'> No albums found matching " . $term . "</span>";
        }

        while($row = mysqli_fetch_array($albumsQuery)) {
            $artistId = $row['artist'];
            $genreId = $row['genre'];
            $artistQueryForAlbums = mysqli_query($con, "SELECT name FROM artists WHERE id = '$artistId'");
            $rowArtists = mysqli_fetch_array($artistQueryForAlbums);
            $genreQueryForAlbums = mysqli_query($con, "SELECT name FROM genres WHERE id = '$genreId'");
            $rowGenre = mysqli_fetch_array($genreQueryForAlbums);
            $albumId = $row['id'];
            echo "</tr>
                    <tr>
                    <td class='tableRows'> " . $albumId . "</td>
                    <td class='tableRows'> " . $row['title'] . "</td>
                    <td class='tableRows'> " . $rowArtists['name'] . "</td>
                    <td class='tableRows'> " . $rowGenre['name'] . "</td>
                    <td class='tableRows'> " . $row['artworkPath'] . "</td>
                    <td class='tableRows'><button onclick='deleteArtist(" . $albumId . ", val)' class='button button-admin'>Delete</button></td>
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
                    <th class='tableHeading'>Genre</th>
                    <th class='tableHeading'>Artwork Path</th>
                    <th class='tableHeading'>Delete</th>
        ";

        if(mysqli_num_rows($artistsQuery) == 0) {
            echo "<span class='noResults showError'> No artists found matching " . $term . "</span>";
        }

        while($row = mysqli_fetch_array($artistsQuery)) {
            $artistId = $row['id'];
            $albumQueryForArtists = mysqli_query($con, "SELECT * FROM albums WHERE artist = '$artistId'");
            $rowAlbums = mysqli_fetch_array($albumQueryForArtists);
            $genreId = $rowAlbums['genre'];
            $genreQueryForAlbums = mysqli_query($con, "SELECT name FROM genres WHERE id = '$genreId'");
            $rowGenre = mysqli_fetch_array($genreQueryForAlbums);
            $albumId = $rowAlbums['id'];
            echo "</tr>
                    <tr>
                    <td class='tableRows'> " . $albumId . "</td>
                    <td class='tableRows'> " . $rowAlbums['title'] . "</td>
                    <td class='tableRows'> " . $row['name'] . "</td>
                    <td class='tableRows'> " . $rowGenre['name'] . "</td>
                    <td class='tableRows'> " . $rowAlbums['artworkPath'] . "</td>
                    <td class='tableRows'><button onclick='deleteArtist(" . $albumId . ", val)' class='button button-admin'>Delete</button></td>
                  </tr>
            ";
        }

        echo "</table>
        </div>";

    ?>

</div>


<iframe src="includes/handlers/editAlbums.php" frameborder="0" scrolling="no"></iframe>


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
                openPage("adminAlbums.php?term=" + val);
            }, 1000);
        });
    });
</script>
