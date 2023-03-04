<?php 
namespace Fedale\GridviewBundle\Component;

use Doctrine\Common\Collections\ArrayCollection;

class Row
{
    public array $data = []; 

    public array $htmlOptions = [];

    public string $prefixKey = 'row_';

    public function __construct(int $key, int $total)
    {
        $i = $key + 1;
        $this->setHtmlOption('id', $this->prefixKey . (string) $i);
        
        

        if ($key == 0) {
            $this->setHtmlOption('class', 'first');
        } else if ($key == $total) {
            $this->setHtmlOption('class', 'last');
        } else {
            $this->setHtmlOption('class', 'middle');
        }

        if ($i % 2 == 0) {
            $this->setHtmlOption('class', 'even');
        } else {
            $this->setHtmlOption('class', 'odd');
        }
    }

    public function getKey(string $key) {
        return $this->data[$key];
    }

    // public function isFirst()
    // {
    //     $this->setHtmlOption('class', 'first');
    // }

    // public function isMiddle()
    // {
    //     $this->setHtmlOption('class', 'middle');
    // }

    // public function isLast()
    // {
    //     $this->setHtmlOption('class', 'last');
    // }

    public function setHtmlOption(string $key, string $value, $replace = false)
    {
        if (!isset($this->htmlOptions[$key])) {
            $this->htmlOptions[$key] = $value;
        } else {
            if ($replace) {
                $this->htmlOptions[$key] = $value;
            } else {
                $this->htmlOptions[$key] .= ' ' . $value;
            }
        }

        

        
    }
}