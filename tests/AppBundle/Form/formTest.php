<?php
/**
 * Created by PhpStorm.
 * User: Arno_2T
 * Date: 27/12/2017
 * Time: 18:43
 */

/*namespace Tests\AppBundle\Form;

use AppBundle\Controller\FrontController;
use AppBundle\Entity\Ticket;
use AppBundle\Form\TicketType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FormTest extends TypeTestCase
{
    private $validator;

    protected function getExtensions()
    {
        $this->validator = $this->createMock(ValidatorInterface::class);
         //use getMock() on PHPUnit 5.3 or below
        // $this->validator = $this->getMock(ValidatorInterface::class);
        $this->validator
            ->method('validate')
            ->will($this->returnValue(new ConstraintViolationList()));
        $this->validator
            ->method('getMetadataFor')
            ->will($this->returnValue(new ClassMetadata(Form::class)));

        return array(
            new ValidatorExtension($this->validator),
        );
    }
    public function testSubmitValidData()
    {

        $formData = array(
            'appbundle_ticket[email]' => 'arnaud2987@yahoo.fr',
            'appbundle_ticket[period]' => 1,
            'appbundle_ticket[dateVisit]' => "25/05/2018",
            'appbundle_ticket[visitors][1][lastName]' => 'Test',
            'appbundle_ticket[visitors][1][firstName]' => 'Test',
            'appbundle_ticket[visitors][1][country]' => 'France',
            'appbundle_ticket[visitors][1][birthday][month]'=> 'Jan',
            'appbundle_ticket[visitors][1][birthday][day]' => '12',
            'appbundle_ticket[visitors][1][birthday][year]' => '1987',
            'appbundle_ticket[visitors][1][discount]' => 1,
        );

        $form= $this->factory->create(TicketType::class);

        //$object= ::fromArray($formData);
        //$object= FrontController::fromArray($formData);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}*/