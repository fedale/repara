<?php 
namespace Fedale\GridviewBundle\Column;

use Fedale\GridviewBundle\Grid\Gridview;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ActionColumn extends AbstractColumn {
    
    public $buttons = [];

    /**
     * Object to generate URLs
     */
    private UrlGeneratorInterface $urlGenerator;

    public function __construct (
        private Gridview $gridview,
        private string $attribute,
        protected ?string $twigFilter = null,
        protected ?string $label = null,
        protected ?array $options = [],
        
    ) { 
        if (null === $this->label) {
            $this->setLabel($attribute);
        }
        // Columns 'action' type is raw by default
        $this->setTwigfilter('raw');
        $this->initDefaultButtons();
    }

    public function setRouter(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }

    public function initColumn()
    {
        $this->label = 'Action';      
    }

    private function initDefaultButtons() {
        $this->initDefaultButton('view');
        $this->initDefaultButton('update');
        $this->initDefaultButton('delete');
    }

    private function initDefaultButton(string $name,  array $options = null) {

        // $link = $this->urlGenerator->generate('user_profile', [
        //     'username' => 'zitter',
        // ]);

        $this->buttons[$name] = '<a href="' . $name . '">' . $name . '</a>';
    }

    public function render($model, $index)
    {
        $content = '';
        foreach ($this->buttons as $button) {
            $content .=  $button;
        }

        return $content;
    }

    public function renderHeader($label): string
    {
        return 'renderHeader Label';
    }

}