<?php
/**
 * @author   Anis Ahmad <anis.programmer@gmail.com>
 * @package  GulpBusterBundle
 */
require_once __DIR__.'/autoload.php';

use Ajaxray\GulpBusterBundle\Tests\app\AppKernel;
use Symfony\Component\HttpFoundation\Request;

$kernel = new AppKernel('dev', true);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);

$response->send();

# Run as:
# php Tests/app/console.php server:run -d Tests/app --env=dev --router=Tests/app/web.php 127.0.0.1:8080