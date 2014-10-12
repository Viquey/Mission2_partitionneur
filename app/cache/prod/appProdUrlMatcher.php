<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        // _partitioneur
        if ($pathinfo === '/partitioneur/hello') {
            return array (  '_controller' => 'Org\\PartitioneurBundle\\Controller\\DefaultController::indexAction',  '_route' => '_partitioneur',);
        }

        // org_user_default_index
        if (0 === strpos($pathinfo, '/hello') && preg_match('#^/hello/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'org_user_default_index')), array (  '_controller' => 'Org\\UserBundle\\Controller\\DefaultController::indexAction',));
        }

        if (0 === strpos($pathinfo, '/org')) {
            // org_forma_default_index
            if ($pathinfo === '/org/login') {
                return array (  '_controller' => 'Org\\FormaBundle\\Controller\\DefaultController::indexAction',  '_route' => 'org_forma_default_index',);
            }

            // org_forma_default_test
            if ($pathinfo === '/org/test') {
                return array (  '_controller' => 'Org\\FormaBundle\\Controller\\DefaultController::testAction',  '_route' => 'org_forma_default_test',);
            }

        }

        if (0 === strpos($pathinfo, '/login')) {
            // login
            if ($pathinfo === '/login') {
                return array (  '_controller' => 'UserBundle:Security:login',  '_route' => 'login',);
            }

            // login_check
            if ($pathinfo === '/login_check') {
                return array('_route' => 'login_check');
            }

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
