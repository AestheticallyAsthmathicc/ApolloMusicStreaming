<?PHP include("includes/includedFiles.php"); 

if(isset($_GET['id'])) {
    $albumId = $_GET['id'];
}
else {
    header("Location: index.php");
}

$album = new Album($con, $albumId);

$artist = $album->getArtist();
$artist = $album->getArtist();
$artistId = $artist->getId();

?>

<script>
    $(".rightSection .artistName").attr("onclick", "openPage('artist.php?id= " + "<?php echo $artistId ?>" + "')");
</script>

<div class="entityInfo borderBottom">
    <div class="leftSection">
        <img src="<?PHP echo $album->getArtworkPath(); ?>" alt="">
    </div>
    <div class="rightSection">
        <h2><?PHP echo $album->getTitle(); ?></h2>
        <p role="link" tabindex="0" class="artistName">By <?PHP echo $artist->getName(); ?></p>
        <p><?PHP echo $album->getNumberOfSongs(); ?> songs</p>
    </div>
</div>

<div class="tracklistContainer">
    <ul class="tracklist">
        <?PHP
            $songsIdArray = $album->getSongIds();
            $i = 1;
            foreach($songsIdArray as $songId) {
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
                                <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                                <img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                            </div>

                            <div class='trackDuration'>
                                <span class='duration'>" . $albumSong->getDuration() . "</span>
                            </div>
                        </li>
                    </div>";
                    //we added a hidden input to know which song is going to be put into a playlist
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

<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?PHP echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>