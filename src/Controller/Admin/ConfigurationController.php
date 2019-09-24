<?php


namespace App\Controller\Admin;


use App\Entity\Configuration;
use App\Form\ConfigurationType;
use App\Repository\ConfigurationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * Class ConfigurationController
 * @package App\Controller\Admin
 */
class ConfigurationController extends AbstractController
{
    /**
     * @var ConfigurationRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ConfigurationRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/configuration", name="app_admin_configuration_index")
     * @return Response
     */
    public function index(): Response
    {
        $configurations = $this->repository->findAll();

        return $this->render('admin/configuration/index.html.twig',[
            'configurations' => $configurations,

        ]);
    }

    /**
     * @Route("/configuration/{id}/update", name="app_admin_configuration_update")
     * @param Configuration $configuration
     * @param Request $request
     * @return Response
     */
    public function update(Configuration $configuration, Request $request): Response
    {
        $form = $this->createForm(ConfigurationType::class, $configuration);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $this->em->persist($configuration);
            $this->em->flush();
            $this->addFlash('success', 'La configuration a été modifiée');

        }

        return $this->render('admin/configuration/update.html.twig',[
            'form' => $form->createView(),

        ]);
    }

}