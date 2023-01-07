<?php
if (!empty($_SESSION['success'])) {
    WSMessage($_SESSION['success'], WS_SUCCESS);
    unset($_SESSION['success']);
}
if (!empty($_SESSION['infor'])) {
    WSMessage($_SESSION['infor'], WS_INFOR, $die ?? false);
    unset($_SESSION['infor']);
}
if (!empty($_SESSION['alert'])) {
    WSMessage($_SESSION['alert'], WS_ALERT, $die ?? false);
    unset($_SESSION['alert']);
}
if (!empty($_SESSION['error'])) {
    WSMessage($_SESSION['error'], WS_ERROR, $die ?? false);
    unset($_SESSION['error']);
}
