<?php 
namespace App\Grid\Column;

use App\Grid\Gridview;
use \Closure;
use Twig\Environment;
use Twig\TwigFilter;
use Twig\TwigFunction;

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
    

    public function __construct (
        private Gridview $gridview,
        private string $attribute,
        protected ?string $format = ColumnFormat::RAW_FORMAT, 
        protected ?string $label = null,
        protected ?array $options = [],
        
    ) { 
        if (is_null($this->label)) {
            $this->setLabel($attribute);
        }
    }

    public function render($data, $index)
    {
        if ($this->value !== null) {
            if (is_string($this->value)) {
                return $this->value;
            }
            
            $value =  call_user_func($this->value, $data, $index, $this);

            // return $value;


            $applyFilter = true;
            if ($applyFilter) {
                
                $value = $this->applyFilter($value, 'upper');
            }

            return $value;

        } elseif ($this->attribute !== null) {
            return $data[$this->attribute];
        }
        
        return null;
    }

    public function applyFilter($value, string $filterName, ...$filterArguments)
    {
        dump($this->twigFilter);
        $twigFilter = $this->gridview->getTwig()->getFilter($filterName);
        
        if (false === $twigFilter || null === $twigFilter) {
            return $value;
        }
        
        if ($twigFilter->needsEnvironment()) {
            $filteredValue = call_user_func($twigFilter->getCallable(), $this->gridview->getTwig(), $value);     
        } else {
            $filteredValue = call_user_func($twigFilter->getCallable(), $value);
        }
        
        
        return $filteredValue;
    }

    public function getLabelDELETE(): string
    {
        return $this->label;
    }


    
}