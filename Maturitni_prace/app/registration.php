<?php
if (isset($_POST["email"]) && $_POST["password1"] == $_POST["password2"]) {

    Registration($_POST);

    
} elseif (isset($_POST["email"]) && $_POST["password1"] != $_POST["password2"]) {
    echo "Nezopakovali jste heslo správně";
}
?>

<form method="POST"><!-- action="neco.php", method="GET" -->
    <input type="hidden" name="action" value="submited"/>
    <!-- id -- nutne mit sekvenci -->

    <label for="email">Email:</label>
    <input class="flex-container" id="email" type="email" name="email" required />
    <br/>

    <label for="password1">Heslo:</label>
    <input class="flex-container" id="password1" type="password" name="password1" required />
    <br/>

    <label for="password2">Heslo znovu:</label>
    <input class="flex-container" id="password2" type="password" name="password2" required />
    <br/>

    <input class="button" type="submit" value="Zaregistrovat">
</form>
