<?php
/**
 * @author   Anis Ahmad <anis.programmer@gmail.com>
 * @package  GulpBusterBundle
 */

namespace Ajaxray\GulpBusterBundle\Twig;

class BusterExtension extends \Twig_Extension
{
    /**
     * @var array
     */
    protected $paths;

    /**
     * @var array
     */
    protected $hashMap;

    /**
     * Constructor
     *
     * @param array
     */
    public function __construct(array $paths)
    {
        $this->paths = $paths;

        $this->loadBustersFile();
        $this->adjustAssetPath();
    }

    /**
     * @codeCoverageIgnore
     */
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
        $this->hashMap = json_decode(file_get_contents($this->paths['busters_file']), true);
    }

    private function adjustAssetPath()
    {
        $gulpToWeb = trim(str_replace($this->paths['gulp_dir'], "", $this->paths['web_dir']), '/');

        foreach ($this->hashMap as $path => $hash) {
            $this->hashMap[str_replace($gulpToWeb, "", $path)] = $hash;
            unset($this->hashMap[$path]);
        }
    }
}
