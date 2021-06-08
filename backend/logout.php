<?php

require_once "../config/config.php";

session_destroy();

redirect_to('backend/login');
