<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserFormSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::SUBMIT => 'onFormSubmit',
        ];
    }

    public function onFormSubmit(FormEvent $event): void
    {
        $user = $event->getData(); // La donnée du formulaire, qui est l'entité User
        $form = $event->getForm();

        if ($form->has('link_hub')) {
            $linkHubValue = $form->get('link_hub')->getData();
            // Ici, implémentez votre logique personnalisée pour traiter la valeur de link_hub
            // Par exemple, vous pourriez avoir une méthode sur votre entité qui permet de manipuler cette propriété indirectement
            // $user->updateLinkHub($linkHubValue);
        }
    }
}
