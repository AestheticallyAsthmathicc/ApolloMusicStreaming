<?PHP
    include("includes/includedFiles.php");

    if(isset($_GET['term'])) {
        $term = urldecode($_GET['term']);
    } else {
        $term = "";
    }
?>

<div class="searchContainer">

    <h4>Search for an artist, album or song</h4>
    <input type="text" class="searchInput" value="<?PHP echo $term; ?>" placeholder="Enter here..." onfocus="this.selectionStart = this.selectionEnd = this.value.length;">
    <!-- onfocus="this.selectionStart = this.selectionEnd = this.value.length;" is a workaround to make the focus move to the end of the input field -->

</div>

<script>
    $(".searchInput").focus();
    $(function() {
        //will search the stuff once entered after 1000 miliseconds aka 1 seconds bruv
        $(".searchInput").keyup(function() {
            clearTimeout(timer);
            timer = setTimeout(function() {
                var val = $(".searchInput").val();
                openPage("search.php?term=" + val);
            }, 1000);
        });
    });
</script>

<?PHP
    if($term == "") exit();
    //to stop the page from loading all the results bruv
?>

<div class="tracklistContainer borderBottom">
    <h2>Songs</h2>
    <ul class="tracklist">
        <?PHP
            $songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '$term%' LIMIT 10");
            //% means anything beofre or after that like it'll search for not just the word but also see the words before or after

            if(mysqli_num_rows($songsQuery) == 0) {
                echo "<span class='noResults'> No songs found matching " . $term . "</span>";
            }

            $songsIdArray = array();
            $i = 1;
            while($row = mysqli_fetch_array($songsQuery)) {

                if($i > 15) {
                    break;
                }

                array_push($songsIdArray, $row['id']);

                $albumSong = new Song($con, $row['id']);
                $albumArtist = $albumSong->getArtist();

                //we used the weird ass quotes with black slashes to turn the value into string other wise it would have been an int and 
                //the function we wrote doesnt take in ints, ya bitch!

                echo "<div class='tracklistContainer'>
                        <li class='tracklistRow'>
                            <div class='trackCount'>
                            <img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
                                <span class='trackNumber'>$i</span>
                            </div>
                            
                            <div class='trackInfo'>
                                <span class='trackName'>" . $albumSong->getTitle() . "</span>
                                <span class='artistName'>" . $albumArtist->getName() . "</span>
                            </div>

                            <div class='trackOptions'>
                                <img class='optionsButton' src='assets/images/icons/more.png'>
                            </div>

                            <div class='trackDuration'>
                                <span class='duration'>" . $albumSong->getDuration() . "</span>
                            </div>
                        </li>
                    </div>";
                $i++;
            }
        ?>

        <script>
            //converting PHP array into a JSON object and then yeeting it into
            //a js array
            var tempSongIds = '<?PHP echo json_encode($songsIdArray); ?>';
            tempPlaylist = JSON.parse(tempSongIds);
        </script>
    </ul>
</div>

<div class="artistsContainer borderBottom tracklistContainer">
    <h2>Artists</h2>

    <?PHP

        $artistsQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '$term%' LIMIT 10");

        if(mysqli_num_rows($artistsQuery) == 0) {
            echo "<span class='noResults'> No artists found matching " . $term . "</span>";
        }

        while($row = mysqli_fetch_array($artistsQuery)) {
            $artistsFound = new Artist($con, $row['id']);
            echo "
            <div class='searchResultRow'>
                <span class='artistName'>
                    <span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artistsFound->getId() . "\")'>
                    "
                    . $artistsFound->getName() .
                    "
                    </span>
                </span>
            </div>
            ";
        }

    ?>

</div>

<div class="gridViewContainer tracklistContainer">
    <h2>Albums</h2>
	<?PHP
		$albumQuery = mysqli_query($con, "SELECT * FROM albums where title LIKE '$term' LIMIT 10");

        if(mysqli_num_rows($albumQuery) == 0) {
            echo "<span class='noResults'> No albums found matching " . $term . "</span>";
        }

		while($row = mysqli_fetch_array($albumQuery)) {
			echo "<div class='gridViewItem'>
					<span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
						<img src='" . $row['artworkPath'] . "'>
						<div class='gridViewInfo'>"
							. $row['title'] . 
						"</div>
					</span>
			      </div>";
		}
	?>
</div>