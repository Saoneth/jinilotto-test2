<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerDetailsRepository")
 * @ORM\Table(name="customer_details")
 */
class CustomerDetails
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", columnDefinition="CHAR(201) NOT NULL")
     */
    private $fullname;

    /**
     * @ORM\Column(type="string", columnDefinition="CHAR(255) NOT NULL")
     */
    private $e_mail;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $balance;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $totalpurchase;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getEMail(): ?string
    {
        return $this->e_mail;
    }

    public function setEMail(string $e_mail): self
    {
        $this->e_mail = $e_mail;

        return $this;
    }

    public function getBalance(): ?string
    {
        return $this->balance;
    }

    public function setBalance(string $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getTotalpurchase(): ?string
    {
        return $this->totalpurchase;
    }

    public function setTotalpurchase(string $totalpurchase): self
    {
        $this->totalpurchase = $totalpurchase;

        return $this;
    }
}
