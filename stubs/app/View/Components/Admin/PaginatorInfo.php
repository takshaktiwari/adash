<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class PaginatorInfo extends Component
{
    public $items;
    public function __construct($items=[])
    {
        $this->items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.paginator-info');
    }
}
