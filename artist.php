<?PHP 
    include("includes/includedFiles.php"); 
    
    if(isset($_GET['id'])) {
        $artistId = $_GET['id'];
    } else {
        header("Location: index.php");
    }

    $artist = new Artist($con, $artistId);
?>

<div class="entityInfo borderBottom artistHeader" style="background: linear-gradient(transparent, rgb(6, 3, 50)), url('assets/<?php echo $artist->getArtistPic(); ?>') no-repeat center; background-size: cover;">

    <div class="centerSection">
        <div class="artistInfo">
            <h1 class="artistName"><?PHP echo $artist->getName(); ?></h1>
            <div class="headerButtons">
                <button class="button green" onclick="playFirstSong()">PLAY</button>
            </div>
        </div>
    </div>

</div>

<div class="tracklistContainer borderBottom">
    <h2>Popular Songs</h2>
    <ul class="tracklist">
        <?PHP
            $songsIdArray = $artist->getSongIds();
            $i = 1;
            foreach($songsIdArray as $songId) {

                if($i > 5) {
                    break;
                }

                $albumSong = new Song($con, $songId);
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

<div class="gridViewContainer">
    <h2>Albums</h2>
	<?PHP
		$albumQuery = mysqli_query($con, "SELECT * FROM albums where artist='$artistId'");

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