<?php
/**
 * Created by PhpStorm.
 * User: Arno_2T
 * Date: 26/11/2017
 * Time: 16:07
 */

namespace AppBundle\Services;


use AppBundle\Entity\Ticket;

use Doctrine\ORM\EntityManager;





class NbVisitors
{
    private $manager;
    public function __construct(EntityManager $manager)
    {
        $this->manager= $manager;
    }

    public function checkVisitors(Ticket $ticket)
   {

       $repo=$this->manager->getRepository('AppBundle:Ticket');
       $dateVisit=$ticket->getDateVisit()->format('Y/m/d');

       $nbVisit=$repo->countNumberVisitors($dateVisit);
       dump($nbVisit);

       if($nbVisit>=1000)
       {
           return true;
       }

       return false;









   }
}