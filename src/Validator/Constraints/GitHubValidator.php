<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class GitHubValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        // Vérifie si la valeur est un lien GitHub ou GitLab
        if (!$this->isGitHubOrGitLabLink($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }

    private function isGitHubOrGitLabLink($url)
    {
        // vérifier avec regex (expr reg) si le lien commence par github.com ou gitlab.com
        return preg_match('/^(https?:\/\/)?(www\.)?(github\.com|gitlab\.com)/', $url) === 1;
    }
}
