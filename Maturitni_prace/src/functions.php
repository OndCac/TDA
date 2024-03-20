<?php
function ConnectDB() {
    $host="localhost";
    $port=3306;
    $socket="";
    $user="root";
    $password="root"; // nutne spravne heslo
    $dbname="TeacherDigitalAgency";

    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
        or die ('Could not connect to the database server' . mysqli_connect_error());

    return $con;
}


function CreateCookiesJS() {
    echo "
    // Function to create the cookie 
    <script>
    function createCookie(name, value, days) {
        let expires;
    
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = '; expires=' + date.toGMTString();
        }
        else {
            expires = '';
        }
    
        document.cookie = name + '=' +
            value + ';' + expires + '; path=/';
    }</script>";
}

function Navbar($logged_in, $role) {
    echo '<li><a href="index.php?page=home_page">Domovská stránka</a></li>';
    if ($logged_in) {
        if ($role == "admin") {
            echo "<li><a href='index.php?page=admin'>Administrace</a></li>";
        }

        echo "<li><a href='index.php?page=lec_list'>Lektoři</a></li>"
        . "<li class='logout-button'><a href='index.php?page=logout'>Odhlásit se</a></li>";
    } else {
        echo '<li><a href="index.php?page=registration">Registrace</a></li>' 
        . '<li><a href="index.php?page=login">Přihlásit se</a></li>';
    }
}

function PageContent($page) {
    if (!isset($page))
        $page = 'home_page';

    if (preg_match('/^[a-z0-9_]+$/', $page)) {
        $vlozeno = include('../app/' . $page . '.php');
        if (!$vlozeno)
            echo('Podstránka nenalezena');
        return $vlozeno;
    } else
        echo('Neplatný parametr.');
}

function Registration($User) {
    $con = ConnectDB();

    $sql1 = "SELECT email FROM user WHERE email = '".$User['email']."'";
    $result = mysqli_fetch_assoc($con->query($sql1));

    // vykonani insertu $result["email"] == $email
    if(!empty($result)) {
        echo "Účet s tímto emailem již existuje.";
    } else {
        $hash = hash('sha256', $User['password1']);
        $sql2 = "INSERT INTO User(Email, Password, role) 
                    VALUES('".$User['email']."', '$hash', 'host')";

        if(mysqli_query($con, $sql2)) {
            $_SESSION["logged_in"] = true;
            $_SESSION["role"] = "host";
            header("Location: index.php?page=home_page");
        } else {
            echo "error:".mysqli_error($con).BR;
        }
    }
    $con->close();
}

function AddLec($LecData) {
    $con = ConnectDB();

    $sql = "INSERT INTO Lecturer (TitleBefore, FirstName, MiddleName, LastName, TitleAfter, Location, Claim, Bio, PricePerHour, TelephoneNumber, Email) VALUES (
        '" . $LecData['TitleBefore'] . "', 
        '" . $LecData['FirstName'] . "', 
        '" . $LecData['MiddleName'] . "', 
        '" . $LecData['LastName'] . "', 
        '" . $LecData['TitleAfter'] . "', 
        '" . $LecData['Location'] . "', 
        '" . $LecData['Claim'] . "', 
        '" . $LecData['Bio'] . "', 
        " . $LecData['PricePerHour'] . ",
        '" . $LecData['TelephoneNumber'] . "',
        '" . $LecData['Email'] . "')";

    if ($con->query($sql)) {
        $_SESSION['LecEmail'] = $LecData['Email'];

        header("Location: index.php?page=add_tag");
    } else {
        echo "error:".mysqli_error($con);
    }

    $_SESSION['Email'] = $LecData['Email'];

    $con->close();

    header("Location: index.php?page=add_tag");
}

?>