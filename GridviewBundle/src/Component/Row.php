<?php 
namespace Fedale\GridviewBundle\Component;

use Doctrine\Common\Collections\ArrayCollection;

class Row
{
    public ArrayCollection $data; 

    public ArrayCollection $htmlOptions;

    public function __construct(
    ) {
        $this->data = new ArrayCollection();
        $this->htmlOptions = new ArrayCollection();
    }

    public function getKey(string $key) {
        return $this->data[$key];
    }
}