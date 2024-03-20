<?php
session_start();

if (!($_SESSION["role"] == "admin")) {
    header("Location: index.php");
}

// def. odradkovani v HTML
define("BR", "<br/>\n");

$lecturerId = $_COOKIE["uuid"];

$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="root"; // nutne spravne heslo
$dbname="TeacherDigitalAgency";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die ('Could not connect to the database server' . mysqli_connect_error());

$sql = "SELECT * FROM lecturer WHERE UUID = $lecturerId";
$result = $con->query($sql);
$profileData = mysqli_fetch_assoc($result);

if (isset($_POST["FirstName"])) {
    $sql = "UPDATE Lecturer SET
            TitleBefore = '" . $_POST['TitleBefore'] . "', 
            FirstName = '" . $_POST['FirstName'] . "', 
            MiddleName = '" . $_POST['MiddleName'] . "', 
            LastName = '" . $_POST['LastName'] . "', 
            TitleAfter = '" . $_POST['TitleAfter'] . "',
            Location = '" . $_POST['Location'] . "', 
            Claim = '" . ltrim($_POST['Claim']) . "', 
            Bio = '" . ltrim($_POST['Bio']) . "', 
            PricePerHour = " . $_POST['PricePerHour'] . ", 
            TelephoneNumber = '" . $_POST['TelephoneNumber'] . "', 
            Email = '" . $_POST['Email'] . "'
            WHERE UUID = $lecturerId";

    if (!$con->query($sql)) {
        echo "error:".mysqli_error($con).BR;
    } else {
        $con->query($sql);

        echo $_POST['TitleBefore'] . BR
            . $_POST['FirstName'] . BR
            . $_POST['MiddleName'] . BR 
            . $_POST['LastName'] . BR 
            . $_POST['TitleAfter'] . BR 
            . $_POST['Location'] . BR 
            . $_POST['Claim'] . BR 
            . $_POST['Bio'] . BR 
            . $_POST['PricePerHour'] . BR
            . $_POST['Email'] . BR 
            . $_POST['TelephoneNumber'] . BR 
            . "<li><a href='admin.php'>Administration</a></li>";

            $_SESSION['LecEmail'] = $_POST['Email'];
    
            header("Location: edit_tag.php");
    }

    $con->close();

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" type="text/css"/>
    <!--<script src="DataTables/dataTables.jqueryui.min.js"></script>-->
    <script src="jquery/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="DataTables/DataTables-1.13.8/css/jquery.dataTables.min.css" />
    <script src="DataTables/DataTables-1.13.8/js/jquery.dataTables.min.js"></script>
    <title>TdA: Seznam lektorů</title>
    <script>
        function back() {
            window.location.href = "admin.php";
        }
    </script>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Domovská stránka</a></li>
                <li class="aktivni"><a href='admin.php'>Administrace</a></li>
                <li><a href="lec_list.php">Lektoři</a></li>
                <li class='logout-button'><a href='logout.php'>Odhlásit se</a></li>
            </ul>
        </nav>
    </header>
    <article>
        <?php
            echo '<button class="button" type="button" onclick="back()">Zpět na seznam lektorů</button><br><br><br>
                <form method="POST" class="flex-container">
                    <input type="hidden" name="action" value="submited"/>
                    <!-- id -- nutne mit sekvenci -->

                    <label for="TitleBefore">Titul před jménem:</label>
                    <input id="TitleBefore" name="TitleBefore" value="' . $profileData["TitleBefore"] . '" />
                    <br/>

                    <label for="FirstName">Křestní jméno:</label>
                    <input id="FirstName" name="FirstName" value="' . $profileData["FirstName"] . '" required />
                    <br/>

                    <label for="MiddleName">Další jméno:</label>
                    <input id="MiddleName" name="MiddleName" value="' . $profileData["MiddleName"] . '" />
                    <br/>

                    <label for="LastName">Příjmení:</label>
                    <input id="LastName" name="LastName" value="' . $profileData["LastName"] . '" required />
                    <br/>

                    <label for="TitleAfter">Titul za jménem:</label>
                    <input id="TitleAfter" name="TitleAfter" value="' . $profileData["TitleAfter"] . '" />
                    <br/>

                    <label for="Location">Poloha:</label>
                    <input id="Location" name="Location" value="' . $profileData["Location"] . '" required />
                    <br/>

                    <label for="Claim">Claim:</label>
                    <textarea id="Claim" name="Claim" rows="4" cols="50" required>
                    ' . $profileData["Claim"] . '
                    </textarea>
                    <br/>

                    <label for="Bio">Bio:</label>
                    <textarea id="Bio" name="Bio" rows="4" cols="50" required>
                    ' . $profileData["Bio"] . '
                    </textarea>
                    <br/>

                    <label for="PricePerHour">Cena Za Hodinu (CZK):</label>
                    <input id="PricePerHour" name="PricePerHour" type="number" value="' . htmlspecialchars($profileData["PricePerHour"]) . '" required />
                    <br/>

                    <label for="TelephoneNumber">Telefonní číslo:</label>
                    <input id="TelephoneNumber" name="TelephoneNumber" value="' . htmlspecialchars($profileData["TelephoneNumber"]) . '" />
                    <br/>

                    <label for="Email">Email:</label>
                    <input id="Email" name="Email" value="' . $profileData["Email"] . '" required />
                    <br/>

                    <div>(Povinné údaje označeny *)</div>
                    <br/>

                    <input class="button" type="submit" value="Pokračovat">
                    
                    </form>';
        ?>
    </article>

    <footer>
        Vytvořil Ondřej Cacek 2024
    </footer>
</body>
</html>