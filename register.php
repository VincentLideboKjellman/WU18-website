<?php
if(isset($_POST['submit'])){
    try {
    /**************************************
     * Create databases and                *
    * open connections                    *
    **************************************/

    // Create (connect to) SQLite database in file
    $database = new PDO('sqlite:wu18database.db');
    // Set errormode to exceptions
    $database->setAttribute(PDO::ATTR_ERRMODE, 
                            PDO::ERRMODE_EXCEPTION);

    /**************************************
     * Create tables                       *
    **************************************/

    // Create table users
    $database->exec("CREATE TABLE IF NOT EXISTS users (
                    id INTEGER PRIMARY KEY, 
                    firstname TEXT,
                    lastname TEXT,
                    email TEXT,
                    password TEXT)");


    /**************************************
     * Set initial data                    *
    **************************************/

    $user = $_POST; //todo: Currently a make-shift solution. Do this, but in a cleaner way. Maybe edit the variables field at row 69.

    /**************************************
     * Prepare SQL and insert data        *
    **************************************/

    // Prepare INSERT statement to SQLite3 file db
    $insert = "INSERT INTO users (firstname, lastname, email, password) 
                    VALUES (:firstname, :lastname, :email, :password)";
    $stmt = $database->prepare($insert);

    // Bind parameters to statement variables
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);

    // Set values to bound variables
    $firstname = $user['firstname'];
    $lastname = $user['lastname'];
    $email = $user['email'];
    $password = password_hash('sha256', $user['password']); // One-way encrypt through sha256

    // Execute statement
    $stmt->execute();


    /**************************************
    * Close db connections                *
    **************************************/

    // Close file db connection
    $database = null;
    }
    catch(PDOException $e) {
    // Print PDOException message
    echo $e->getmessage();
    }

	// Refresh the page
    header('location: ?');
}
    
/**************************************
* Page specific data                  *
**************************************/
$page_title = 'Register';

require('templates/header.php');

?>

<main>
	<h2>Register</h2>
    <form action="?" method="post">
        <label for="firstname">Firstname</label><br>
        <input type="text" name="firstname" id="firstname" required><br><br>
        <label for="lastname">Lastname</label><br>
        <input type="text" name="lastname" id="lastname" required><br><br>
        <label for="email">Email</label><br>
        <input type="text" name="email" id="email" required><br><br>
        <label for="password">Password</label><br>
        <input type="password" name="password" id="password" required><br><br>
        <input type="hidden" name="action" value="register">
        <input type="submit" name="submit" value="Send">
    </form>
</main>

<?php
require('templates/footer.php');
?>
