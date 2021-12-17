<?php
include_once('./security_inc.php'); // Import the security functions

/* ================= Handle the input form ==============================*/

// Secure formhandling
if (!filter_input(INPUT_POST, "sEmail")) {
    echo("Het formulier is leeg");
} else {
    $sEmail = checkpost('sEmail');
    $sPassword = checkpost('sPassword');
    $booAcces = false;
    //Fetch all records drom database
    //Loop thru each record
    //Decrypt the record values
    //Verify if the values are the same as the form values
    //If the values are the same,acces granted else no acces
    if($booAcces){
        header('location:mainsite.php');
    }else{
        echo("Verkeerde email/wachtwoord ingevoerd");
    } //End if access
} //End if filter input

// Insecure formhandling
//if(!empty($_POST)){
//    var_dump($_POST);
//    $sEmail = $_POST['sEmail'];
//    $sPassword = $_POST['sPassword'];
//}


/*================ Show the input form ===================================*/

echo("
<!doctype html>
<html>
    <head>
        <title>Secure input</title>
    </head>
    <body>
        <hr/>Menu<hr/>
        <ul>
            <li><a href='add_user.php'>Registreren</a></li>
        <ul>
        <hr/>
        <h3>Aanmelden</h3>
        <hr>
        <form method=post>
        E-mail: <input type='text' name='sEmail'><br/>
        Wachtwoord: <input type='password' name='sPassword'><br/>
        <hr>
        <input type='submit' value='aanmelden'><br/>
        </form>
    </body>
</html>


");

// <script src='d:\hackscript.js'> </script>Mijn hack