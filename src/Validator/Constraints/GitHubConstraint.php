<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class GitHubConstraint extends Constraint
{
    public $message = 'Veuillez saisir le lien git valable';
}
