<?php
/**
 * This class create admin user
 * 
 * @author Norbert Heiszler <skillbertoo@gmail.com>
 */

namespace Skillberto\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use FOS\UserBundle\Doctrine\UserManager;

class LoadUserdata implements FixtureInterface, ContainerAwareInterface
{
    private $container;
    
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager) {
        
        $userManager = $this->container->get('fos_user.user_manager');
        
        $user = $userManager->createUser();

        $user->setUsername('Admin');
        $user->setEmail('email@email.hu');
        $user->setPlainPassword('asd123');
        $user->setEnabled(TRUE);
        $user->setSuperAdmin(TRUE);
        
        $userManager->updateUser($user);
    }
}
