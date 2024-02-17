<?php

namespace App\Controllers;


class CongregationsController extends AdminController {


    public function index() {

        $this->breadcrumbs->add(lang('app.home'), site_url(''));
        $this->breadcrumbs->add(lang('app.dashboard'), site_url('admin'));
        $this->breadcrumbs->add(lang('app.congregations_management'));
        // $this->breadcrumbs->add(lang('app.new_registration'));

        $data['breadcrumbs'] = $this->breadcrumbs->render();
        $data['content_title'] = "";


        // }
        return view("admin/congregations/index", $data);
    }
}