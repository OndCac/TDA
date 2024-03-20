<?php
    if (!($_SESSION["role"] == "admin")) {
        header("Location: index.php?page=home_page");
    }
    
    if (isset($_POST["FirstName"])) {
        AddLec($_POST);
    }
?>

<script>
    function back() {
        window.location.href = "admin.php";
    }
</script>

<button class="button" type="button" onclick="back()">Zpět na seznam lektorů</button><br><br><br>

<form method="POST" class="flex-container">
    <input type="hidden" name="action" value="submited"/>
    <!-- id -- nutne mit sekvenci -->

    <label for="TitleBefore">Titul před jménem:</label>
    <input id="TitleBefore" name="TitleBefore" />
    <br/>

    <label for="FirstName">*Křestní jméno:</label>
    <input id="FirstName" name="FirstName" required />
    <br/>

    <label for="MiddleName">Další jméno:</label>
    <input id="MiddleName" name="MiddleName" />
    <br/>

    <label for="LastName">*Příjmení:</label>
    <input id="LastName" name="LastName" required />
    <br/>

    <label for="TitleAfter">Titul za jménem:</label>
    <input id="TitleAfter" name="TitleAfter" />
    <br/>

    <label for="Location">*Poloha:</label>
    <input id="Location" name="Location" required />
    <br/>

    <label for="Claim">*Claim:</label>
    <textarea id="Claim" name="Claim" rows="4" cols="50" required>
    </textarea>
    <br/>

    <label for="Bio">*Bio:</label>
    <textarea id="Bio" name="Bio" rows="4" cols="50" required>
    </textarea>
    <br/>

    <label for="PricePerHour">*Cena za hodinu (CZK):</label>
    <input id="PricePerHour" name="PricePerHour" type="number" required />
    <br/>

    <label for="Email">*Email:</label>
    <input id="Email" name="Email" required />
    <br/>

    <label for="TelephoneNumber">Telefonní číslo:</label>
    <input id="TelephoneNumber" name="TelephoneNumber" />
    <br/>

    <div>(Povinné údaje označeny *)</div>
    <br/>
    
    <input class="button" type="submit" value="Vytvořit">
    
</form>