<?php

App::import('Vendor/phpqrcode');
QRcode::png($string);
exit(0);
