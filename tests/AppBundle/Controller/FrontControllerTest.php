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
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testShowHomeIsUp()
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testLinkBookingIsOk()
    {
        $crawler = $this->client->request('GET', '/');

        $link = $crawler->selectLink('Réserver')->link();
        $crawler = $this->client->click($link);

        $info = $crawler->filter('h3')->text();
        $this->assertSame("Réservation", $info);
    }

    public function testAddTicket()
    {
        $crawler = $this->client->request('GET', '/booking');

        // Get the form
        $form = $crawler->filter('button')->form();
        $form['appbundle_ticket[email]'] = 'arnaud2987@yahoo.fr';
        $form['appbundle_ticket[period]'] = 1;
        $form['appbundle_ticket[dateVisit]'] = '25/05/2018';
        //get the raw values.
        $values = $form->getPhpValues();

        //Add fields to the raw values.
        $values['appbundle_ticket']['visitors'][0]['lastName'] = 'Test';
        $values['appbundle_ticket']['visitors'][0]['firstName'] = 'Test';
        $values['appbundle_ticket']['visitors'][0]['country'] = 'TestCountry';
        $values['appbundle_ticket']['visitors'][0]['birthday']['month'] = 'Jan';
        $values['appbundle_ticket']['visitors'][0]['birthday']['day'] = '05';
        $values['appbundle_ticket']['visitors'][0]['birthday']['year'] = '1987';
        $values['appbundle_ticket']['visitors'][0]['discount'] = 1;

        //Submit the form with the existing and new values

        $crawler = $this->client->request($form->getMethod(), $form->getUri(), $values,
            $form->getPhpFiles());
        $checkbox = $crawler->filter('checkbox')->count();
        //The 7tags have been added to the collection
        $inputs = $crawler->filter('input')->count();
        $selects = $crawler->filter('select')->count();

        $this->assertEquals(11, $inputs + $checkbox + $selects);


    }
}



