<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Uppercase extends Constraint
{
    public $message = 'Le texte "{{ string }}" que vous essayez de saisir doit être en majuscule.';
}