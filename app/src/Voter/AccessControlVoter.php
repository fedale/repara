<?php 
namespace App\Voter;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\NullToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\HttpFoundation\RequestMatcher;
use Symfony\Component\Security\Core\Security;
use App\Entity\AccessControl;
use Symfony\Component\Security\Core\User\UserInterface;

class AccessControlVoter extends Voter
{
    private $em;
    private $security;
    private $superAdmin;
    private $anonymousAccess;
    
    
    public function __construct(EntityManagerInterface $em, Security $security, string $superAdmin, bool $anonymousAccess)
    {
        $this->em = $em;
        $this->security = $security;
        $this->superAdmin = $superAdmin;
        $this->anonymousAccess = $anonymousAccess;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        return true;
    }
    
    public function vote(TokenInterface $token, $request, array $attributes): int
    {      
        
        if ( !$request instanceof Request ) {
                return self::ACCESS_ABSTAIN;
        }

        if ( $token instanceof NullToken && $this->anonymousAccess ) {             
                return self::ACCESS_GRANTED;
            
        } else {
            # User is authenticated
            # Does user have SuperPowers? Then, pass without ask.
            if ( $this->security->isGranted($this->superAdmin)) {
                return self::ACCESS_GRANTED;
            } 

            // Get access rules from Repository 
            $rules = $this->em
                    ->getRepository(AccessControl::class)
                    ->findActive();
            
            foreach ( (array)$rules as $rule ) {
                
                $accessControl = new RequestMatcher($rule->getPath(), $rule->getHost(), $rule->getMethods(), $rule->getIps());  

                if ( $accessControl->matches($request) ) {

                    foreach ( (array)$rule->getRoles() as $role ) {
                        if ( $this->security->isGranted($role) ) {
                            return self::ACCESS_GRANTED;
                        }
                    }

                    return self::ACCESS_ABSTAIN;
                }
            }
        }

        return self::ACCESS_DENIED;       
    }
}