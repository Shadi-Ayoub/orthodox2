<?php
namespace Libraries\Services\Breadcrumbs;

class Breadcrumbs {

    private $items = array();

    public function __construct() {
    }

    public function add($item, $url = ''){
        $this->items[$item] = $url;
    }

    public function render($divider = '/') {
        $str = '<nav id= "breadcrumbs-bar" style="--bs-breadcrumb-divider: \'' . $divider . '\';" aria-label="breadcrumb">' . '<ol class="breadcrumb">';
        
        foreach($this->items as $item => $url) {
            if(trim($url) == '') {
                $str .= '<li class="breadcrumb-item active" aria-current="page"><span class="active-item-text">' . $item . '</span></li>';
            }
            else {
                $str .= '<li class="breadcrumb-item"><a href="' . $url . '">' . $item . '</a></li>';
            }
        }
        
        $str .= '</ol></nav>';

        return $str;
    }
}