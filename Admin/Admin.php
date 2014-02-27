<?php

namespace Skillberto\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin as BaseAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;

class Admin extends BaseAdmin
{    
    protected
        $translationDomain = "SkillbertoAdminBundle",
        $actions = array (
            'show'      => array(),
            'edit'      => array(),
            'activate'  => array('template' => 'SkillbertoAdminBundle:Admin:list__action_activate.html.twig'),
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
    
    public function __construct($code, $class, $baseControllerName, EntityManager $em) {
        $this->em = $em;
        
        parent::__construct($code, $class, $baseControllerName);
    }

        /**
     * Set entity default settings
     * 
     * @return object
     */
    public function getNewInstance()
    {        
        $instance = parent::getNewInstance();
                  
        //set position
        if (method_exists($instance, 'setPosition')) {
            $instance->setPosition(($this->getMaxPosition($this->getClass()))+1);
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
    
    protected function getMaxPosition($entity)
    {
        $query = $this->em->createQuery('SELECT MAX(m.position) p FROM '.$entity.' m');
        try {
            return $query->getSingleScalarResult();
        } catch( NoResultException $e) {
            return 0;
        }
    }
}