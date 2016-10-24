<?php
require __DIR__ . '/../vendor/autoload.php';
use Zend\Diactoros\ServerRequestFactory;
use App\Alerts;

$request = ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$alerts = new Alerts();

require __DIR__ . '/../app/controller.php';
require __DIR__ . '/../routes/web.php';


$matcher = $routerContainer->getMatcher();

$route = $matcher->match($request);

if ($route)
{
  foreach ($route->attributes as $key => $val) {
    $request = $request->withAttribute($key, $val);
  }
  $callable = $route->handler;
  $response = $callable($request);

}

else
{
    // get the first of the best-available non-matched routes
    $failedRoute = $matcher->getFailedRoute();

    // which matching rule failed?
    switch ($failedRoute->failedRule)
    {
        case 'Aura\Router\Rule\Allows':
            echo '405 METHOD NOT ALLOWED';
            // Send the $failedRoute->allows as 'Allow:'
            break;
        case 'Aura\Router\Rule\Accepts':
            echo '406 NOT ACCEPTABLE';
            break;
        default:
            echo '404 NOT FOUND';
            break;

    }
}

?>
