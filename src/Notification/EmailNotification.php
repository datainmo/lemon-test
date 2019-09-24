<?php
/**
 * Created by PhpStorm.
 * User: MEHDI
 * Date: 28/05/2019
 * Time: 16:11
 */

namespace App\Notification;


use App\Entity\Person;
use App\Repository\ConfigurationRepository;
use App\Repository\UserRepository;
use Twig\Environment;

class EmailNotification
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $renderer;
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * EmailNotification constructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $renderer
     * @param ConfigurationRepository $repository
     */
    public function __construct(\Swift_Mailer $mailer, Environment $renderer, ConfigurationRepository $repository)
    {

        $this->mailer = $mailer;
        $this->renderer = $renderer;
        $this->repository = $repository;
    }

    /**
     * Envoi un email de confirmation lors d'une inscription, ainsi qu'une notification à l'administrateur
     * @param Person $person
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function notify(Person $person)
    {

        $messageInscrit = (new \Swift_Message('Confirmation d\'inscription'))
            ->setFrom(['noreply@lemon-intereactive.com' => 'Lemon Interactive'])
            ->setTo('contact@agence.fr')
            ->setReplyTo($person->getEmail())
            ->setBody($this->renderer->render('emails/inscrit.html.twig', [
                'person' => $person
            ]), 'text/html');

        $this->mailer->send($messageInscrit);

        $emailAdmin = $this->getAdminEmail();
        $messageAdmin = (new \Swift_Message('Nouvelle inscription'))
            ->setFrom(['noreply@lemon-intereactive.com' => 'Lemon Interactive'])
            ->setTo($emailAdmin)
            ->setReplyTo($emailAdmin)
            ->setBody($this->renderer->render('emails/admin.html.twig', [
                'person' => $person
            ]), 'text/html');

        $this->mailer->send($messageAdmin);

    }

    public function getAdminEmail()
    {
        $email = $this->repository->findBy(['name' => 'email_administrateur']);

        if(!$email){
            throw new \Exception("L'email de l'administrateur n'est pas renseigné dans la configuration");
        }
        else{
            $email = $email[0]->getValue();
        }

        return $email;
    }

}