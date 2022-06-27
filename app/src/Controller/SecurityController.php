<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractDashboardController
{
    #[Route(path: '/login', name: 'admin_login')]
    public function login(AuthenticationUtils $authenticationUtils) : Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('admin/pages/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
            // the 'name' HTML attribute of the <input> used for the username field (default: '_username')
            'username_parameter' => '_username',
            // the 'name' HTML attribute of the <input> used for the password field (default: '_password')
            'password_parameter' => '_password',
            'forgot_password_enabled' => false,
            'remember_me_enabled' => true,
           ]);
    }

    #[Route(path: '/logout', name: 'admin_logout')]
    public function logout()
    {
        throw new \LoginException('This method cannot be blank');
    }
}