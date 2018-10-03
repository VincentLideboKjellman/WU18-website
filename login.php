<?php
// TODO: create a session to keep login variables.

try {
	/**************************************
	* Open database connections           *
	**************************************/

	// Create (connect to) SQLite database in file
	$database = new PDO('sqlite:testshop.db');
	// Set errormode to exceptions
	$database->setAttribute(PDO::ATTR_ERRMODE, 
							PDO::ERRMODE_EXCEPTION);
	

	$query = "SELECT * FROM users;";    
	$stmt = $database->query($query); // Run SQL query

	$users = $stmt->fetchAll();

}
catch(PDOException $e) {
	// Print PDOException message
	echo $e->getmessage();
}

/**************************************
* Page specific data                  *
**************************************/
$page_title = 'Register';

require('templates/header.php');

?>

<main>
	<!-- Login form -->
    <h2>Login</h2>
    <form action="?" method="post">
        <label for="email">Email</label><br>
        <input type="text" name="email" id="email"><br><br>
        <label for="password">Password</label><br>
        <input type="password" name="password" id="password"><br><br>
        <input type="hidden" name="action" value="login">
        <input type="submit" name="submit" value="Send">
    </form>
    
	<!-- This is only for printing the users stored in the db. -->
    <table>
        <thead>
            <tr>
                <td>id</td>
                <td>firstname</td>
                <td>lastname</td>
                <td>email</td>
                <td>password</td>
            </tr>
        </thead>
    
        <tbody>
        <?php foreach($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['firstname']; ?></td>
                <td><?php echo $user['lastname']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['password']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
	</table>
</main>
	
<?php
require('templates/footer.php');
?>