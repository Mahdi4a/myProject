<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Recaptcha extends Component
{
    public $token;

    public $hasError;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($hasError)
    {
        $this->hasError = $hasError;
        $this->token = env('GOOGLE_RECAPTCHA_SITE_KEY');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.recaptcha');
    }
}
