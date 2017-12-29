<?php
/**
 * Created by PhpStorm.
 * User: Arno_2T
 * Date: 22/11/2017
 * Time: 16:01
 */

namespace AppBundle\Services;

use AppBundle\Entity\Ticket;

class DefineBookingCode
{
    public function DefineCode(Ticket $ticket)
    {
        $date=new \DateTime();
        $date=$date->format('dmy');
        $id= $ticket->getId();

        $code=$date.'LO'.$id;
        $ticket->setBookingCode($code);
    }
}