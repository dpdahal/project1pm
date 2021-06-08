<?php
/*
 *  ========== configuration =========
 */
require_once "../config/config.php";
require_once "../config/connection.php";
/*
 * ======= Request uri or page uri
 */
$requestUri = isset($_GET['uri']) ? $_GET['uri'] : 'dashboard';
$requestUri = str_replace('.php', '', $requestUri);
$title = "Backend : : " . $requestUri;

$requestUri .= ".php";

if (!isset($_SESSION['is_log_in'])) {
    redirect_to('backend/login');
}


?>

<?php

$pagePath = root_path('/backend/pages/' . $requestUri);

require_once root_path('backend/layouts/header.php');
//require_once root_path('backend/layouts/top-header.php');
//require_once root_path('backend/layouts/aside.php');

if (file_exists($pagePath) && is_file($pagePath)) {
    require_once $pagePath;
} else {
    require_once(root_path('/backend/pages/404.php'));
}

require_once root_path('backend/layouts/footer.php');




