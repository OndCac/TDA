<?php
if (!($_SESSION["role"] == "admin")) {
    header("Location: index.php?page=home_page");
}

$con = ConnectDB();
// tabulka uzivatele z DB jako JSON
$sql = "SELECT * FROM TeacherDigitalAgency.lecturer";
$result = $con->query($sql);

while($row = mysqli_fetch_assoc($result)) {
    // skladame objekt pro zaznam z DB
    $profileData[] = $row;
}

$con->close();

$check = true;
?>

<article>
    
    <table id='lecTable' class='display'>
        <thead>
            <tr>
                <th>Jméno</th>
                <th>Poloha</th>
                <th>Cena za hodinu (CZK)</th>
            </tr>
        </thead>
        <tbody>
        <?php
        for ($i=0; $i < count($profileData); $i++) { 
            echo '<tr class="lec-list" id="' . $profileData[$i]["UUID"] . '">
                    <td>' . $profileData[$i]["TitleBefore"] . ' ' . $profileData[$i]["FirstName"] . ' ' . $profileData[$i]["MiddleName"] . ' ' . $profileData[$i]["LastName"] . ' ' . $profileData[$i]["TitleAfter"] . '</td>
                    <td>' . $profileData[$i]["Location"] . '</td>
                    <td>' . $profileData[$i]["PricePerHour"] . '</td>
                    </tr>';
        }
        ?>
        </tbody>
    </table>

    <!-- <div class=lec-list><a href="lecturer.php" onclick="lecturerId(' . $profileData["UUID"] . ')">' . $profileData["FirstName"] . ' ' . $profileData["MiddleName"] . ' ' . $profileData["LastName"] . '</a></div> -->
        
    
    <script>
        $(document).ready( function () {
            $('#lecTable').DataTable();
            $('article').after("<footer>Vytvořil Ondřej Cacek 2024 </footer>");
        } );
            
        $( '#lecTable tbody tr' ).on( 'click', function() {
            createCookie("uuid", this.id, 1)
            window.location.href = "lecturer.php";
        });

        // Function to create the cookie 
        function createCookie(name, value, days) {
            let expires;
        
            if (days) {
                let date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toGMTString();
            }
            else {
                expires = "";
            }
        
            document.cookie = name + "=" +
                value + ";" + expires + "; path=/";
        }
    </script>
</article>
