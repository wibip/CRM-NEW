<?php
//require_once dirname(__FILE__).'/model/logObject.php';
interface log_interface { 

    public function createLog_VSZ(vsz_logs $getData);
    public function getLogs_VSZ(vsz_logs $getData);
    public function readLog_VSZ($id);

    public function createLog_AAA(aaa_logs $getData);
    public function getLogs_AAA(aaa_logs $getData);
    public function readLog_AAA($id);

    public function createLog_SESSION(session_logs $getData);
    public function getLogs_SESSION(session_logs $getData);
    public function readLog_SESSION($id);

    public function createLog_AUTH(auth_logs $getData);
    public function getLogs_AUTH(auth_logs $getData);
    public function readLog_AUTH($id);

    public function createLog_USER(user_logs $getData);
    public function getLogs_USER(user_logs $getData);
    public function readLog_USER($id);

    public function createLog_REDIRECTION(redirection_logs $getData);
    public function getLogs_REDIRECTION(redirection_logs $getData);
    public function readLog_REDIRECTION($id);

    public function createLog_DSF(dsf_logs $getData);
    public function getLogs_DSF(dsf_logs $getData);
    public function readLog_DSF($id);

    public function createLog_TECH(tech_tool_logs $getData);
    public function getLogs_TECH(tech_tool_logs $getData);
    public function readLog_TECH($id);

    public function createLog_FIRWALL(firwall_logs $getData);
    public function getLogs_FIRWALL(firwall_logs $getData);
    public function readLog_FIRWALL($id);

}

