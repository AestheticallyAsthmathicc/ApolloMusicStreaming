<?PHP

    $songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");
    $resultArray = array();
    while($row = mysqli_fetch_array($songQuery)){
        array_push($resultArray, $row['id']);
    }

    $jsonArray = json_encode($resultArray);
    
?>

<script>
    $(document).ready(function() {
        var newPlaylist = <?PHP echo $jsonArray ?>;
        audioElement = new Audio();
        setTrack(newPlaylist[0], newPlaylist, false);
        updateVolumeProgressBar(audioElement.audio);

        $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e){  
            e.preventDefault();
        });

        $(".playbackBar .progressBar").mousedown(function() {
            mouseDown = true;
        });

        $(".playbackBar .progressBar").mousemove(function(e) {
            if(mouseDown == true) {
                //set time of song dependding on the positiong of mouse
                timeFromOffset(e, this);
            }
        });

        $(".playbackBar .progressBar").mouseup(function(e) {
            timeFromOffset(e, this);
        });

        $(document).mouseup(function(){
            mouseDown = false;
        });

        //volume shite

        $(".volumeBar .progressBar").mousedown(function() {
            mouseDown = true;
        });

        $(".volumeBar .progressBar").mousemove(function(e) {
            if(mouseDown == true) {
                var percantage = e.offsetX / $(this).width();
                if((percantage >= 0) && (percantage <= 1)) {
                    audioElement.audio.volume = percantage;
                }
            }
        });

        $(".volumeBar .progressBar").mouseup(function(e) {
            var percantage = e.offsetX / $(this).width();
            if((percantage >= 0) && (percantage <= 1)) {
                audioElement.audio.volume = percantage;
            }
        });
    });

    function timeFromOffset(mouse, progressBar) {
        var percantage = mouse.offsetX / $(progressBar).width() * 100;
        var seconds = audioElement.audio.duration * (percantage / 100);
        audioElement.setTime(seconds);
    }

    function prevSong() {
        //this will just restart the song if it passes 5 seconds or if the index/plalist 0 is the song will just go to the start
        if(audioElement.audio.currentTime >= 5 || currentIndex == 0) {
            audioElement.setTime(0);
        } else {
            currentIndex--;
            setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
        }
    }

    function nextSong() {

        if(repeat) {
            audioElement.setTime(0);
            playSong();
            return;
        }

        if(currentIndex == currentPlaylist.lenght - 1) {
            currentIndex = 0;
        } else {
            currentIndex++;
        }
        //if shuffle is true then oogly boogly with the shuffle one,
        //if not then with the normal yeet will happen
        var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
        setTrack(trackToPlay, currentPlaylist, true);
    }

    function setRepeat() {
        repeat = !repeat;
        var imageName = repeat ? "repeat-active.png" : "repeat.png";
        $(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
    }
    
    function setMute() {
        audioElement.audio.muted = !audioElement.audio.muted;
        var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
        $(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
    }

    function setShuffle() {
        shuffle = !shuffle;
        var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
        $(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);

        if(shuffle) {
            //randomizing the playlsit
            shuffleArray(shufflePlaylist);
            //storing the index of shuffled song from currentPL into shPL to shuffle it right
            currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
        } else {
            //regular/unshuffled playlist
            currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
        }
    }

    function shuffleArray(a) {
        var j, x, i;
        for(i = a.length; i; i--) {
            j = Math.floor(Math.random() * 1);
            x = a[i - 1];
            a[i - 1] = a[j];
            a[j] = x;
        }
    }

    function setTrack(trackId, newPlaylist, play) {
        // this will set a new playlist in the currentPlaylist and then that
        // will shuffle it everytime when a new playlist is selected.
        if(newPlaylist != currentPlaylist) {
            currentPlaylist = newPlaylist;
            shufflePlaylist = currentPlaylist.slice(); //slice = copy
            shuffleArray(shufflePlaylist);
        }

        if(shuffle) {
            currentIndex = shufflePlaylist.indexOf(trackId);
        } else {
            currentIndex = currentPlaylist.indexOf(trackId);
        }
        pauseSong();

        $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {

            var track = JSON.parse(data);

            $(".trackName span").text(track.title);

            $.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data) {
                var artist = JSON.parse(data);
                $(".artistName span").text(artist.name);
                $(".artistName span").attr("onclick", "openPage('artist.php?id= " + artist.id + "')");
            });

            $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data) {
                var album = JSON.parse(data);
                $(".albumLink img").attr("src", album.artworkPath);
                $(".albumLink img").attr("onclick", "openPage('album.php?id= " + album.id + "')");
                $(".trackName span").attr("onclick", "openPage('album.php?id= " + album.id + "')");
            });

            audioElement.setTrack(track);

            if(play) {
                playSong();
            }
        });
    }

    function playSong() {

        if (audioElement.audio.currentTime == 0) {
            $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
        } 

        $(".controlButton.play").hide();
        $(".controlButton.pause").show();
        audioElement.play();
    }

    function pauseSong() {
        $(".controlButton.play").show();
        $(".controlButton.pause").hide();
        audioElement.pause();
    }
</script>

<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">
        <div id="nowPlayingLeft">
            <div class="content">
                <span class="albumLink">
                    <img role="link" tabindex="0" class="albumArtwork" src="" alt="Album Artwork">
                </span>

                <div class="trackInfo">
                    <span class="trackName">
                        <span role="link" tabindex="0"></span>
                    </span>

                    <span class="artistName">
                        <span role="link" tabindex="0"></span>
                    </span>

                </div>

            </div>
        </div>

        <div id="nowPlayingCenter">
            <div class="content playerControls">
                <div class="buttons">

                    <button class="controlButton shuffle" title="Shuffle" onclick="setShuffle()"><img src="assets/images/icons/shuffle.png"
                            alt="Shuffle"></button>
                    <button class="controlButton previous" title="Previous" onclick="prevSong()"><img src="assets/images/icons/previous.png"
                            alt="Previous"></button>
                    <button class="controlButton play" title="Play"><img src="assets/images/icons/play.png"
                            alt="Play" onclick="playSong()"></button>
                    <button class="controlButton pause" title="Pause" style="display: none;"><img
                            src="assets/images/icons/pause.png" alt="Pause" onclick="pauseSong()"></button>
                    <button class="controlButton next" title="Next" onclick="nextSong()"><img src="assets/images/icons/next.png"
                            alt="Next"></button>
                    <button class="controlButton repeat" title="Repeat" onclick="setRepeat()"><img src="assets/images/icons/repeat.png"
                            alt="Repeat"></button>

                </div>

                <div class="playbackBar">
                    <span class="progressTime current">0:00</span>

                    <div class="progressBar">
                        <div class="progressBarBg">
                            <div class="progress"></div>
                        </div>
                    </div>

                    <span class="progressTime remaining">0:00</span>

                </div>
            </div>
        </div>

        <div id="nowPlayingRight">
            <div class="volumeBar">
                <button class="controlButton volume" title="Volume" onclick="setMute()">
                    <img src="assets/images/icons/volume.png" alt="Volume">
                </button>
                <div class="progressBar">
                    <div class="progressBarBg">
                        <div class="progress"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>