<?php
include_once('./security_inc.php'); // Import the security functions
include_once('./database_inc.php'); // Get the database functions

base64test();
exit();
/* ================= Handle the input form ==============================*/

// Insecure formhandling
//if(!empty($_POST)){
//    var_dump($_POST);
//    $sEmail = $_POST['sEmail'];
//    $sPassword = $_POST['sPassword'];
//}

// Secure formhandling
if (!filter_input(INPUT_POST, "sEmail")) {
    echo ("Het formulier is leeg");
} else {
    $sEmail       = input_check('sEmail', 'email');
    $sPassword    = input_check('sPassword', 'wachtwoord');
}

base64test();
/* ======================= Verifiication of the acces ================ */
//Set no access boolen
$booAccess = false;

//The verificatiion procces


//fetch all useraccounts from the database
$strSQL = "SELECT * FROM 'tbl_users' ;";
$arrAllUsers = PdoSqlReturnArray($strSQL);
//Loop through each record
foreach ($arrAllUsers as $arrUser) {

    //Decrypt each record
    //Fetch the decryption record of the user
    $strSQL = "SELECT * FROM `tbl_encryptiondata` WHERE `intFK_intUserRecordID` = " . $arrUser["tbl_users"] . ";";
    //Decrypt the user values
    $arrDecryptionData = array();
    $arrDecryptionData['cyphertext']    = $arrUser['encEmailAddress'];
    $arrDecryptionData['key']           = $arrEncryptionData['encEmailKey'];
    $arrDecryptionData['nonce']         = $arrEncryptionData['encEmailNonce'];
    //      $strDecryptedEmail                  = decrypt($arrDecryptionData) == $sEmail;
    //Verify the username with the form username
    echo ($strDecryptedEmail);
    //Verify the hashed password with the form password
    //Set Acces to true
    //End foreach
}



//verification correct
if ($booAcces) {
    header('location:mainsite.php');
} else {
    echo ("Verkeerd gebruikersnaam en/of wachtwoord");
}
/*================ Show the input form ===================================*/

echo ("
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
