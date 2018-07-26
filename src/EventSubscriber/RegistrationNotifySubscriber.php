<?php
// App\EventSubscriber\RegistrationNotifySubscriber.php
namespace App\EventSubscriber;

use App\Entity\User;
use App\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Envoi un mail de bienvenue à chaque creation d'un utilisateur
 *
 */
class RegistrationNotifySubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $sender;

    public function __construct(\Swift_Mailer $mailer, $sender)
    {
        // On injecte notre expediteur et la classe pour envoyer des mails
        $this->mailer = $mailer;
        $this->sender = $sender;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // le nom de l'event et le nom de la fonction qui sera déclenché
            Events::USER_REGISTERED => 'siUtilisateurInscription',
        ];
    }

    public function siUtilisateurInscription(GenericEvent $event): void
    {
        /** @var User $user */
        $user = $event->getSubject();

        $subject = "Bienvenue";
        $body = "Bonjour ".$user->getNomUtilisateur().",<br> Votre inscription est validé<br>Login : ".$user->getLoginUtilisateur();

        $message = (new \Swift_Message())
            ->setSubject($subject)
            ->setTo($user->getEmailUtilisateur())
            ->setFrom($this->sender)
            ->setBody($body, 'text/html')
        ;

        $this->mailer->send($message);
    }
}