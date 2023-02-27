<?php 
namespace Fedale\GridviewBundle\Column;

use Fedale\GridviewBundle\Gridview;
use \Closure;

class DataColumn extends AbstractColumn 
{
     /**
     * @var string|Closure|null an anonymous function or a string that is used to determine the value to display in the current column.
     *
     * If this is an anonymous function, it will be called for each row and the return value will be used as the value to
     * display for every data model. The signature of this function should be: `function ($data, $index, $column)`.
     * Where `$data` and `$index` refer to the model, key and index of the row currently being rendered
     * and `$column` is a reference to the [[DataColumn]] object.
     *
     * You may also set this property to a string representing the attribute name to be displayed in this column.
     * This can be used when the attribute to be displayed is different from the [[attribute]] that is used for
     * sorting and filtering.
     *
     * If this is not set, `$data[$attribute]` will be used to obtain the value, where `$attribute` is the value of [[attribute]].
     */
    public $value;

    public $filter;
    

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
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }

    public function render($model, $index)
    {
        $data = $model->data;
        if ($this->value !== null) {
            if (is_string($this->value)) {
                return $this->value;
            }
            
            $value =  call_user_func($this->value, $data, $index, $this);

            return $value;

        } elseif (strpos($this->attribute, '.')) {
            return $this->resolve($data, $this->attribute);
        } elseif ($this->attribute !== null) {
            return $data[$this->attribute];
        }
        
        return null;
    } 

    public function renderHeader($label): string
    {        
        if ($this->sortable) {
            $sort = $this->gridview->getDataProvider()->getSort();

            $sortAttribute = $sort->hasAttribute($this->label) ? $label : ($sort->hasAttribute($this->attribute)
                ? $this->attribute : null);

            if ($sortAttribute) {
                return $sort->createLink($sortAttribute, $this->gridview, ['label' => $label]);
            }
        }
        
        return $label;
    }

    // https://stackoverflow.com/questions/14704984/access-a-multidimensional-array-with-dot-notation
    private function resolve(array $a, $path, $default = null)
    {
      $current = $a;
      $p = strtok($path, '.');
    
      while ($p !== false) {
        if (!isset($current[$p])) {
          return $default;
        }
        $current = $current[$p];
        $p = strtok('.');
      }
    
      return $current;
    }

    public function setFilter($filter) {
        $this->filter = $filter;
    }
    
}