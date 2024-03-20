<?php
    // def. odradkovani v HTML
    define("BR", "<br/>\n");

    session_start();

    if (!($_SESSION["role"] == "admin")) {
        header("Location: index.php");
    }
?>

<?php
$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="root"; // nutne spravne heslo
$dbname="TeacherDigitalAgency";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());

// tabulka uzivatele z DB jako JSON
$sql = "SELECT * FROM TeacherDigitalAgency.lecturer";
$result = $con->query($sql);

//$result = mysqli_fetch_assoc($result);
//$profileData = mysqli_fetch_assoc($result);

while($row = mysqli_fetch_assoc($result)) {
    // skladame objekt pro zaznam z DB
    $profileData[] = $row;
}


if (isset($_POST["uuid"])) {
    $sql = "DELETE FROM TeacherDigitalAgency.lecturer WHERE UUID = " . $_POST['uuid'] . ";";
    header("Refresh:0");
}

// Fetch and convert to JSON
//$profileData = json_decode($result);

$check = true;
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
    <title>TdA: Administrace</title>
    <script>
        $(document).ready( function () {
            $('#lecTable').DataTable();
            $('#tagTable').DataTable();
            $('article').after("<footer>Vytvořil Ondřej Cacek 2024 </footer>");
        } );

        // Function to create the cookie 
        function createCookie(name, value, minutes) {
            let expires;
        
            if (minutes) {
                let date = new Date();
                date.setTime(date.getTime() + (minutes * 60 * 1000));
                expires = "; expires=" + date.toGMTString();
            }
            else {
                expires = "";
            }
        
            document.cookie = name + "=" +
                value + ";" + expires + "; path=/";
        }

        function showLec(id) {
            createCookie("uuid", id, 60)
            window.location.href = "lecturer.php";
        }

        function deleteLec(id) {
            createCookie("uuid", id, 60)
            window.location.href = "delete_lec.php";
        }

        function editLec(id) {
            createCookie("uuid", id, 60)
            window.location.href = "edit_lec.php";
        }

        function addLec() {
            window.location.href = "add_lec.php";
        }

        function deleteTag(id) {
            createCookie("tag_uuid", id, 60)
            window.location.href = "delete_tag.php";
        }

        function createTag() {
            window.location.href = "create_tag.php";
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

        <button class="button" type="button" onclick="addLec()">Přidat lektora</button>
        <br>
        <button class="button" type="button" onclick="createTag()">Nový Tag</button>
        
        <?php
            echo "</br></br></br><table id='lecTable' class='display'>
                    <thead>
                        <tr>
                            <th>Jméno</th>
                            <th>Poloha</th>
                            <th>Cena za hodinu (CZK)</th>
                            <th>Ukázat</th>
                            <th>Změnit</th>
                            <th>Smazat</th>
                        </tr>
                    </thead>
                    <tbody>";
            for ($i=0; $i < count($profileData); $i++) { 
                echo '<tr>
                        <td>' . $profileData[$i]["TitleBefore"] . ' ' . $profileData[$i]["FirstName"] . ' ' . $profileData[$i]["MiddleName"] . ' ' . $profileData[$i]["LastName"] . ' ' . $profileData[$i]["TitleAfter"] . '</td>
                        <td>' . $profileData[$i]["Location"] . '</td>
                        <td>' . $profileData[$i]["PricePerHour"] . '</td>
                        <td><button onclick="showLec('.$profileData[$i]["UUID"].')" type="button">Show</button></td>
                        <td><button onclick="editLec('.$profileData[$i]["UUID"].')" type="button">Edit</button></td>
                        <td><button onclick="deleteLec('.$profileData[$i]["UUID"].')" type="button">Delete</button></td>
                        </tr>';
            }
            echo "</tbody></table></br></br>";

            $sql1 = "SELECT * FROM TeacherDigitalAgency.Tag";
            $result = $con->query($sql1);

            while($row = mysqli_fetch_assoc($result)) {
                // skladame objekt pro zaznam z DB
                $Tag[] = $row;
            }

            echo "<table id='tagTable' class='display' styles='margin-top:15px'>
                    <thead>
                        <tr>
                            <th>Tag</th>
                            <th>Smazat Tag</th>
                        </tr>
                    </thead>
                    <tbody>";
            for ($i=0; $i < count($Tag); $i++) { 
                echo '<tr>
                        <td>' . $Tag[$i]["Name"] . '</td>
                        <td><button onclick="deleteTag('.$Tag[$i]["UUID"].')" type="button">Smazat</button></td>
                        </tr>';
            }
            echo "</tbody></table>"; 
        ?>
    </article>
</body>
</html>