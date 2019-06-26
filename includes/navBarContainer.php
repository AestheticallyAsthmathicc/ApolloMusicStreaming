<div id="navBarContainer">
    <nav class="navBar">
        <span role="link" tabindex="0" onclick="openPage('index.php')" class="logo">
            <img src="assets/images/icons/logo.png" alt="logo">
        </span>

        <div class="group">
            <div class="navItem">
                <span role='link' tabindex='0' onclick='openPage("search.php")' class="navItemLink">
                    Search
                    <img src="assets/images/icons/search.png" alt="Search" class="icon">
                </span>
            </div>
        </div>

        <div class="group">
            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('browse.php')" class="navItemLink">Browse</span>
            </div>
            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('yourMusic.php')" class="navItemLink">Your Music</span>
            </div>
            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('settings.php')" class="navItemLink"><?PHP echo $userLoggedIn->getFirstAndLastName(); ?></span>
            </div>
            <div class="navItem admin borderTop">
                <span role="link" tabindex="0" onclick="openPage('adminDashboard.php')" class="navItemLink">Dashboard</span>
            </div>
            <div class="navItem admin">
                <span role="link" tabindex="0" onclick="openPage('adminArtists.php')" class="navItemLink">Artists</span>
            </div>
            <div class="navItem admin">
                <span role="link" tabindex="0" onclick="openPage('adminAlbums.php')" class="navItemLink">Albums</span>
            </div>
            <div class="navItem admin">
                <span role="link" tabindex="0" onclick="openPage('adminSongs.php')" class="navItemLink">Songs</span>
            </div>
        </div>
    </nav>
</div>

<script>
    if(adminCheck == 1) {
        $(".admin").css("display", "block");
    }
</script>