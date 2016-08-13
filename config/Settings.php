<?php
define('APP_DIR', '/home/marius/Programming/apps/syncer/app');
define('WEBAPP_DIR', '/var/www/html/travel/front');
return [
    "geographyDownloadDir" => APP_DIR."/var/download/geography/",
    "hotelsDownloadDir" => APP_DIR."/var/download/hotels/",
    "packagesDownloadDir" => APP_DIR."/var/download/packages/",
    "pricesDownloadDir" => APP_DIR."/var/download/prices/",
    "destinationsDownloadDir" => APP_DIR."/var/download/destinations/",
    "imagesDownloadDir" => WEBAPP_DIR."/web/assets/images/",
    "logDir" => APP_DIR."/var/log/"
    ];
