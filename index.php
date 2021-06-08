<?php
/*
 *  ========== configuration =========
 */
require_once "config/config.php";
/*
 * ======= Request uri or page uri
 */
$requestUri = isset($_GET['uri']) ? $_GET['uri'] : 'home';
$requestUri = str_replace('.php', '', $requestUri);
$requestUri .= ".php";
?>

<?php

$pagePath = root_path('frontend/pages/' . $requestUri);

require_once root_path('frontend/layouts/header.php');
require_once root_path('frontend/layouts/top-header.php');

if (file_exists($pagePath) && is_file($pagePath)) {
    require_once $pagePath;
} else {
    echo "<h1>Sorry page not found 404 {$requestUri} </h1>";
}
require_once root_path('frontend/layouts/footer.php');

?>

