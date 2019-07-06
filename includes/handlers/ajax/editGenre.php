<?PHP
    include("../../config.php");

    if(!isset($_POST['genreId']) || !isset($_POST['name'])) {
        echo "Error: Could not set one of the fields!";
        exit();
    }

    $id = $_POST['genreId'];
    $name = $_POST['name'];

    if(!is_numeric($id)) {
        echo "<p class='errorsAdmin'>Please entered a valid ID!</p>";
        exit();
     }

    $idQueryCheck = mysqli_query($con, "SELECT id FROM genres WHERE id = '$id'");

    $genreDuplicationCheck = mysqli_query($con, "SELECT name FROM genres WHERE name = '$name'");
        
    if(mysqli_num_rows($genreDuplicationCheck) > 1) {
        echo "Genre already exists!";
        exit();
    }

    if(mysqli_num_rows($idQueryCheck) == 1) {
        $updateUserQuery = mysqli_query($con, "UPDATE genres SET name = '$name' WHERE id = '$id'");
    } else if(mysqli_num_rows($idQueryCheck) == 0) {
        $addUserQuery = mysqli_query($con, "INSERT INTO genres (`id`, `name`) VALUES ('$id', '$name')");
    } else {
        echo "Duplicate IDs!";
    }
?>