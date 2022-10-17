<?php

namespace App\Form\Model;

use App\Validator\UniqueUser;
use Symfony\Component\Validator\Constraints as Assert;

class CustomerCreateModel 
{
    #[Assert\NotBlank()]
    public $code;

    #[Assert\NotBlank()]
    #[UniqueUser()]
    public $username;
    
    #[Assert\NotBlank()]
    #[Assert\Email()]
    public $email;
    
    #[Assert\NotBlank()]
    public $type;
    
    #[Assert\NotBlank()]
    public $firstname;
    
    #[Assert\NotBlank()]
    public $lastname;
    
    #[Assert\NotBlank()]
    public $password;
}