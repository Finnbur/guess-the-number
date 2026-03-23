<?Php
function reload($location = null, $statusCode = 302, $exitAfter = true) {
    if($location === null) {
        $location = $_SERVER['PHP_SELF'];
    }

    if(strpos($location, '?') === 0) {
        $location = $_SERVER['PHP_SELF'] . $location;
    }

    header("Location: $location", true, $statusCode);

    if($exitAfter) {
        exit();
    }
}

function respond($message, $type = 'info') {
    $_SESSION['response'] = ['message' => $message, 'type' => $type];
}

function dump($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}