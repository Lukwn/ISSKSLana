<?php
header_remove("X-Powered-By");  
header_remove("Server");
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 0');
header('X-Content-Type-Options: nosniff');

ini_set("session.cookie_httponly", True);
