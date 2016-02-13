<?php
namespace Ajaxray\GulpBusterBundle\Tests\Twig;

use Ajaxray\GulpBusterBundle\Tests\app\AppKernel;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author   Anis Ahmad <anis.programmer@gmail.com>
 * @package  GulpBusterBundle
 */
class BusterExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerInterface
     */
    private $container;

    protected function setUp()
    {
        $kernel = new AppKernel('test', true);
        $kernel->boot();

        $this->container = $kernel->getContainer();
    }

    public function testWithBusterHashFilterWithGenericDir()
    {
        $twig = $this->container->get('twig');

        $twig->setLoader(new \Twig_Loader_Array([
            'hash_found_twig_content'   => '{{"/js/common.min.js"|with_buster_hash }}',
            'hash_missing_twig_content' => '{{"/js/uncommon.min.css"|with_buster_hash }}'
        ]));

        $this->assertEquals('/js/common.min.js?v=the-hash-for-common-min-js', $twig->render('hash_found_twig_content'));
        $this->assertEquals('/js/uncommon.min.css?v=no-buster-hash-found', $twig->render('hash_missing_twig_content'));
    }
}
