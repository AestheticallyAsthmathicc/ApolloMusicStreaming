<?PHP
    // session start in logout is used to let out dumb logout.php page
    // know that we are going to use session related shit in our page
    // like in this case we are going to logout by session_destroy()
    session_start();
    session_destroy();

?>