<?PHP 
    include("includes/includedFiles.php");

    if(isset($_GET['term'])) {
        $term = urldecode($_GET['term']);
    } else {
        $term = "";
    }

    function getInputValue($name) {
		if(isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}
?>

<h1 class="pageHeadingBig">Users Dashboard</h1>

<div class="searchContainer">

    <h4>Search for a user via username</h4>
    <input type="text" class="searchInput" value="<?PHP echo $term; ?>" placeholder="Enter here..." onfocus="this.selectionStart = this.selectionEnd = this.value.length;">
    <!-- onfocus="this.selectionStart = this.selectionEnd = this.value.length;" is a workaround to make the focus move to the end of the input field -->

</div>

<div class="artistsContainer borderBottom tracklistContainer">
    <h2>Results</h2>

    <?PHP

        $usersQuery = mysqli_query($con, "SELECT * FROM users WHERE lower(username) LIKE lower('$term%')");

        if(mysqli_num_rows($usersQuery) == 0) {
            echo "<span class='noResults showError'> No users found matching " . $term . "</span>";
        }

        echo "<div class='tableContainer'>
            <table class='tableBody'>
                <tr>
                    <th class='tableHeading'>ID</th>
                    <th class='tableHeading'>Username</th>
                    <th class='tableHeading'>First Name</th>
                    <th class='tableHeading'>Last Name</th>
                    <th class='tableHeading'>Email</th>
                    <th class='tableHeading'>Password (MD5)</th>
                    <th class='tableHeading'>Date Joined</th>
                    <th class='tableHeading'>Profile Pic Directory</th>
                    <th class='tableHeading'>Admin</th>
                    <th class='tableHeading'>Delete</th>
        ";

        while($row = mysqli_fetch_array($usersQuery)) {
            $userId = $row['id'];
            $adminBoolean;
            if($row['admin'] == 1) {
                $adminBoolean = "Yes";
            } else {
                $adminBoolean = "No";
            }
            echo "</tr>
                    <tr>
                    <td class='tableRows'> " . $userId . "</td>
                    <td class='tableRows'> " . $row['username'] . "</td>
                    <td class='tableRows'> " . $row['firstName'] . "</td>
                    <td class='tableRows'> " . $row['lastName'] . "</td>
                    <td class='tableRows'> " . $row['email'] . "</td>
                    <td class='tableRows'> " . $row['password'] . "</td>
                    <td class='tableRows'> " . $row['date'] . "</td>
                    <td class='tableRows'> " . $row['profilePic'] . "</td>
                    <td class='tableRows'> " . $adminBoolean . "</td>
                    <td class='tableRows'><button onclick='deleteUser(" . $userId . ", val)' class='button button-admin'>Delete</button></td>
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
	    	<label for="idUser">ID</label>
	    	<input id="idUser" name="idUser" type="text" placeholder="e.g. 1" value="<?php getInputValue('username') ?>" required>
	    </p>
        <p>
	    	<label for="username">Username</label>
	    	<input id="username" name="username" type="text" placeholder="e.g. jonSnow" value="<?php getInputValue('username') ?>" required>
	    </p>

	    <p>
	    	<label for="firstName">First Name</label>
	    	<input id="firstName" name="firstName" type="text" placeholder="e.g. Jon" value="<?php getInputValue('firstName') ?>" required>
	    </p>

	    <p>
	    	<label for="lastName">Last Name</label>
	    	<input id="lastName" name="lastName" type="text" placeholder="e.g. Snow" value="<?php getInputValue('lastName') ?>" required>
	    </p>

	    <p>
	    	<label for="email">Email</label>
	    	<input id="email" name="email" type="email" placeholder="e.g. jonSnow@gmail.com" value="<?php getInputValue('email') ?>" required>
        </p>
    
	    <p>
	    	<label for="password">Password</label>
	    	<input id="password" name="password" type="Password" placeholder="Your password" required>
	    </p>

        <p>
            <label for="adminSelect">Admin</label>
            <select id="adminSelect" name="adminSelect">
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select> 
        </p>

        <button type="submit" onclick="updateUsers('idUser', 'username', 'firstName', 'lastName', 'email', 'password', 'adminSelect')">Add/Update</button>
        
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
                openPage("adminUsers.php?term=" + val);
            }, 1000);
        });
    });
</script>

