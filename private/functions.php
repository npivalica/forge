<?php

function url_for($script_path)
{
    // add the leading '/' if not present
    if ($script_path[0] != '/') {
        $script_path = "/" . $script_path;
    }
    return WWW_ROOT . $script_path;
}
function error_404() {
    header($_SERVER["SERVER_PROTOCOL"] . "404 NOT FOUND"); //render your own 404 page that you will render insetad of exit method
    exit();
}
function error_500(){
    header($_SERVER["SERVER_PROTOCOL"] . "500 INTERNAL SERVER ERROR"); 
    exit();
}
function redirect_to($location)//umesto header("Location: " . url_for('staff/subjects/index.php'));
{
    header("Location: " . $location);
    exit;
}
function is_post_request()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request()
{
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

?>
