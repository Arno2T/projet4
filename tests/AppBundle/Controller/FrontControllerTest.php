<?php
/**
 * Created by PhpStorm.
 * User: Arno_2T
 * Date: 24/12/2017
 * Time: 01:42
 */

namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;



class FrontControllerTest extends WebTestCase
{
    private $client=null;

    public function setUp()
    {
        $this->client= static::createClient();
    }
    public function testShowHomeIsUp()
    {
        $crawler= $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testLinkBookingIsOk()
    {
        $crawler= $this->client->request('GET', '/');

        $link=$crawler->selectLink('Réservation')->link();
        $crawler=$this->client->click($link);

        $info= $crawler->filter('h3')->text();
        $this->assertSame("Réservation", $info);
    }

    /*public function testAddTicket()
    {
        $crawler= $this->client->request('GET', '/booking');
        dump($crawler);

        $form=$crawler->selectButton('appbundle_ticket[save]')->form();
        $form['appbundle_ticket[email]']= 'arnaud2987@yahoo.fr';
        $form['appbundle_ticket[period]']= 1;
        $form['appbundle_ticket[dateVisit]']= '25/05/2018';
        $form['appbundle_ticket[visitors][1][lastName]']= 'Test';
        $form['appbundle_ticket[visitors][1][firstName]']= 'Test';
        $form['appbundle_ticket[visitors][1][country]']= 'TestCountry';
        $form['appbundle_ticket[visitors][1][birthday][month]']= 'Jan';
        $form['appbundle_ticket[visitors][1][birthday][day]']= '05';
        $form['appbundle_ticket[visitors][1][birthday][year]']= '1987';
        $form['appbundle_ticket[visitors][1][discount]']= 1;
        $this->client->submit($form);

        $crawler= $this->client->followRedirect();

        $info= $crawler->filter('h2')->text();
        $this->assertSame("Votre commande", $info);
    }*/

}