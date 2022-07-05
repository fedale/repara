<?php

namespace App\Factory\Customer;

use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerProfile;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


/**
 * @extends ModelFactory<Customer>
 *
 * @method static Customer|Proxy createOne(array $attributes = [])
 * @method static Customer[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Customer|Proxy find(object|array|mixed $criteria)
 * @method static Customer|Proxy findOrCreate(array $attributes)
 * @method static Customer|Proxy first(string $sortedField = 'id')
 * @method static Customer|Proxy last(string $sortedField = 'id')
 * @method static Customer|Proxy random(array $attributes = [])
 * @method static Customer|Proxy randomOrCreate(array $attributes = [])
 * @method static Customer[]|Proxy[] all()
 * @method static Customer[]|Proxy[] findBy(array $attributes)
 * @method static Customer[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Customer[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method Customer|Proxy create(array|callable $attributes = [])
 */
final class CustomerFactory extends ModelFactory
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
            'code' => self::faker()->ean8(),
            'username' => self::faker()->userName(),
            'email' => self::faker()->companyEmail(),
            'password' => self::faker()->password(),
            //'type' => self::faker()->randomNumber(1, 4),
            'active' => self::faker()->boolean(90),
            'createdAt' => self::faker()->dateTimeBetween('-3 years', '-1 month'), // TODO add DATETIME ORM type manually
            'updatedAt' => self::faker()->dateTimeBetween('-1 month', 'now'),
     //       'profile' => CustomerProfileFactory::new()
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            ->afterPersist( function(Customer $customer, array $attributes) {
                $profile = CustomerProfileFactory::createOne(['customer' => $customer]);
                $customer->setProfile($profile);
            });
        /*
            ->afterInstantiate(function(Customer $customer) {
            $customer->setPassword($this->passwordHasher->hashPassword($customer, $customer->getPassword()));
        }) */
        ;
        
    }

    protected static function getClass(): string
    {
        return Customer::class;
    }
}
