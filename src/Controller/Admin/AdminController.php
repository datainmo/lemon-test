<?php


namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * Class AdminController
 * @package App\Controller\Admin
 */
class AdminController extends AbstractController
{

    /**
     * @Route("/dashboard", name="app_admin_index")
     */
    public function index() : Response
    {
        return $this->render('admin/index.html.twig');
    }

}