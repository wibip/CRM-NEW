<?php

require_once 'dbClass.php';

class faq_functions
{

    private $unique_id;
    private $text;
    private $content;
    private $dist_code;
    private $order;
    private $create_user;

    public function setNewFaq($text,$content,$dist_code,$order,$create_user)
    {


        $this->unique_id = uniqid('faq');
        $this->text = mysql_real_escape_string($text);
        $this->content = mysql_real_escape_string($content);
        $this->dist_code = $dist_code;
        $this->order = $order;
        $this->create_user = $create_user;
    }

////////////INSERT FAQ//////////////////

    public function createFaq(){
        if(strlen($this->text)>0) {
            $sql = "INSERT INTO exp_faq(`unique_id`,`text`,`content`,`distributor_code`,`order`,`create_user`,`create_date`)
              VALUES('$this->unique_id','$this->text','$this->content','$this->dist_code','$this->order','$this->create_user',NOW())";

            $insrt_faq = mysql_query($sql);
            if ($insrt_faq) {
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }

    public function getMNOfaq($mno_code){
        $sql="SELECT * FROM exp_faq WHERE distributor_code='$mno_code'";

        $result=mysql_query($sql);
        $return_array=null;
        while ($row=mysql_fetch_assoc($result)){
            $return_array[$row['id']]=array('unique_id'=>$row['unique_id'],'text'=>$row['text'],'content'=>$row['content'],'order'=>$row['order'],'create_date'=>$row['create_date']);
        }

        return $return_array;
    }


    public function getFaqFromUniCode($unique_id,$distributor){
        $sql="SELECT id,`text`,content,`order` FROM exp_faq WHERE unique_id='$unique_id' AND distributor_code='$distributor'";

        $result=mysql_query($sql);
        $return_array=null;

        while ($row=mysql_fetch_assoc($result)){
            $return_array=array('id'=>$row['id'],'text'=>$row['text'],'content'=>$row['content'],'order'=>$row['order']);
        }
        return $return_array;
    }

    public function faqUpdate($unique_id,$distributor,$title,$content,$order){
        $title=mysql_real_escape_string($title);
        $content=mysql_real_escape_string($content);

        $sql="UPDATE exp_faq SET `text`='$title',content='$content',`order`='$order' WHERE unique_id='$unique_id' AND distributor_code='$distributor'";

        $result=mysql_query($sql);
        if(mysql_affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }


    public function deleteFaqFromUniCode($unique_id,$distributor){
        $sql="DELETE FROM exp_faq WHERE distributor_code='$distributor' AND unique_id='$unique_id'";

        mysql_query($sql);
        if(mysql_affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }

}

?>