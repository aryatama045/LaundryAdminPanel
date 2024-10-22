<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PermissionInput extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $name, $title, $permission, $permissions;
    public function __construct($title, $user, $name, $permission)
    {
        $this->title = $title;
        $this->name = $name;
        $this->permissions = $user->getPermissionNames()->toArray();
        $this->permission = $permission;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.permission-input');
    }
}
