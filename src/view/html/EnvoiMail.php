<?php
if (!empty($_POST['email'])) {
    $email = $_POST['email'];
    $FROMEMAIL = '"SQLuedo" <adm.sqluedo@gmail.com>';
    $TOEMAIL = $email;
    $SUBJECT = "Réinitialisation mot de passe";
    $PLAINTEXT = "Votre code pour reinitialiser votre mot de passe : ";
    $FICTIONALSERVER = "@londres.uca.local";

    $headers = "From: " . $FROMEMAIL . "\n";
    $headers .= "Reply-To: " . $FROMEMAIL . "\n";
    $headers .= "Return-path: " . $FROMEMAIL . "\n";
    $headers .= "X-Mailer: Your Website\n";
    $headers .= "MIME-Version: 1.0\n";

    $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";

    $message = quoted_printable_encode($PLAINTEXT);

    $subject = "=?UTF-8?B?" . base64_encode($SUBJECT) . "?=";

    mail($TOEMAIL, $subject, quoted_printable_decode($message), $headers, "-f" . $FROMEMAIL);
}
