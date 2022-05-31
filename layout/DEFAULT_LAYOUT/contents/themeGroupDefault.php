<?php
include_once __DIR__ . '/../interfaceContent.php';
include_once __DIR__.'/../../../controller/Group_Controller.php';
class themeGroupDefault implements interfaceContent{

    protected $HTML;
    public $modify_mode = false;
    protected $controller=null;

    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
    }

    public function getContent()
    {
        $content =  '<div class="header2_part1"><h2>'.ucwords(__THEME_TEXT__).' Groups</h2></div>
                        <p>You can group AP Groups and SSIDs into '.ucwords(__THEME_TEXT__).' Groups. A '.strtolower(__THEME_TEXT__).'
							groups can then be assigned to a specific '.strtolower(__THEME_TEXT__).' theme. Ex. A Business Center Theme</p>


											';

        $formField = $this->HTML->formField([
            '{$LABEL}'=>ucfirst(__THEME_TEXT__).' Group Name',
            '{$INPUT}'=>$this->HTML->textInput([
                '{$ID}'=>"theme_group",
                '{$NAME}'=>"theme_group",
                '{$VALUE}'=>$this->controller->editGroupTag?$this->controller->editgroupTagName:''
            ])
        ]);


        $ssid_list = $this->controller->getSSIDs();

        $options="<option disabled>SSID List</option>";
        foreach ($ssid_list as $value){
            if($value['selected']==1){
                $options.=$this->HTML->selectOptionSelected([
                    '{$VALUE}'=>$value['id'],
                    '{$NAME}'=>$value['ssid']
                ]);
            }else{
                $options.=$this->HTML->selectOption([
                    '{$VALUE}'=>$value['id'],
                    '{$NAME}'=>$value['ssid']
                ]);
            }

        }

        $formField.=$this->HTML->formField([
            '{$LABEL}'=>'SSIDs',
            '{$INPUT}'=>$this->HTML->multiSelect([
                '{$ID}'=>"ssid_list",
                '{$NAME}'=>"ssid_list",
                '{$OPTIONS}'=>$options
            ])
        ]);


        $ap_group_list = $this->controller->getSSIDFreeAPGroups();
//print_r($ap_group_list);
        $options="<option disabled>AP Group List</option>";
        foreach ($ap_group_list as $value){
            //$value = str_replace(':','',str_replace('-','',$value['mac_address']));
            if($value['selected']==1){
                $options.=$this->HTML->selectOptionSelected([
                    '{$VALUE}'=>$value['id'],
                    '{$NAME}'=>$value['name']
                ]);
            }else{
                $options.=$this->HTML->selectOption([
                    '{$VALUE}'=>$value['id'],
                    '{$NAME}'=>$value['name']
                ]);
            }
        }

        $formField.=$this->HTML->formField([
            '{$LABEL}'=>'AP Groups',
            '{$INPUT}'=>$this->HTML->multiSelect([
                '{$ID}'=>"ap_group_list",
                '{$NAME}'=>"ap_group_list",
                '{$OPTIONS}'=>$options
            ])
        ]);

        $form_action = $this->controller->editGroupTag?
            $this->HTML->buttonPrimary([
                '{$ID}'=>'update_theme_Group',
                '{$NAME}'=>'update_theme_Group',
                '{$TEXT}'=>'Update',
                '{$VALUE}'=>$this->controller->editgroupTagId
            ]):
            $this->HTML->buttonPrimary([
                '{$ID}'=>'submit_theme_Group',
                '{$NAME}'=>'submit_theme_Group',
                '{$TEXT}'=>'Save'
            ]);


        $formField.=$this->HTML->formAction([
            '{$ELEMENT}'=>$form_action
        ]);

        $content.=$this->HTML->form([
            '{$ID}'=>'theme_group_from',
            '{$NAME}'=>'theme_group_from',
            '{$METHOD}'=>'POST',
            '{$ACTION}'=>'?t=2',
            '{$FIELDS}'=>$formField,
        ]);

        $existing = $this->controller->getThemeGroups();

        $column = ["Theme Group","AP Group","SSID","Edit", "Remove"];
        $header = "";
        foreach ($column as $value){
            $header.=$this->HTML->tableHeaders(['{$TEXT}'=>$value]);
        }

        $body="";
        foreach ($existing as $value){
            $body.='<tr>'
                .$this->HTML->tableData(['{$TEXT}'=>$value['tag_name']])
                .$this->HTML->tableData(['{$TEXT}'=>$value['ap_group']])
                .$this->HTML->tableData(['{$TEXT}'=>$value['ssids']])
                .$this->HTML->tableData([
                    '{$TEXT}'=>$this->HTML->buttonPrimary([
                        '{$TEXT}'=>"Edit",
                        '{$ID}'=>"tbl_exists_group_tag_edit".$value['GTid'],
                        '{$NAME}'=>"tbl_exists_group_tag_edit".$value['GTid'],
                    ]).$this->HTML->confirm([
                            '{$ID}'=>"tbl_exists_group_tag_edit".$value['GTid'],
                            '{$TITLE}'=>"Edit ".__THEME_TEXT__." Group",
                            '{$MESSAGE}'=>"Are you sure you want to edit this group?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
                            '{$URL}'=>$this->controller->getGroupTagEditURL($value['GTid'])
                        ])
                ])
                .$this->HTML->tableData([
                    '{$TEXT}'=>$this->HTML->buttonDanger([
                        '{$TEXT}'=>"Remove",
                        '{$ID}'=>"tbl_exists_group_tag_delete".$value['GTid'],
                        '{$NAME}'=>"tbl_exists_group_tag_delete".$value['GTid']
                    ]).$this->HTML->confirm([
                            '{$ID}'=>"tbl_exists_group_tag_delete".$value['GTid'],
                            '{$TITLE}'=>"Remove ".__THEME_TEXT__." Group",
                            '{$MESSAGE}'=>"Are you sure you want to remove this group?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
                            '{$URL}'=>$this->controller->getGroupTagDeleteURL($value['GTid'])
                        ])
                ])
                .'</tr>';
        }

        $content.=$this->HTML->table([
            '{$TITLE}'=>"Existing AP Groups",
            '{$ID}'=>"tbl_exixts_ap_groups",
            '{$HEADERS}'=>$header,
            '{$BODY}'=>$body
        ]);

        return $content;

    }
}