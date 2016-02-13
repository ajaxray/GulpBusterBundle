<?php
/**
 * @author   Anis Ahmad <anis.programmer@gmail.com>
 * @package  GulpBusterBundle
 */
set_time_limit(0);
require_once __DIR__.'/autoload.php';

use Ajaxray\GulpBusterBundle\Tests\app\AppKernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;

$kernel = new AppKernel('dev', true);
$application = new Application($kernel);
$application->run();