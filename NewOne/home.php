<?php
    session_start();
    include("php/config.php");

    // Check if 'Id' key is set in the session
    if(!isset($_SESSION['Id'])){
        header("Location: index.php");
        exit(); // Exit to stop further execution
    }

    $id = $_SESSION['Id'];

    // Retrieve user data from the database
    $query = mysqli_prepare($con, "SELECT * FROM users WHERE Id=?");
    mysqli_stmt_bind_param($query, "i", $id);
    mysqli_stmt_execute($query);
    $result = mysqli_stmt_get_result($query);

    // Check if query executed successfully
    if($result) {
        // Check if any rows were returned
        if(mysqli_num_rows($result) > 0) {
            // Fetch a single row
            $row = mysqli_fetch_assoc($result);

            // Extract data from the result
            $rec_Uname = htmlspecialchars($row['Username']);
            $rec_Email = htmlspecialchars($row['Email']);
            $rec_Age = htmlspecialchars($row['Age']);
            $rec_id = htmlspecialchars($row['Id']);

            echo "<a href='edit.php?Id=$rec_id'>Change profile</a>";
        } else {
            echo "User not found.";
        }
    } else {
        // Error handling for query execution failure
        echo "Error executing query: " . mysqli_error($con);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">Logo</a></p>
        </div>
        <div class="right-links">
            <?php
                // Check if user data is set
                if(isset($rec_id)) {
                    echo "<a href='edit.php?Id=$rec_id'>Change profile</a>";
                }
            ?>
            <a href="logout.php"><button class="btn">Log Out</button></a>
        </div>
    </div>
    <main>
        <div class="main-box top">
            <div class="top">
                <div class="box">
                    <p>Hello <b><?php echo $rec_Uname; ?></b>, Welcome</p>
                </div>
                <div class="box">
                    <p>Your Email is <b><?php echo $rec_Email; ?></b>, Welcome</p>
                </div>
                <div class="bottom">
                    <div class="box">
                        <p>And You are <b><?php echo $rec_Age; ?> years old</b>.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
