<?php

class RPS_User_Service_CheckPassword
{

    public function check($password)
    {
        
        $ck = new RPS_Validators_Initformpassword();
        $resp = $ck->isValid($password);
        
        return $resp;
        
    }
}

?>