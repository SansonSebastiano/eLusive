<?php
    const ADMIN_ROLE = "admin";
    const USER_ROLE = "user";
    const WRITER_ROLE = "writer";

    // import the connection script
    require_once('admin_conn.php');
    // import input cleaner script
    include('input_cleaner.php');

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['submit'])) {
            if (array_key_exists('username', $_POST) && array_key_exists('password', $_POST)) {
                // get the data from the form:
                // username
                $username = clearInput($_POST['username']);
                if (empty($username)) {
                    echo "<li>Username is required<li>";
                }
                // password
                $password = clearInput($_POST['password']);
                if (empty($password)) {
                    echo "<li>Password is required<li>";
                }
                // create a query
                $query = "SELECT * FROM `utente` WHERE `nome` = '$username' AND `password` = '$password'";
                // execute the query
                $result = $mysqli->query($query);
                // check if the query was executed successfully and if the result is not empty
                if ($result->num_rows == 0) {
                    echo '<br>';
                    echo '<br>';
                    echo "Error: " . 'the query to MySQL eLusive was not executed successfully or the result is empty.';
                    exit();
                } else {
                    echo '<br>';
                    echo '<br>';
                    echo 'Success: A proper query to MySQL eLusive was made.';
                    echo '<br>';
                    echo 'Number of rows: '.$result->num_rows;
                    echo '<br>';
                    echo '<br>';

                    // iterate over the result set
                    // fetch each row as an associative array
                    while ($row = $result->fetch_assoc()) {
                        if ($row["ruolo"] == ADMIN_ROLE) {
                            $_SESSION["ruolo"] = ADMIN_ROLE;
                            $_SESSION["username"] = $row["nome"];
                            $_SESSION["id"] = $row["id"];

                            echo "USERNAME: " . $_SESSION["username"] . "<br>";
                            echo "PASSWORD: " . $row["password"] . "<br>";
                            echo "EMAIL: " . $row["email"] . "<br>";
                            echo "RUOLO: " . $_SESSION["ruolo"] . "<br>";
                            echo "-----------------<br>";
                            echo "GRANT: " . $db_user . "<br>"; // TODO: fix this: it should be the role of the user

                            // header("Location: admin.php");
                        } elseif ($row["ruolo"] == WRITER_ROLE) {
                            $_SESSION["ruolo"] = WRITER_ROLE;
                            $_SESSION["username"] = $row["nome"];
                            $_SESSION["id"] = $row["id"];

                            echo "USERNAME: " . $_SESSION["username"] . "<br>";
                            echo "PASSWORD: " . $row["password"] . "<br>";
                            echo "EMAIL: " . $row["email"] . "<br>";
                            echo "RUOLO: " . $row["ruolo"] . "<br>";
                            echo "-----------------<br>";
                            echo "GRANT: " . $db_user . "<br>"; // TODO: fix this: it should be the role of the user

                            // header("Location: writer.php");
                        } elseif ($row["ruolo"] == USER_ROLE) {
                            $_SESSION["username"] = USER_ROLE;
                            $_SESSION["username"] = $row["nome"];
                            $_SESSION["id"] = $row["id"];

                            echo "USERNAME: " . $_SESSION["username"] . "<br>";
                            echo "PASSWORD: " . $row["password"] . "<br>";
                            echo "EMAIL: " . $row["email"] . "<br>";
                            echo "RUOLO: " . $_SESSION["username"] . "<br>";
                            echo "-----------------<br>";
                            echo "GRANT: " . $db_user . "<br>"; // TODO: fix this: it should be the role of the user

                            // header("Location: user.php");
                        } else {
                            echo "Error: no role found for the user.";
                            // TODO: redirect to the login page

                            // header("Location: login.php");
                        }
                    }

                    // free the result set
                    $result->free();
                    // close the connection
                    $mysqli->close();
                }
            }
        }
    }
?>