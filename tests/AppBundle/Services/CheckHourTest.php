<?php
/**
 * Created by PhpStorm.
 * User: Arno_2T
 * Date: 12/01/2018
 * Time: 01:15
 */

namespace Tests\AppBundle\Services;

use AppBundle\Entity\Ticket;
use AppBundle\Services\CheckDate;
use PHPUnit\Framework\TestCase;

class CheckHourTest extends TestCase
{
    public function testHourFunction()
    {
        $ticket= new Ticket();
        $hourTest= new \DateTime('01/12/2018 14:35:29');
        $ticket->setDateVisit($hourTest);
        $ticket->setPeriod(1);
        $checkDate= new CheckDate();

        $this->assertSame(true, $checkDate->checkHour($ticket, $hourTest));

    }
}