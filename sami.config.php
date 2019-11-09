<?php

use Sami\Sami;
use Sami\RemoteRepository\GitHubRemoteRepository;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in($dir = __DIR__.'/../organic/src')
;

//$versions = GitVersionCollection::create($dir)
//    ->addFromTags('v0.*')
//    ->addFromTags('v1.*')
//    ->add('2.0', '2.0 branch')
//    ->add('master', 'master branch')
;

return new Sami($iterator, [
//    'theme'                => 'symfony',
//    'versions'             => $versions,
    'title'                => 'Organic API',
    'build_dir'            => __DIR__.'/../organic/docs',
    'cache_dir'            => sys_get_temp_dir().'/sami/organic/cache/%version%',
//    'remote_repository'    => new GitHubRemoteRepository('symfony/symfony', dirname($dir)),
//    'default_opened_level' => 2,
]);
