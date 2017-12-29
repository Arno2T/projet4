<?php
/**
 * Created by PhpStorm.
 * User: Arno_2T
 * Date: 22/11/2017
 * Time: 10:20
 */

namespace AppBundle\Services;

    use AppBundle\Entity\Ticket;
    use Symfony\Component\HttpFoundation\Session\Session;


    class DefinePrice
    {
        public function definePrice(Ticket $ticket)
        {
            $visitors=$ticket->getVisitors();
            $total=0;
            $nbVisitor= count($visitors);
            foreach($visitors as $visitor)
            {
                $period= $ticket->getPeriod();
                $now=new \DateTime();
                $date=$now->format('Y');
                $birth= $visitor->getBirthDate()->format('Y');
                $diff=$date - $birth;


                if ($visitor->getDiscount() == true && $diff > 4)
                {
                    $price = 10* $period;

                }
                elseif($diff<4)
                {
                    $price=0;
                }
                elseif($diff>=4 && $diff<=12)
                {
                    $price=8* $period;
                }
                elseif($diff>60)
                {
                    $price= 12* $period;
                }
                else
                {
                    $price= 16*$period;
                }

                $total += $price;
                $ticket->setPrice($total);
                $ticket->setNbVisitors($nbVisitor);



            }
        }




    }
