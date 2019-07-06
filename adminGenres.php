<?PHP 
    include("includes/includedFiles.php");

    if(isset($_GET['term'])) {
        $term = urldecode($_GET['term']);
    } else {
        $term = "";
    }
?>

<h1 class="pageHeadingBig">Genres Dashboard</h1>

<div class="searchContainer">

    <h4>Search for a genre via genre name</h4>
    <input type="text" class="searchInput" value="<?PHP echo $term; ?>" placeholder="Enter here..." onfocus="this.selectionStart = this.selectionEnd = this.value.length;">
    <!-- onfocus="this.selectionStart = this.selectionEnd = this.value.length;" is a workaround to make the focus move to the end of the input field -->

</div>

<div class="artistsContainer borderBottom tracklistContainer">
    <h2>Results</h2>

    <?PHP

        $genreQuery = mysqli_query($con, "SELECT * FROM genres WHERE lower(name) LIKE lower('$term%')");

        if(mysqli_num_rows($genreQuery) == 0) {
            echo "<span class='noResults showError'> No genre found matching " . $term . "</span>";
        }

        echo "<div class='tableContainer'>
            <table class='tableBody'>
                <tr>
                    <th class='tableHeading'>ID</th>
                    <th class='tableHeading'>Name</th>
                    <th class='tableHeading'>Delete</th>
        ";

        while($row = mysqli_fetch_array($genreQuery)) {
            $genreId = $row['id'];
            echo "</tr>
                    <tr>
                    <td class='tableRows'> " . $genreId . "</td>
                    <td class='tableRows'> " . $row['name'] . "</td>
                    <td class='tableRows'><button onclick='deleteGenre(" . $genreId . ", val)' class='button button-admin'>Delete</button></td>
                  </tr>
            ";
        }

        echo "</table>
        </div>";

    ?>

</div>

<div class="editContainer">
    <h2>Add/Update User</h2>
        <p>
	    	<label for="idGenre">ID</label>
	    	<input id="idGenre" name="idGenre" type="text" placeholder="e.g. 123" required>
	    </p>
        <p>
	    	<label for="name">Name</label>
	    	<input id="name" name="name" type="text" placeholder="e.g. Rock" required>
	    </p>

        <button type="submit" onclick="updateGenre('idGenre', 'name')">Add/Update</button>
        
        <hr>
</div>

<script>
    if(adminCheck == 0) {
        openPage('index.php');
        alert("You are trying to acces the admin panel even though you don't have permission to do so!");
    }

    $(".searchInput").focus();
    var val;
    $(function() {
        //will search the stuff once entered after 1000 miliseconds aka 1 seconds bruv
        $(".searchInput").keyup(function() {
            clearTimeout(timer);
            timer = setTimeout(function() {
                val = $(".searchInput").val();
                openPage("adminGenres.php?term=" + val);
            }, 1000);
        });
    });
</script>

