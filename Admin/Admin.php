<?php

namespace Skillberto\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin as BaseAdmin;
use Sonata\AdminBundle\Route\RouteCollection;

class Admin extends BaseAdmin
{    
    protected
        $translationDomain = "SkillbertoAdminBundle",
        $actions = array (
            'view'      => array(),
            'edit'      => array(),
            'activate'  => array('template' => 'SkillbertoAdminBundle:Admin:list__action_activate.html.twig'),
            'delete'    => array()
        ),
        $datagridValues = array(
            '_page' => 1, // Display the first page (default = 1)
            '_sort_order' => 'ASC', // Descendant ordering (default = 'ASC')
            '_sort_by' => 'position' // name of the ordered field (default = the model id field, if any) the '_sort_by' key can be of the form 'mySubModel.mySubSubModel.myField'.
        );
    
    protected static
            $RemovedFromRoute = array(
                "_",
                "fos_",
                "admin_",
                "sonata_"
            );
    
    public static function validateRoute($name)
    {
        $valid = TRUE;
        
        foreach (self::$RemovedFromRoute as $pattern ) {
            if (stripos($name, $pattern) === 0) {
                $valid = FALSE;
            }                
        }
        
        return $valid;
    }
    
    /**
     * Set entity default settings
     * 
     * @return object
     */
    public function getNewInstance()
    {        
        $instance = parent::getNewInstance();
     
        if (isset($this->container)) {
            $repository = $this->container->get('doctrine')->getRepository($this->getClass());
        
            //set position
            if (method_exists($repository, 'getMaxPosition') && method_exists($instance, 'setPosition')) {
                $instance->setPosition(($repository->getMaxPosition())+1);
            }
        }
        
        //set active
        if (method_exists($instance, 'setActive')) {
            $instance->setActive(TRUE);
        }
        
        return $instance;
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
        $collection->add('sort', 'sort');
    }    
}