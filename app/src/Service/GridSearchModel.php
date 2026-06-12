<?php

namespace App\Service;

use Fedale\GridviewBundle\Form\SearchModel;

/**
 * Generic search model used to enable the gridview filter form.
 *
 * Its presence on a Gridview is what toggles filter registration and the
 * filter form view (see Gridview::setColumns()/renderGrid()); the actual
 * filtering logic lives in each entity repository's search() method.
 */
class GridSearchModel extends SearchModel
{
}
