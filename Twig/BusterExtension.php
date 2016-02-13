<?php
/**
 * @author   Anis Ahmad <anis.programmer@gmail.com>
 * @package  GulpBusterBundle
 */

namespace Ajaxray\GulpBusterBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class BusterExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var \stdClass
     */
    protected $hashMap;

    /**
     * Constructor
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->loadBustersFile();
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('with_buster_hash', array($this, 'addBusterHash')),
        );
    }

    public function addBusterHash($assetPath)
    {
        $assetPath = ltrim($assetPath, "/");
        $hash = isset($this->hashMap[$assetPath]) ? $this->hashMap[$assetPath] : 'no-buster-hash';

        return $assetPath. "?v=$hash";
    }

    public function getName()
    {
        return 'buster_extension';
    }

    private function loadBustersFile()
    {
        $rootDir    = $this->container->get('kernel')->getRootDir();
        $busterPath = $this->container->getParameter('gulp_buster.buster_path');

        $this->hashMap = json_decode(file_get_contents($rootDir . DIRECTORY_SEPARATOR . $busterPath), true);
    }
}