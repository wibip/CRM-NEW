<?php
class page {

    protected $tabs;
    protected $layout_dir;
    protected $data;
    private $view;

    public final function load(Controller $controller){

        require_once $this->layout_dir.'/../view.php';

        $this->view = new view($controller);

        echo $this->view->getView($this->tabs,$this->data);
    }

    public final function footer(){


    }


}