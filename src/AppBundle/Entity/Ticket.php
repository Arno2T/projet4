<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Visitor", mappedBy="ticket", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid()
     */
    private $visitors;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email(message="Cet email '{{ value }}' n'est pas un email valide.",
     *     checkMX = true )
     * @Assert\NotBlank(message="Ce champ doit contenir une adresse mail valide")
     *
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="period", type="integer")
     *
     */
    private $period;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateVisit", type="datetime")
     * @Assert\DateTime()
     */
    private $dateVisit;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     * @Assert\Type(type="integer")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="bookingCode", type="string", length=255)
     * @Assert\Type(type="string")
     */
    private $bookingCode;

    /**
     * @var int
     *
     * @ORM\Column(name="nbVisitors", type="integer")
     */
    private $nbVisitors;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param integer $period
     *
     * @return Ticket
     */
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get period
     *
     * @return int
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set dateVisit
     *
     * @param \DateTime $dateVisit
     *
     * @return Ticket
     */
    public function setDateVisit($dateVisit)
    {
        $this->dateVisit = $dateVisit;

        return $this;
    }

    /**
     * Get dateVisit
     *
     * @return \DateTime
     */
    public function getDateVisit()
    {
        return $this->dateVisit;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Ticket
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set bookingCode
     *
     * @param string $bookingCode
     *
     * @return Ticket
     */
    public function setBookingCode($bookingCode)
    {
        $this->bookingCode = $bookingCode;

        return $this;
    }

    /**
     * Get bookingCode
     *
     * @return string
     */
    public function getBookingCode()
    {
        return $this->bookingCode;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->visitors = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add visitor
     *
     * @param \AppBundle\Entity\Visitor $visitor
     *
     * @return Ticket
     */
    public function addVisitor(\AppBundle\Entity\Visitor $visitor)
    {
        $this->visitors[] = $visitor;
        $visitor->setTicket($this);

        return $this;
    }

    /**
     * Remove visitor
     *
     * @param \AppBundle\Entity\Visitor $visitor
     */
    public function removeVisitor(\AppBundle\Entity\Visitor $visitor)
    {
        $this->visitors->removeElement($visitor);
    }

    /**
     * Get visitors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVisitors()
    {
        return $this->visitors;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Ticket
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set nbVisitors
     *
     * @param integer $nbVisitors
     *
     * @return Ticket
     */
    public function setNbVisitors($nbVisitors)
    {
        $this->nbVisitors = $nbVisitors;

        return $this;
    }

    /**
     * Get nbVisitors
     *
     * @return integer
     */
    public function getNbVisitors()
    {
        return $this->nbVisitors;
    }
}
