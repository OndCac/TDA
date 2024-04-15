<?php
    // def. odradkovani v HTML
    define("BR", "<br/>\n");

    session_start();

    if (!($_SESSION["role"] == "admin")) {
        header("Location: index.php");
    }
?>

<?php
$con = ConnectDB();

// prepair profile data of each lecturer
$sql = "SELECT * FROM TeacherDigitalAgency.lecturer";
$result = $con->query($sql);

while($row = mysqli_fetch_assoc($result)) {
    $profileData[] = $row;
}

// load all tags
$sql1 = "SELECT * FROM TeacherDigitalAgency.Tag";
$result = $con->query($sql1);

while($row = mysqli_fetch_assoc($result)) {
    $Tag[] = $row;
}

if (isset($_COOKIE["delete_uuid"])) {
    DeleteLec($_COOKIE["delete_uuid"]);
}

// end db session
$con->close();

// allow usage of jquery
$check = true;
?>

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
        createCookie("delete_uuid", id, 60)
        // window.location.href = "index.php?page=delete_lec";
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

<button class="button" type="button" onclick="addLec()">Přidat lektora</button>
<br>
<button class="button" type="button" onclick="createTag()">Nový Tag</button>

</br> 
</br>
</br>

<table id='lecTable' class='display'>
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
    <tbody>
        <?php
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
        ?>
    </tbody>
</table>

</br>
</br>

<table id='tagTable' class='display' styles='margin-top:15px'>
    <thead>
        <tr>
            <th>Tag</th>
            <th>Smazat Tag</th>
        </tr>
    </thead>
    <tbody>
        <?php

            for ($i=0; $i < count($Tag); $i++) { 
                echo '<tr>
                        <td>' . $Tag[$i]["Name"] . '</td>
                        <td><button onclick="deleteTag('.$Tag[$i]["UUID"].')" type="button">Smazat</button></td>
                        </tr>';
            }
        ?>
    </tbody>
</table>