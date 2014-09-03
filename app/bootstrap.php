<?php

use Silex\Provider\TwigServiceProvider as Twig;
use Silex\Provider\UrlGeneratorServiceProvider as Url;
use Silex\Provider\HttpCacheServiceProvider as Cache;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\HttpFoundation\Request;

$app['debug'] = false;
$app['locale'] = 'es';

$yaml = new Parser();

//Parameters
$parameters = $yaml->parse(file_get_contents(__DIR__ . '/config/parameters.yml'));
$app['server_versions'] = $parameters['server_versions'];
//end Parameters

//Cache
$app->register(new Cache(), array(
    'http_cache.cache_dir' => __DIR__ . '/cache/',
));
//end Cache

//Twig
$app->register(new Twig(), array(
    'twig.path'       => __DIR__ . '/../src/Main/Resources/views/',
    'twig.class_path' => __DIR__ . '/../vendor/twig/twig/lib/'
));
//end Twig

//Routing
$app->register(new Url());
//end Routing

// _method hidden input enabled
Request::enableHttpMethodParameterOverride();