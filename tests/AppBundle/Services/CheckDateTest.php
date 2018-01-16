<?php
/**
 * Created by PhpStorm.
 * User: Arno_2T
 * Date: 28/12/2017
 * Time: 14:38
 */

namespace Tests\AppBundle\Services;

use AppBundle\Entity\Ticket;
use AppBundle\Services\CheckDate;
use PHPUnit\Framework\TestCase;

class CheckDateTest extends TestCase
{
    /**
     * @param CheckDate $checkDate
     * @param $dayTest
     * @param $expectedReturn
     * @dataProvider datesForDateVisit
     */
    public function testCheckDateService($dayTest, $expectedReturn)
    {
        $ticket= new Ticket();
        $ticket->setDateVisit($dayTest);
        $checkDate= new CheckDate();

        $this->assertSame($expectedReturn, $checkDate->checkDate($ticket));
    }

    public function datesForDateVisit()
    {
        return [
            [new \DateTime('01/01/2018'), true], // public holiday
            [new \DateTime('05/01/2019'), true], // public holiday
            [new \DateTime('11/18/2018'), true], // Sunday
            [new \DateTime('01/16/2018'), true], // Tuesday
            [new \DateTime('12/02/2020'), false]
        ];
    }
}