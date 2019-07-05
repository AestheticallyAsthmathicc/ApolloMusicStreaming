<?PHP
    include("../../config.php");

    if(!isset($_POST['userId']) || !isset($_POST['username']) || !isset($_POST['firstName']) || !isset($_POST['lastName']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['adminSelect'])) {
        echo "Error: Could not set one of the fields!";
        exit();
    }


    if(isset($_POST['email']) && $_POST['email'] != "") {

        $id = $_POST['userId'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $password = $_POST['password'];
        $password = md5($password);
        $adminSelect = $_POST['adminSelect'];
        $profilePic = "assets/images/profile-pics/default.png";
        $date = date("Y-m-d");
        
        if(!is_numeric($id)) {
            echo "Please entered a valid ID!";
            exit();
        }


        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Email is invalid!";
            exit();
        }

        $idQueryCheck = mysqli_query($con, "SELECT id FROM users WHERE id = '$id'");

        $usernameDuplicationCheck = mysqli_query($con, "SELECT username FROM users WHERE username = '$username'");
        
        if(mysqli_num_rows($usernameDuplicationCheck) > 1) {
            echo "Username already exists!";
            exit();
        }

        if(mysqli_num_rows($idQueryCheck) == 1) {
            $updateUserQuery = mysqli_query($con, "UPDATE users SET username = '$username', firstName = '$firstName', lastName = '$lastName', email = '$email', password = '$password', admin = '$adminSelect' WHERE id = '$id'");
        } else if(mysqli_num_rows($idQueryCheck) == 0) {
            $addUserQuery = mysqli_query($con, "INSERT INTO users (`id`, `username`, `firstName`, `lastName`, `email`, `password`, `date`, `profilePic`, `admin`) VALUES ('$id', '$username', '$firstName', '$lastName', '$email', '$password', '$date', '$profilePic', '$adminSelect')");
        } else {
            echo "Duplicate IDs!";
        }

    } else {
        echo "You must fill all the fields!";
    }
?>