<?php 

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait EnableTrait
{
    #[ORM\Column()]
    private ?bool $enable = true;

    /**
     * Get the value of enable
     *
     * @return ?bool
     */
    public function getEnable(): ?bool
    {
        return $this->enable;
    }

    /**
     * Set the value of enable
     *
     * @param ?bool $enable
     *
     * @return self
     */
    public function setEnable(?bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }

    
    /**
     * Check if enable is true
     *
     * @return bool
     */
    public function isEnable(): bool
    {
        return $this->enable ?? false;
    }

}