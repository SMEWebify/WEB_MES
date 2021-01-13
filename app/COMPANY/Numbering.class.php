<?php

namespace App\COMPANY;
use \App\SQL;

class Numbering Extends SQL {

    Public $LastIncrementNumber;
    Public $CODE;

  public function getCodeNumbering($type='0', $sql ='', $model ='' , $digit = 0, $index = 0)
  {
      if(!empty($sql)){
            $data=$this->GetQuery($sql, true);
            $Index= $data->max_id+1;
            $Digit = $digit;
            $Model = $model;
      }
      elseif(!empty($type)){
            //we find num sequence for number quoting
            $query='SELECT '. TABLE_ERP_NUM_DOC .'.id,
                        '. TABLE_ERP_NUM_DOC .'.DOC_TYPE,
                        '. TABLE_ERP_NUM_DOC .'.MODEL,
                        '. TABLE_ERP_NUM_DOC .'.DIGIT,
                        '. TABLE_ERP_NUM_DOC .'.COMPTEUR
                        FROM `'. TABLE_ERP_NUM_DOC .'`
                        WHERE '. TABLE_ERP_NUM_DOC .'.DOC_TYPE=\''. $type  .'\'';
            $data = $this->GetQuery($query, true);
            $Index= $data->COMPTEUR+1;
            $Digit = $data->DIGIT;
            $Model = $data->MODEL;
           
      }else{
        $Index= $index;
        $Digit = $digit;
        $Model = $model;
      }

        $Index = str_pad($Index, $Digit , '0', STR_PAD_LEFT);
        $CODE = str_replace('<AAAA>', date("Y") ,$Model );
        $CODE = str_replace('<AA>', date("y") , $CODE);
        $CODE = str_replace('<MM>', date("m") , $CODE);
        $CODE = str_replace('<JJ>', date("d") , $CODE);
        $CODE = str_replace('<I>',$Index , $CODE);
       
        return  $CODE;
  }

  public function getIncrementNumbering($type='0')
  {
    $this->GetUpdate('UPDATE '. TABLE_ERP_NUM_DOC .' SET  COMPTEUR = COMPTEUR + 1 WHERE DOC_TYPE IN ('. $type  .')');
  }
}