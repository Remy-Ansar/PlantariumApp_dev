<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UppercaseValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if(null === $value || '' === $value) {
            return;
        }

        if (!ctype_upper($value)) {
            //la donnée saisie n'est pas en majuscule
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}',$value)
                ->addViolation();
        }
    }

}