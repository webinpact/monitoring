<?php
/**
 * Manage display  of the web interface (html mainly)
 * Date: 08/05/14
 * Time: 19:07
 */

function getLoginForm() {

    return '
    <div class="loginForm">
        <div class="loginTitle">Please log in :</div>
        <br />
        <form name="login" method="post" action="index.php">
        <table>
        <tr><td>Login :</td><td><input type="text" name="login"></td></tr>
        <tr><td>Password :</td><td><input type="text" name="password"></td></tr>
        <tr><td colspan="2">'.getButton("Login","#","onclick='loginFormSubmit();'").'</td></tr>
        </table>
        <input type="hidden" name="do" value="login_valid">
        </form>
        <br /><br />
    </div>';
}

function getButton ($text, $link="", $js="") {

    return '
    <a href="'.$link.'" '.$js.' class="css_btn_class">'.$text.'</a>';


}

function getDashBoard() {

    return '
    <div class="content">
        <div class="mainMenu">
            <ul>
                <li><a href="index.php?do=graphs">Graphs</a></li>
                <li><a href="index.php?do=hosts">Hosts</a></li>
                <li><a href="index.php?do=alerts">Alerts</a></li>
                <li><a href="index.php?do=settings">Settings</a></li>
            </ul>
        </div>
        <div class="sideMenu">
            <h4>Hosts</h4>
            <a href="">Host 1</a><br />
            <a href="">Host 1</a><br />
        </div>
        <div class="mainContent">
            <h4>Graphs</h4>
            bla bla
        </div>
    </div>';

}