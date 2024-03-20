<?php
    require "../src/constants.php";
    require "../src/functions.php";
    require "../src/data_tables.php";

    session_start();

    if (empty($_SESSION["logged_in"])) {
        $logged_in = false;
    } else{
        $logged_in = $_SESSION["logged_in"];
    }

    if (empty($_SESSION["role"])) {
        $role = false;
    } else{
        $role = $_SESSION["role"];
    }
    
    /*$logged_in = LoggedIn($_SESSION["logged_in"]);
    $role = Role($_SESSION["role"]);

    [$logged_in, $role] = UserState($_SESSION["logged_in"], $_SESSION["role"]);*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" type="text/css"/>
    <?php
        if (!isset($check)) {
            $check = false;
        }
        DataTablesHeader($check)
    ?>
    <title>TDA</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <?php 
                    Navbar($logged_in, $role);
                ?>
            </ul>
        </nav>
    </header>
    
    <article>
        <?php
            if (empty($_GET["page"])) {
                $page = null;
            } else {
                $page = $_GET["page"];
            }
            PageContent($page);
        ?>
    </article>

    <footer>
        Vytvořil Ondřej Cacek 2024
    </footer>
</body>
</html>