<?php

namespace Skillberto\SonataExtendedAdminBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * This class has some more method for Sonata Admin Bundle
 * 
 * @author Norbert Heiszler <skillbertoo@gmail.com>
 */
class CRUDController extends Controller
{
    /**
     * Activate or inactivate the object
     * 
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
     * @return Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function activateAction()
    {
        $object = $this->getObject();
        
        if (method_exists($object, 'setActive') && method_exists($object, 'getActive')) {
            $object->setActive(($object->getActive()==1) ? 0 : 1);
        }
        
        $this->admin->update($object);        
        
        return new RedirectResponse($this->admin->generateUrl('list'));
    }
    
    protected function getObject($objectId = NULL)
    {
        $id = $this->get('request')->get($this->admin->getIdParameter());

        $object = $this->admin->getObject(empty($objectId) ? $id : $objectId);
        
        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }
        
        return $object;
    }
}