<?php

function DeleteLec($uuid) {
    require_once "functions.php";
    ConnectDB();

    $sql1 = "SELECT name FROM TeacherDigitalAgency.ProfPic WHERE LecturerUUID = " . $uuid . ";";

    if ($con->query($sql1)) {
    $file_name = mysqli_fetch_assoc($con->query($sql1));
    }

    unlink("../database/images/" . $file_name["name"]);

    $sql4 = "DELETE FROM TeacherDigitalAgency.lecturer WHERE UUID = " . $uuid . ";";
    $sql3 = "DELETE FROM TeacherDigitalAgency.lecturerTag WHERE LecturerUUID = " . $uuid . ";";
    $sql2 = "DELETE FROM TeacherDigitalAgency.ProfPic WHERE LecturerUUID = " . $uuid . ";";

    $con->query($sql2);
    $con->query($sql3);
    $con->query($sql4);

    $con->close();

    header("Location: index.php?page=admin");
}
?>