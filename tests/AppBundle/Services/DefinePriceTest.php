<?php
/**
 * Created by PhpStorm.
 * User: Arno_2T
 * Date: 28/12/2017
 * Time: 16:19
 */

namespace Tests\AppBundle\Services;

use AppBundle\Entity\Ticket;
use AppBundle\Entity\Visitor;
use AppBundle\Services\DefinePrice;
use PHPUnit\Framework\TestCase;

class DefinePriceTest extends TestCase
{
    /**
     * @param $birthdate
     * @param $period
     * @param $discount
     * @param $expectedPrice
     * @dataProvider datasForTestingPrice
     */
    public function testPriceForVisitors($birth, $period, $discount, $expectedPrice)
    {
        $definePrice= new DefinePrice();
        $ticket= new Ticket();
        $ticket->setPeriod($period);
        $visitors=new Visitor();
        $visitors->setBirthdate($birth);
        $visitors->setDiscount($discount);
        $ticket->addVisitor($visitors);
        $visitors= $ticket->getVisitors();
        $definePrice->definePrice($ticket);
        $price= $ticket->getPrice();
        dump($price);

        $this->assertEquals($expectedPrice, $price );



    }

    public function datasForTestingPrice()
    {
        return [
            [new \DateTime('01/01/2016'), 1,false, 0],
            [new \DateTime('01/01/1987'), 1, false, 16],
            [new \DateTime('01/01/1987'), 1, true, 10],
            [new \DateTime('01/01/1987'), 0.5,false, 8],
            [new \DateTime('01/01/2012'), 1, false, 8],
            [new \DateTime('01/01/1950'), 1, false, 12],

        ];
    }

}