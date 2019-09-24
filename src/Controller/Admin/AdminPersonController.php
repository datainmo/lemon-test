<?php


namespace App\Controller\Admin;


use App\Entity\SearchPerson;
use App\Form\SearchPersonType;
use App\Repository\PersonRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * Class AdminPersonController
 * @package App\Controller\Admin
 */
class AdminPersonController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_person")
     * @param PersonRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PersonRepository $repository, PaginatorInterface $paginator, Request $request) : Response
    {
        $search = new SearchPerson();
        $form = $this->createForm(SearchPersonType::class, $search);


        $form->handleRequest($request);

        $persons = $repository->findAllByCountry($search);
        $pagination = $paginator->paginate(
            $persons,
            $request->query->getInt('page', 1),
            10
        );



        return $this->render('admin/person/index.html.twig', [
            'pagination' => $pagination,
            'form'       => $form->createView()
        ]);
    }

}