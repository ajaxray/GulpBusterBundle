<?php
namespace Ajaxray\GulpBusterBundle\Tests\app;

use Ajaxray\GulpBusterBundle\GulpBusterBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;

/**
 * @author   Anis Ahmad <anis.programmer@gmail.com>
 * @package  GulpBusterBundle
 */
class AppKernel extends Kernel
{

    /**
     * Returns an array of bundles to register.
     *
     * @return BundleInterface[] An array of bundle instances.
     */
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new TwigBundle(),
            new GulpBusterBundle(),
        ];
    }

    /**
     * Loads the container configuration.
     *
     * @param LoaderInterface $loader A LoaderInterface instance
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config.yml');
    }

    public function indexAction()
    {
        $twig = $this->getContainer()->get('twig');
        $twig->setLoader(new \Twig_Loader_Array([
            'test_twig_content' => '{{"/js/common.min.js"|with_buster_hash }}',
            'another_twig_content' => '{{"/js/common.min.css"|with_buster_hash }}'
        ]));

        return new Response($twig->render('test_twig_content'));
    }
}