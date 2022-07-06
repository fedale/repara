<?php

namespace App\Entity2;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerProfile
 *
 * @ORM\Table(name="customer_profile")
 * @ORM\Entity
 */
class CustomerProfile
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=64, nullable=false)
     */
    private $lastname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="public_email", type="string", length=255, nullable=true)
     */
    private $publicEmail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="gravatar_email", type="string", length=255, nullable=true)
     */
    private $gravatarEmail;

    /**
     * @var string|null
     *
     * @ORM\Column(name="gravatar_id", type="string", length=32, nullable=true)
     */
    private $gravatarId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @var string|null
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bio", type="text", length=65535, nullable=true)
     */
    private $bio;

    /**
     * @var string|null
     *
     * @ORM\Column(name="timezone", type="string", length=40, nullable=true)
     */
    private $timezone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="setting", type="text", length=0, nullable=true, options={"comment"="settings preferences"})
     */
    private $setting;

    /**
     * @var \Customer
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Customer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     * })
     */
    private $customer;


}
