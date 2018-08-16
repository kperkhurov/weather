<?php

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\RouteCollectionBuilder;

require __DIR__ . '/../vendor/autoload.php';

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        return [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new MoviesBundle\MoviesBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheDir()
    {
        return sprintf('%s/var/cache/%s', __DIR__ . '/../', $this->getEnvironment());
    }

    /**
     * {@inheritdoc}
     */
    protected function configureContainer(ContainerBuilder $c, LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/../app/config/config.yml');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollectionBuilder $routes)
    {
        $routes->mount('/', $routes->import('@MoviesBundle/Resources/routing/routing.yml'));
    }
}

$kernel = new Kernel('dev', true);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
