<?php


include_once(__DIR__ . '/../../classes/dbClass.php');


class provisioning
{
    private $db;

    function __construct()
    {
        $this->db = new db_functions();
    }



    public function create($data)
    {

        $service_type = trim($data['service_type']);
        $setting = $data['setting'];
        $mno_id = $data['mno_id'];
        $user_name = $data['user_name'];



        $query = "INSERT INTO `exp_provisioning_setting` (`service_type`, `setting`, `mno_id`,  `create_date`, `create_user`, `last_update`) 
        VALUES ('$service_type', '$setting', '$mno_id',  NOW(), '$user_name',  NOW()) ";




        $exe = $this->db->execDB($query);

        if ($exe === true) {

            return true;
        } else {
            return false;
        }
    }

    public function update($data)
    {

        $service_type = trim($data['service_type']);
        $edit_service_id = $data['edit_service_id'];
        $setting = $data['setting'];
        $mno_id = $data['mno_id'];
        $user_name = $data['user_name'];



        $query = "UPDATE `exp_provisioning_setting` SET `service_type` = '$service_type' , `setting` = '$setting' WHERE `id` = '$edit_service_id'";



        $exe = $this->db->execDB($query);

        if ($exe === true) {

            return true;
        } else {
            return false;
        }
    }

    public function delete($service_id)
    {

        $query = "DELETE FROM `exp_provisioning_setting` WHERE `id` = '$service_id'";



        $exe = $this->db->execDB($query);

        if ($exe === true) {

            return true;
        } else {
            return false;
        }
    }


    public function getProvisiong_uniq($id)
    {
        $sql = "SELECT  * FROM `exp_provisioning_setting` WHERE `id`='$id' ";

        $data_array = $this->db->select1DB($sql);


        return $data_array;
    }

    public function getTable($secret, $mno_id)
    {
        $sql = "SELECT  * FROM `exp_provisioning_setting` WHERE `mno_id`='$mno_id' ";

        $query_results = $this->db->selectDB($sql);

        $tb_arr_data = [];

        foreach ($query_results['data'] as $row) {

            $tb_arr = [];
            $service_id = $row['id'];

            array_push($tb_arr, $row['service_type']);


            $a = '<a id="CM_' . $service_id . '"  class="btn btn-small btn-info td_btn_last"><i class="btn-icon-only icon-wrench"></i>Edit</a>';
            $a .= '<script type="text/javascript">
         
         $(\'#CM_' . $service_id . '\').easyconfirm({locale: {
             title: \'Edit Service Type\',
             text: \'Are you sure you want to edit this Service Type?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
             button: [\'Cancel\',\' Confirm\'],
             closeText: \'close\'
            }});
           $(\'#CM_' . $service_id . '\').click(function() {
             window.location = "?t=1&edid_service=1&token=' . $secret . '&service_id=' . $service_id . '"
           });
           
         </script></td>';

            array_push($tb_arr, $a);

            $b = '<a id="CMD_' . $service_id . '"  class="btn btn-small btn-info td_btn_last"><i class="btn-icon-only icon-wrench"></i>Delete</a>';
            $b .= '<script type="text/javascript">
         
         $(\'#CMD_' . $service_id . '\').easyconfirm({locale: {
             title: \'Delete Service Type\',
             text: \'Are you sure you want to delete this Service Type?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\',
             button: [\'Cancel\',\' Confirm\'],
             closeText: \'close\'
            }});
           $(\'#CMD_' . $service_id . '\').click(function() {
             window.location = "?t=1&delete_service=1&token=' . $secret . '&service_id=' . $service_id . '"
           });
           
         </script></td>';

            array_push($tb_arr, $b);
            array_push($tb_arr_data, $tb_arr);
        }


        return $tb_arr_data;
    }
}
