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
    private $myParam;

    public function __construct(String $myParam)
    {
        $this->myParam = $myParam;
    }

    #[Route(path: '/admin/setting', name: 'admin_setting')]
    public function indexAction(Config $config): Response
    {
        $container = new ContainerBuilder();
        // $superAdmin = $this->getParameter('superAdmin');
        $myParam  = $this->getParameter('myParam');
        $myBool = $this->getParameter('myBool');
        var_dump($myBool);
        dump($myParam, $this->myParam); die();
        // $var = $container->setParameter('superAdmin', 'myVa');
        return $this->render('setting/setting.html.twig', 
        [
            'config' => $config->all(),
            'superAdmin' => $superAdmin,
            'container' => $container,
        ]);
    }
}