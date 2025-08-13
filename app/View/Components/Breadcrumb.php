<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public string $title;
    public string $home;
    public array $inactive;
    public string $active;

    /**
     * Create a new component instance.
     *
     * @param string $title
     * @param array $breadcrumb
     */
      public function __construct(string $title = 'Dashboard', array $breadcrumb = [])
    {
        $this->title = $title;
        $this->home = $breadcrumb['home'] ?? '#';
        $this->inactive = $breadcrumb['inactive'] ?? [];
        $this->active = $breadcrumb['active'] ?? '';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.breadcrumb');
    }
}
