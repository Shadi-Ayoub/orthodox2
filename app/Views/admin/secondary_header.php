<!-- Content Header (Page header) -->
<?= $breadcrumbs; ?>
<?php
    // $items = array();

    // add($items, lang('app.home'), site_url(''));
    // add($items, lang('app.dashboard'));
    // $breadcrumbsString = render($items);

    // echo $breadcrumbsString;

    // function add(&$items, $item, $url = ''){
    //     $items[$item] = $url;
    // }

    // function render(&$items, $divider = '/') {
    //     $str = '<nav id= "breadcrumbs-bar" style="--bs-breadcrumb-divider: \'' . $divider . '\';" aria-label="breadcrumb">' . '<ol class="breadcrumb">';
        
    //     foreach($items as $item => $url) {
    //         if(trim($url) == '') {
    //             $str .= '<li class="breadcrumb-item active" aria-current="page"><span class="active-item-text">' . $item . '</span></li>';
    //         }
    //         else {
    //             $str .= '<li class="breadcrumb-item"><a href="' . $url . '">' . $item . '</a></li>';
    //         }
    //     }
        
    //     $str .= '</ol></nav>';

    //     return $str;
    // }
?>