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
     * @var array
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
        $this->adjustAssetPath();
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('with_buster_hash', [$this, 'addBusterHash']),
        ];
    }

    public function addBusterHash($assetPath)
    {
        $hash = isset($this->hashMap[$assetPath]) ? $this->hashMap[$assetPath] : 'no-buster-hash-found';

        return $assetPath . "?v=$hash";
    }

    public function getName()
    {
        return 'buster_extension';
    }

    private function loadBustersFile()
    {
        $rootDir     = $this->container->get('kernel')->getRootDir();
        $bustersPath = $this->container->getParameter('gulp_buster.busters_file');

        $this->hashMap = json_decode(file_get_contents($rootDir . DIRECTORY_SEPARATOR . $bustersPath), true);
    }

    private function adjustAssetPath()
    {
        $webDir  = $this->container->getParameter('gulp_buster.web_dir');
        $gulpDir = $this->container->getParameter('gulp_buster.gulp_dir');

        $gulpToWeb = trim(str_replace($gulpDir, "", $webDir), '/');

        foreach ($this->hashMap as $path => $hash) {
            $this->hashMap[str_replace($gulpToWeb, "", $path)] = $hash;
            unset($this->hashMap[$path]);
        }
    }
}