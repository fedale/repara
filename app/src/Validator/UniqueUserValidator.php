<?php

namespace App\Validator;

use App\Repository\Customer\CustomerRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueUserValidator extends ConstraintValidator
{
    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }
    public function validate($value, Constraint $constraint)
    {
        
        $existingCustomer = $this->customerRepository->findOneBy(['username' => $value]);

        if (!$existingCustomer) {
            return;
        }

        /* @var App\Validator\UniqueUser $constraint */
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
