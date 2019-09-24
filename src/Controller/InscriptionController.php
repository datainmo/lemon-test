<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Notification\EmailNotification;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    /**
     * @Route("/", name="app_inscription_index", methods="GET|POST")
     * @param Request $request
     * @param ObjectManager $em
     * @param EmailNotification $notification
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index(Request $request, ObjectManager $em, EmailNotification $notification) : Response
    {
        $person = new Person();

        $country = $this->getLocationInfoByIp();


        if($country)
        {
            $person->setNationality($country);

        }

        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em->persist($person);
            //$em->flush();

            $notification->notify($person);

            $this->addFlash('success', 'L\'inscription a bien été faite. Vous allez recevoir un message de confirmation sur votre boite mail');
        }


        return $this->render('inscription/index.html.twig', [
            'person' => $person,
            'form' => $form->createView(),
        ]);
    }

    function getLocationInfoByIp(){

        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = @$_SERVER['REMOTE_ADDR'];
        $result  = array('country'=>'', 'city'=>'');

        if(filter_var($client, FILTER_VALIDATE_IP)){
            $ip = $client;
        }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $ip = $forward;
        }else{
            $ip = $remote;
        }
        //$ip ='2a01:e35:2e0a:8490:ccc8:97cd:524b:4f0e';

        $json = file_get_contents("http://ipinfo.io/{$ip}/geo");
        $details = json_decode($json, true);
        if(!isset($details['country'])){
            return false;
        }

        return $details['country'];

    }
}
