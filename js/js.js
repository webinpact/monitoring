function loginFormSubmit() {

    document.forms["login"].submit();

}


function enter_pressed(evn) {
    if (window.event && window.event.keyCode == 13) {
        return true;
    } else if (evn && evn.keyCode == 13) {
        return true;
    }
}