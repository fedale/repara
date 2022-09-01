<?php 
namespace App\Controller;

use App\Controller\Admin\WebsiteCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Craue\ConfigBundle\Util\Config;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MyController extends AbstractDashboardController
{
    #[Route(path: '/admin/setting', name: 'admin_setting')]
    public function indexAction(Config $config): Response
    {
        $container = new ContainerBuilder();
        $superAdmin = $container->getPa
        // $var = $container->setParameter('superAdmin', 'myVa');
        dd($superAdmin);
        return $this->render('setting/setting.html.twig', 
        [
            'config' => $config->all(),
            'superAdmin' => $this->getParameter('superAdmin'),
            'container' => $container,
        ]);
    }
}