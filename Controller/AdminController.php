<?php

namespace Skillberto\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sonata\AdminBundle\Admin\AdminInterface;
use Symfony\Component\DependencyInjection\Container;

class AdminController extends Controller
{
    public static function activateAction(Container $container, AdminInterface $admin, $id, $entity)
    {        
        $em = $container->get('doctrine')->getManager();
        $menu = $em->getRepository($entity)->find($id);
        
        $menu->setActive(($menu->getActive()==1) ? 0 : 1);
        $em->flush();
        
        return new RedirectResponse($admin->generateUrl('list'));
    }
}