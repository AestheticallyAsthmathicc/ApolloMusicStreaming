<?PHP include("includes/includedFiles.php"); 

if(isset($_GET['id'])) {
    $playlistId = $_GET['id'];
}
else {
    header("Location: index.php");
}

$playlist = new Playlist($con, $playlistId);

$owner = new User($con, $playlist->getOwner());

?>

<div class="entityInfo borderBottom">
    <div class="leftSection">
        <div class="playlistImage">
            <img src="assets/images/icons/playlist.png" alt="">
        </div>
    </div>
    <div class="rightSection">
        <h2><?PHP echo $playlist->getName(); ?></h2>
        <p>By <?PHP echo $playlist->getOwner(); ?></p>
        <p><?PHP echo $playlist->getNumberOfSongs(); ?> songs</p>
        <button class="button" onclick="deletePlaylist('<?PHP echo $playlistId; ?>')">Delete Playlist</button>
    </div>
</div>

<div class="tracklistContainer">
    <ul class="tracklist">
        <?PHP
            $songsIdArray = $playlist->getSongIds();
            $i = 1;
            foreach($songsIdArray as $songId) {
                $playlistSong = new Song($con, $songId);
                $songArtist = $playlistSong->getArtist();

                //we used the weird ass quotes with black slashes to turn the value into string other wise it would have been an int and 
                //the function we wrote doesnt take in ints, ya bitch!

                echo "<div class='tracklistContainer'>
                        <li class='tracklistRow'>
                            <div class='trackCount'>
                            <img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $playlistSong->getId() . "\", tempPlaylist, true)'>
                                <span class='trackNumber'>$i</span>
                            </div>
                            
                            <div class='trackInfo'>
                                <span class='trackName'>" . $playlistSong->getTitle() . "</span>
                                <span class='artistName'>" . $songArtist->getName() . "</span>
                            </div>

                            <div class='trackOptions'>
                                <input type='hidden' class='songId' value='" . $playlistSong->getId() . "'>
                                <img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                            </div>

                            <div class='trackDuration'>
                                <span class='duration'>" . $playlistSong->getDuration() . "</span>
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

<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?PHP echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
    <div class="item" onclick="removeFromPlaylist(this, '<?php echo $playlistId; ?>')">Remove from playlist</div>
</nav>