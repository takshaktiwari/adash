<?php

namespace App\View\Components\Admin\Btns;

use Illuminate\View\Component;

class ActionDelete extends Component
{
    public function __construct(public $url, public $permission = null, public $size = 'sm', public $color = 'danger', public $text = null)
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.admin.btns.action-delete');
    }
}
