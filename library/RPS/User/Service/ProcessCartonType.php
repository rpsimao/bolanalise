<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 03/04/14
 * Time: 16:42
 */

class RPS_User_Service_ProcessCartonType {


    public static function Luso($type, $job)
    {

        $optimus = new Application_Model_Optimus();
        $job     = $optimus->getJob($job);

        $jobType = $job[0]['j_type'];
        $jobCust = $job[0]['j_customer'];


       if ($jobType == "06 F NORMA" && $type == "GC2" && $jobCust == "LUSOMEDICA")
       {
           return "GC2 ROCHCOAT";
       }

        else if ($jobType == "06 F NORMA" && $type == "GC1" && $jobCust == "LUSOMEDICA")
        {
            return "GC1 ROCHBLANC";
        }

        else {

            return $type;
        }


    }

} 