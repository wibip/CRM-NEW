<?php
require_once __DIR__.'/../../controller/Controller.php';
require_once __DIR__.'/../../classes/dbClass.php';
class view_default {

    protected $layout_dir;
    protected $controller;
    private $db;

    function __construct(Controller $controller)
    {
        $this->controller = $controller;
        $this->db = new db_functions();
    }

    protected function bind($str,array $args){
        return strtr($str,$args);
    }

    public final function getView(array $tabList, array $data){

        $pageContent="";
        $tabHeader="";
        $alertContent="";

        $count=0;
        foreach ($tabList as $key => $value){
            $TabData = [
                '{$ID}'=>$key,
                '{$NAME}'=>$value['name'],
                '{$CONTENT_DIV_ID}'=>$key.'_container'
            ];

            if($count==0 && $this->controller->getActiveTab() === null){
                $tabHeader.= $this->tabHeaderActive($TabData);
            }elseif ($this->controller->getActiveTab()==$key){
                $tabHeader.= $this->tabHeaderActive($TabData);
            }else{
                $tabHeader.= $this->tabHeaderInactive($TabData);
            }

            require_once $this->layout_dir.'/contents/'.$key.'.php';
            $tabOb = new $key($this->controller,$this);

            if(!$tabOb instanceof interfaceContent)
                continue;

            $tabContent=$tabOb->getContent();


            $args = [
                '{$CONTENT}'=>$tabContent,
                '{$ID}'=>$key.'_container'
            ];

            if($count==0 && $this->controller->getActiveTab() === null){
                $pageContent.=$this->containerActive($args);
            }elseif ($this->controller->getActiveTab()==$key){
                $pageContent.=$this->containerActive($args);
            }else{
                $pageContent.=$this->containerInactive($args);
            }

            $alert_key = $key.'_alert';
            if(isset($_SESSION[$alert_key]))
            {
                switch ($_SESSION[$alert_key]["type"]){
                    case 1:{
                        $msg = $this->alertSuccess([
                            '{$TEXT}'=>$_SESSION[$alert_key]["massage"]
                        ]);
                        break;
                    }
                    case 0:{
                        $msg = $this->alertDanger([
                            '{$TEXT}'=>$_SESSION[$alert_key]["massage"]
                        ]);
                        break;
                    }
                }
                $alertContent.= $msg;
                unset($_SESSION[$alert_key]);
            }

            $count++;
        }


        $frame =  $this->main([
            '{$TITLE}'=>$data["mainTitle"],
            '{$TAB_LIST}'=>$tabHeader,
            '{$TAB_CONTENTS}'=>$pageContent,
            '{ALERT}'=>$alertContent
        ]);

        return $frame;
    }

    public final function addValidation($validation){
        array_push($this->form->validators,$validation);
    }

    public function validationScript(){

        $e = '<script type="text/javascript">
		$(document).ready(function() {
			//create user form validation
			$(\'#edit_profile\').bootstrapValidator({
				framework: \'bootstrap\',
				excluded: \':disabled\',
				feedbackIcons: {
					valid: \'glyphicon glyphicon-ok\',
					invalid: \'glyphicon glyphicon-remove\',
					validating: \'glyphicon glyphicon-refresh\'
				},
				fields: {{$FIELDS}})}); </script>';
    }

    public function fieldValidation($field_name,array $validators){

        $validators_str = "";

        foreach ($validators as $value){
            $validators_str.=$this->db->validateField($value).",";
        }

        $validators_str = trim($validators_str,",");

        $e = $field_name.': {
					excluded: false,
                    validators: {
                    '.$validators_str.'
                     }
                    }';

        return $e;
    }

    public function jsScript($args){
        $e = '<script type="text/javascript">{$SCRIPT}</script>';
        return $this->bind($e,$args);
    }

    public function main(array $args){

        $frame = '<div class="main">
                        <div class="main-inner">
                            <div class="container">
                                <div class="row">
                                    <div class="span12">
                                        <div class="widget">
                                            <div class="widget-header">
                                                <h3>{$TITLE}</h3>                            
                                            </div><!-- /widget-header -->
                                            <div class="widget-content">
                                                <div class="tabbable">
                                                    <ul class="nav nav-tabs">
                                                        {$TAB_LIST}
                                                    </ul>
                                                    <div class="tab-content">
                                                        {ALERT}
                                                        {$TAB_CONTENTS}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';

        return $this->bind($frame,$args);
    }

    public function alertSuccess($args){
        $e = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>{$TEXT}</strong></div>';
        return $this->bind($e,$args);
    }

    public function alertDanger($args){
        $e = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button><strong>{$TEXT}</strong></div>';
        return $this->bind($e,$args);
    }

    public function containerActive($args){
        $e = '<div class="tab-pane active" id="{$ID}">{$CONTENT}</div>';
        return $this->bind($e,$args);
    }

    public function containerInactive(array $args){
        $e = '<div class="tab-pane" id="{$ID}">{$CONTENT}</div>';
        return $this->bind($e,$args);
    }

    public function tabHeaderActive(array $args){
        $e = '<li class="{$CLASS} ms-hover active"><a href="#{$CONTENT_DIV_ID}" id="{$ID}" data-toggle="tab">{$NAME}</a></li>';
        return $this->bind($e,$args);
    }

    public function tabHeaderInactive(array $args){
        $e = '<li class="{$CLASS} ms-hover"><a href="#{$CONTENT_DIV_ID}" id="{$ID}" data-toggle="tab">{$NAME}</a></li>';
        return $this->bind($e,$args);
    }

    public function form(array $args){
        $e =  '<form id="{$ID}" name="{$NAME}" class="form-horizontal " method="{$METHOD}" autocomplete="off" action="{$ACTION}">
												<fieldset>{$FIELDS}</fieldset></form>';

        return $this->bind($e,$args);
    }

    public function confirm(array $args){
        $e = '<script type="text/javascript">
                $(document).ready(function() {
                $(\'#{$ID}\').easyconfirm({locale: {
                        title: \'{$TITLE}\',
                        text: \'{$MESSAGE}\',
                        button: [\'Cancel\',\' Confirm\'],
                        closeText: \'close\'
                         }});
                    $(\'#{$ID}\').click(function() {
                        window.location = "{$URL}"
                    });
                    });
                </script>';

        return $this->bind($e,$args);
    }

    public function formField(array $args){
        $e = '<div class=" control-group">
                        <label class="control-label" for="radiobtns">{$LABEL}</label>
                            <div class="controls form-group">

                                
                                    {$INPUT}
                                

                            </div>

                            <!-- /controls -->

                        </div>';

        return $this->bind($e,$args);
    }

    public function select(array $args){
        $e = '<select class="span4 form-control " id="{$ID}" name="{$NAME}" >
                    {$OPTIONS}
                    </select>';
        return $this->bind($e,$args);
    }

    public function multiSelect(array $args){
        $e = '<select class="span4 form-control " id="{$ID}" name="{$NAME}[]" multiple="multiple" >
                    {$OPTIONS}
                    </select>';
        $script = '$(document).ready(function () {
            $(\'#{$ID}\').multiSelect();
            }
		);';
        $e.=$this->jsScript([
            '{$SCRIPT}'=>$script
        ]);
        return $this->bind($e,$args);
    }

    public function selectOption(array $args){
        $e = '<option value="{$VALUE}">{$NAME}</option>';
        return $this->bind($e,$args);
    }
    public function selectOptionSelected(array $args){
        $e = '<option selected value="{$VALUE}">{$NAME}</option>';
        return $this->bind($e,$args);
    }

    public function textInput(array $args){

        if(!array_key_exists('{$VALUE}',$args))
            $args['{$VALUE}']='';

        $e = '<input type="text" class="span5" id="{$ID}" name="{$NAME}"  autocomplete="off" value="{$VALUE}" >';
        return $this->bind($e,$args);
    }

    public function formAction(array $args){
        $e='<div class="form-actions">{$ELEMENT}</div>';
        return $this->bind($e,$args);
    }

    public function buttonPrimary(array $args){

        $e = '<button type="submit" name="{$NAME}" id="{$ID}" class="btn btn-primary" value="{$VALUE}">{$TEXT}</button>';
        return $this->bind($e,$args);
    }

    public function buttonDanger(array $args){
        $e = '<button type="submit" name="{$NAME}" id="{$ID}" class="btn btn-danger">{$TEXT}</button>';
        return $this->bind($e,$args);
    }

    public function table(array $args){
        $e = '<div class="widget widget-table action-table">
                                                <div class="widget-header">
                                                    <!-- <i class="icon-th-list"></i> -->
                                                    <h3>{$TITLE}</h3>
                                                </div>

                                                <div class="widget-content table_response" id="{$ID}" style="width: 930px;">


                                                    <div style="overflow-x:auto;">
                                                        <table class="table table-striped table-bordered">
                                                            <thead><tr>{$HEADERS}<tr></thead>
                                                            <tbody>{$BODY}</tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>';

        return $this->bind($e,$args);
    }

    public function tableHeaders(array $args){
        $e = '<th>{$TEXT}</th>';
        return $this->bind($e,$args);
    }

    public function tableData(array $args){
        $e = '<td>{$TEXT}</td>';
        return $this->bind($e,$args);
    }


}
