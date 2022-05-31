<?php
include_once __DIR__ . '/../interfaceContent.php';
include_once __DIR__.'/../../../controller/Group_Controller.php';
class apGroupDefault implements interfaceContent{

    protected $HTML;
    public $modify_mode = false;
    protected $controller=null;


    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
    }

    public function getContent()
    {
        $content =  '<div class="header2_part1"><h2>AP Groups</h2></div>
                        <p>You can arrange your properties APs into groups to allow fro them to be assigned a specific '.ucwords(__THEME_TEXT__).', and
							and optional only display a specific set of SSID names.</p>


											';


        $formField = $this->HTML->formField([
            '{$LABEL}'=>'AP Group Name',
            '{$INPUT}'=>$this->HTML->textInput([
                '{$ID}'=>"ap_group",
                '{$NAME}'=>"ap_group",
                '{$VALUE}'=>$this->controller->editAPGorup?$this->controller->editAPGroupName:''
            ])
        ]);




        $ap_list = $this->controller->getGroupFreeAPs();

        $options="<option disabled>AP List</option>";
        foreach ($ap_list as $value){
            //$value = str_replace(':','',str_replace('-','',$value['mac_address']));
            $options.= $this->HTML->selectOption([
                '{$VALUE}'=>$value['id'],
                '{$NAME}'=>$value['ap_description'].'/'.$value['mac_address']
            ]); //'<option value="'.$value['id'].'">'.$value['ap_description'].' '.$value['mac_address'].'</option>';
        }
        if($this->controller->editAPGorup){
            foreach ($this->controller->editAPs AS $id=> $value){

                $options.= $this->HTML->selectOptionSelected([
                    '{$VALUE}'=>$id,
                    '{$NAME}'=>$value[0].'/'.$value[1]
                ]);
            }
        }

        $formField.=$this->HTML->formField([
            '{$LABEL}'=>'APs',
            '{$INPUT}'=>$this->HTML->multiSelect([
                '{$ID}'=>"ap_list",
                '{$NAME}'=>"ap_list",
                '{$OPTIONS}'=>$options
            ])
        ]);

        if($this->controller->editAPGorup) {
            $formField .= $this->HTML->formAction([
                        '{$ELEMENT}' => $this->HTML->buttonPrimary([
                        '{$ID}' => 'update_ap_Group',
                        '{$NAME}' => 'update_ap_Group',
                        '{$TEXT}' => 'Update',
                        '{$VALUE}'=>$this->controller->editAPGroupID
                ])
            ]);
        }else{
            $formField .= $this->HTML->formAction([
                '{$ELEMENT}' => $this->HTML->buttonPrimary([
                    '{$ID}' => 'submit_ap_Group',
                    '{$NAME}' => 'submit_ap_Group',
                    '{$TEXT}' => 'Save'
                ])
            ]);
        }

        $content.=$this->HTML->form([
            '{$ID}'=>'ap_group_from',
            '{$NAME}'=>'ap_group_from',
            '{$METHOD}'=>'POST',
            '{$ACTION}'=>'?t=1',
            '{$FIELDS}'=>$formField,
        ]);

        $existing = $this->controller->getAPGroups();

        $column = ["AP Group","AP MAC(s)","Edit", "Remove"];
        $header = "";
        foreach ($column as $value){
            $header.=$this->HTML->tableHeaders(['{$TEXT}'=>$value]);
        }

        $body="";
        foreach ($existing as $value){
            $body.='<tr>'
                .$this->HTML->tableData(['{$TEXT}'=>$value['name']])
                .$this->HTML->tableData(['{$TEXT}'=>$value['macs']])
                .$this->HTML->tableData([
                    '{$TEXT}'=>$this->HTML->buttonPrimary([
                        '{$TEXT}'=>"Edit",
                        '{$ID}'=>"tbl_exists_ap_groups_edit".$value['id']
                    ]).$this->HTML->confirm([
                            '{$ID}'=>"tbl_exists_ap_groups_edit".$value['id'],
                            '{$TITLE}'=>"Create AP Group",
                            '{$MESSAGE}'=>"Are you sure you want to create this group?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
                            '{$URL}'=>$this->controller->getAPGroupEditURL($value['id'])
                        ])
                ])
                .$this->HTML->tableData([
                    '{$TEXT}'=>$this->HTML->buttonDanger([
                        '{$TEXT}'=>"Remove",
                        '{$ID}'=>"tbl_exists_ap_groups_remove".$value['id'],
                        '{$NAME}'=>"tbl_exists_ap_groups_remove".$value['id']
                    ]).$this->HTML->confirm([
                            '{$ID}'=>"tbl_exists_ap_groups_remove".$value['id'],
                            '{$TITLE}'=>"Remove AP Group",
                            '{$MESSAGE}'=>"Are you sure you want to remove this group?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",
                            '{$URL}'=>$this->controller->getAPGroupDeleteURL($value['id'])
                        ])
                ])
                .'</tr>';
        }

        $content.=$this->HTML->table([
            '{$TITLE}'=>"Existing AP Groups",
            '{$ID}'=>"tbl_exists_ap_groups",
            '{$HEADERS}'=>$header,
            '{$BODY}'=>$body
        ]);


        return $content;

    }


}