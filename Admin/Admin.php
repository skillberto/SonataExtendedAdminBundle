<?php

namespace Skillberto\SonataExtendedAdminBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;

class Admin extends AbstractAdmin
{
    protected
        $translationDomain = "SkillbertoSonataExtendedAdminBundle",
        $actions = array (
            'show'      => array(),
            'edit'      => array(),
            'activate'  => array('template' => 'SkillbertoSonataExtendedAdminBundle:Admin:list__action_activate.html.twig'),
            'delete'    => array()
        ),
        $datagridValues = array(
            '_page' => 1, // Display the first page (default = 1)
            '_sort_order' => 'ASC', // Descendant ordering (default = 'ASC')
            '_sort_by' => 'position' // name of the ordered field (default = the model id field, if any) the '_sort_by' key can be of the form 'mySubModel.mySubSubModel.myField'.
        ),
        $em;

    protected static
        $RemovedFromRoute = array(
            "fos_",
            "admin_",
            "sonata_"
        );

    public static function validateRoute($name)
    {
        $valid = TRUE;

        foreach (self::$RemovedFromRoute as $pattern ) {
            if (strpos($name, $pattern) !== FALSE || stripos($name, "_") === 0 ) {
                $valid = FALSE;
            }
        }

        return $valid;
    }


    public function getTemplateActions($actions = array())
    {
        if (empty($actions)) {
            return $this->actions;
        }

        $sort = array();

        foreach ($actions as $action) {
            $sort[$action] = $this->actions[$action];
        }

        return $sort;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('activate', $this->getRouterIdParameter().'/activate');
    }
}
