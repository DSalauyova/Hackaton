<?php

declare(strict_types=1);

namespace App\Validator\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class GitHubConstraintValidator extends ConstraintValidator
{
    //valeur a valider, objet contrainte associé
    public function validate($value, Constraint $constraint): void
    {
        // Vérifie si la valeur est null ou n'est pas une chaîne
        if (null === $value || !is_string($value)) {
            $this->context->buildViolation('La valeur fournie est invalide')->addViolation();
            return; // Sortie précoce si la valeur n'est pas une chaîne
        }
        // Vérifie si la valeur est un lien GitHub ou GitLab
        if (!$this->isGitHubOrGitLabLink($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }

    private function isGitHubOrGitLabLink($value): bool
    {

        // Expression régulière pour vérifier si le lien contient "github.com" ou "gitlab.com"
        // Cette expression assume que le lien pourrait commencer avec http://, https://, ou rien, et peut inclure www.
        $pattern = '/^(https?:\/\/)?(www\.)?(github\.com|gitlab\.com)/';

        // Utilise preg_match pour voir si la chaîne correspond au motif
        return preg_match($pattern, $value) === 1;
    }
}
