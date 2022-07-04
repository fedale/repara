<?php

namespace App\Factory\Customer;

use App\Entity\Customer\CustomerProfile;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


/**
 * @extends ModelFactory<CustomerProfile>
 *
 * @method static CustomerProfile|Proxy createOne(array $attributes = [])
 * @method static CustomerProfile[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static CustomerProfile|Proxy find(object|array|mixed $criteria)
 * @method static CustomerProfile|Proxy findOrCreate(array $attributes)
 * @method static CustomerProfile|Proxy first(string $sortedField = 'id')
 * @method static CustomerProfile|Proxy last(string $sortedField = 'id')
 * @method static CustomerProfile|Proxy random(array $attributes = [])
 * @method static CustomerProfile|Proxy randomOrCreate(array $attributes = [])
 * @method static CustomerProfile[]|Proxy[] all()
 * @method static CustomerProfile[]|Proxy[] findBy(array $attributes)
 * @method static CustomerProfile[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static CustomerProfile[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method CustomerProfile|Proxy create(array|callable $attributes = [])
 */
final class CustomerProfileFactory extends ModelFactory
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();

        $this->passwordHasher = $passwordHasher;
    }

    protected function getDefaults(): array
    {
        return [
            'firstname' => self::faker()->firstName(),
            'lastname' => self::faker()->lastName(),
            'website' => self::faker()->url(),
            'timezone' => self::faker()->timezone(),
            'customer' => CustomerFactory::new(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
        /*
            ->afterInstantiate(function(Customer $customer) {
            $customer->setPassword($this->passwordHasher->hashPassword($customer, $customer->getPassword()));
        }) */
        ;
        
    }

    protected static function getClass(): string
    {
        return CustomerProfile::class;
    }
}
