<?php
/**
 * Created by PhpStorm.
 * User: Arno_2T
 * Date: 06/12/2017
 * Time: 13:26
 */

namespace AppBundle\Services;

use AppBundle\Entity\Ticket;

class CheckDate
{
    public function checkDate(Ticket $ticket)
    {
        $now= new \DateTime();
        $dateVisit=$ticket->getDateVisit()->format('l');
        $day=$ticket->getDateVisit()->format('m/d');



        if ($dateVisit=="Tuesday"|| $dateVisit=="Sunday")
        {
            return true;
        }
        elseif($day=="01/01"||$day=="05/01"||$day=="11/11"||$day=="12/25")
        {
            return true;
        }
        elseif($ticket->getDateVisit()<$now)
        {
            return true;
        }
        return false;

    }
}