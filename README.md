GulpBusterBundle
==========================

[![Build Status](https://travis-ci.org/ajaxray/GulpBusterBundle.svg?branch=master)](https://travis-ci.org/ajaxray/GulpBusterBundle)
[![Coverage Status](https://coveralls.io/repos/github/ajaxray/GulpBusterBundle/badge.svg?branch=master)](https://coveralls.io/github/ajaxray/GulpBusterBundle?branch=master)
[![Latest Stable Version](https://poser.pugx.org/ajaxray/gulp-buster-bundle/v/stable)](https://packagist.org/packages/ajaxray/gulp-buster-bundle) 
[![Total Downloads](https://poser.pugx.org/ajaxray/gulp-buster-bundle/downloads)](https://packagist.org/packages/ajaxray/gulp-buster-bundle)
[![License](https://poser.pugx.org/ajaxray/gulp-buster-bundle/license)](https://packagist.org/packages/ajaxray/gulp-buster-bundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e01bebbb-6aa4-4188-910d-7f51c2503d1e/mini.png)](https://insight.sensiolabs.com/projects/e01bebbb-6aa4-4188-910d-7f51c2503d1e)

When using **gulp** to manage assets of a Symfony application, 
this Bundle will help in cache busting with help of 
[gulp-buster](https://www.npmjs.com/package/gulp-buster) package.   

## Installation

Install the latest version with  
```
$ composer require ajaxray/gulp-buster-bundle
```

Then enable the bundle in AppKernel -      
``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Ajaxray\GulpBusterBundle\GulpBusterBundle(),
    );
}
```

## How to use
Assuming you are using **[gulp-buster](https://www.npmjs.com/package/gulp-buster)** to generate hashes for your 
web assets (javascript, css, images etc. static resources).  

Now the next thing is using those hashes with your web assets. This bundle will make it easy by adding a 
Twig Filter. Here is how to use this filter in Twig views -   
```
<link rel="stylesheet" href="{{ asset('css/example.min.css')|with_buster_hash  }}">
```

If a hash is found for this file, it will be appended as query string with it's url -   
```
<link rel="stylesheet" href="/css/example.min.css?v=771191ec8571a3f46afdb78f3e7bed17">
```

If no hash found for this file -  
```
<link rel="stylesheet" href="/css/example.min.css?v=no-buster-hash-found">
```

That's all :)


## Configuration

By default, this bundle assumes the following paths -

- busters.json (or any other name) file : `%kernel.root_dir%/../busters.json`
- web dir: `%kernel.root_dir%/../web`
- gulp dir (the dir of your gulpfile.js): `%kernel.root_dir%/..`

If any/all of the above is different for you, you can configure from your `app/config/config.yml` 
file using following keys -  

```yml
gulp_buster:  
    # if you've configured it to be in web dir    
    busters_file: "%kernel.root_dir%/../web/busters.json"    
    web_dir: "%kernel.root_dir%/relative/path/to/web/dir"    
    gulp_dir: "%kernel.root_dir%/relative/path/to/dir"    
```
