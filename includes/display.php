<?php
/**
 * Manage display  of the web interface (html mainly)
 * Date: 08/05/14
 * Time: 19:07
 */

function displayLoginForm() {

    return '
    <div class="loginForm">
        <div class="loginTitle">Veuillez vous identifier :</div>
        <br />
        <form name="login" method="post" action="index.php">
        <table>
        <tr><td>Login :</td><td><input type="text" name="login"></td></tr>
        <tr><td>Mot de passe :</td><td><input type="text" name="password"></td></tr>
        <tr><td colspan="2">'.getButton("Login","#","onclick='login();'").'</td></tr>
        </table>
        </form>
        <br /><br />
    </div>';
}

function getButton ($text, $link="", $js="") {

    return '
    <a href="'.$link.'" '.$js.' class="css_btn_class">'.$text.'</a>';


}