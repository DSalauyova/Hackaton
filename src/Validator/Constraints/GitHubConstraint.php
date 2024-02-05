<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class GitHubConstraint extends Constraint
{
    public string $message = 'Veuillez saisir le lien git valable';

    public function validatedBy(): string
    {
        return 'App\Validator\Validator\GitHubConstraintValidator';
    }
}
