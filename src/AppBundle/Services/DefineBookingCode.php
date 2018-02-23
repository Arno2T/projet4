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
        $date=$date->format('dmY');
        $characts    = 'abcdefghijklmnopqrstuvwxyz';
        $characts   .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characts   .= '1234567890';
        $code     = '';

        for($i=0;$i < 6;$i++)    //6 is number of characters
        {
            $code .= substr($characts,rand()%(strlen($characts)),1);
        }

        $bookingCode=$date.'LO'.$code;
        $ticket->setBookingCode($bookingCode);
    }
}