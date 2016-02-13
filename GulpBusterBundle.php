<?php
namespace Ajaxray\GulpBusterBundle;
use Ajaxray\GulpBusterBundle\DependencyInjection\AjaxrayGulpBusterExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author   Anis Ahmad <anis.programmer@gmail.com>
 * @package  GulpBusterBundle
 */
class GulpBusterBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new AjaxrayGulpBusterExtension();
    }
}