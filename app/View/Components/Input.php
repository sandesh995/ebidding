<?php

namespace App\View\Components;

use Illuminate\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public $clean_field = "";

    public function __construct(
        public $field,
        public $text,
        public $type = "text",
        public $current = "",
        public $required = false,
        public $old = true,
        public $error = true,
        public $margin = true,
        public $autofocus = false,
        public $key = "id",
        public $value = "name",
        public $empty = true,
        public $options = [],
        public $multiple = false,
    ) {
    }

    public function render(): View
    {
        // Remove backets of $key
        $this->clean_field = str_replace('[]', '', $this->field);

        return view('components.input');
    }
}
