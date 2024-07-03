<?php 


namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueEntityField extends Constraint
{
    public $message = 'La valeur "{{ value }}" existe déjà.';
    public $entityClass;
    public $field;

    public function __construct($options = null)
    {
        parent::__construct($options);
        $this->entityClass = $options['entityClass'];
        $this->field = $options['field'];
    }

    public function getRequiredOptions(): array
    {
        return ['entityClass', 'field'];
    }
}
