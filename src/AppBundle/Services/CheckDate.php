<?php
/**
 * Created by PhpStorm.
 * User: Arno_2T
 * Date: 06/12/2017
 * Time: 13:26
 */

namespace AppBundle\Services;

use AppBundle\Entity\Ticket;
use DeepCopy\f007\FooDateTimeZone;

class CheckDate
{
    /**
     * @param Ticket $ticket
     * @return bool
     */
    public function checkDate(Ticket $ticket)
    {
        $now= new \DateTime();
        $dateVisit=$ticket->getDateVisit()->format('l'); //shows day's name for dateVisit
        $day=$ticket->getDateVisit()->format('m/d');
        $dateCompare=$now->format('d/m/y');

        if ($dateVisit=="Tuesday"|| $dateVisit=="Sunday")
        {

            return true;

        }
        elseif($day=="01/01"||$day=="05/01"||$day=="11/11"||$day=="12/25") //public holiday
        {

            return true;
        }
        elseif($ticket->getDateVisit()<$dateCompare)
        {

            return true;
        }
       // elseif($hour>=14)
       // {
       //     return true;
       // }
        return false;

    }

    public function checkHour(Ticket $ticket, $now=null)
    {

        $now= !isset($now)? new \DateTime(): $now;
        $day=$now->format('m/d/Y'); // today's date
        $dateVisit=$ticket->getDateVisit()->format('m/d/Y'); //booking date
        $hour=$now->format('H');
        $period=$ticket->getPeriod(); //booking period

        if($dateVisit==$day && $hour>=17){
           return true;
        }

        elseif($dateVisit==$day && $hour>=14 && $period==1)
        {
            return true;
        }
        return false;
    }

    public function checkLastHour(Ticket $ticket, $now=null)
    {
        $now= !isset($now)? new \DateTime(): $now;
        $day=$now->format('m/d/Y'); // today's date
        $dateVisit=$ticket->getDateVisit()->format('m/d/Y'); //booking date
        $hour=$now->format('H');

        if($dateVisit==$day && $hour>=17){
            return true;
        }
        return false;
    }

}