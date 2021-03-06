<?php
use Knp\Provider\ConsoleServiceProvider;
use Config\Keys;
use Config\Settings;

use Service\Provider as ProviderService;
use Service\Geography as GeographyService;
use Service\Hotel as HotelService;
use Service\RoomCategory as RoomCategoryService;
use Service\DetailedDescription as DetailedDescription;
use Service\Package as PackageService;
use Service\PriceSet as PriceSetService;
use Service\Price as PriceService;
use Service\MealPlan as MealPlanService;
use Service\DepartureDate as DepartureDateService;
use Service\Destination as DestinationService;

$keys = Keys::provide();

$app['keys'] = $keys;
$app['settings'] = require(__DIR__."/Settings.php");

$app->register(
    new ConsoleServiceProvider(),
    array(
        'console.name' => 'Travel App Syncer',
        'console.version' => '0.1.0',
        'console.project_directory' => __DIR__ . "/.."
    )
);

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array (
        'driver'    => 'pdo_mysql',
        'host'      => $keys['db']['hostname'],
        'dbname'    => $keys['db']['database'],
        'user'      => $keys['db']['username'],
        'password'  => $keys['db']['password'],
        'charset'   => 'utf8mb4'
    )
));

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => $app['settings']['logDir'].'/development.log',
));

#### app services ####
$app['service.provider'] = function($app){
    return new ProviderService($app);
};
$app['service.geography'] = function($app){
    return new GeographyService($app);
};
$app['service.hotel'] = function($app){
    return new HotelService($app);
};
$app['service.hotel_room'] = function($app){
    return new RoomCategoryService($app);
};
$app['service.description'] = function($app){
    return new DetailedDescription($app);
};
$app['service.package'] = function($app){
    return new PackageService($app);
};
$app['service.price'] = function($app){
    return new PriceService($app);
};
$app['service.price_set'] = function($app){
    return new PriceSetService($app);
};
$app['service.meal_plan'] = function($app){
    return new MealPlanService($app);
};
$app['service.departure_date'] = function($app){
    return new DepartureDateService($app);
};
$app['service.destination'] = function($app){
    return new DestinationService($app);
};
