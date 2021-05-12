<?php

namespace App\Planning;
use \App\SQL;

class Task Extends SQL  {

    Public $id;
    Public $LABEL;
    Public $ORDER;
    Public $QUOTE_LINE_ID;
    Public $CODE_QUOTE;
    Public $ORDER_LINE_ID;
    Public $CODE_ORDER;
    Public $SERVICE_ID;
    Public $LABEL_SERVICE;
    Public $COLOR_SERVICE;
    Public $COMPONENT_ID;
    Public $SETING_TIME;
    Public $UNIT_TIME;
    Public $REMAINING_TIME;
    Public $ADVANCEMENT;
    Public $ETAT;
    Public $TYPE;
    Public $DELAY; 
    Public $QTY;
    Public $QTY_INIT;
    Public $QTY_AVIABLE;
    Public $UNIT_COST;
    Public $UNIT_PRICE;
    Public $UNIT_ID;
    Public $X_SIZE;
    Public $Y_SIZE;
    Public $Z_SIZE;
    Public $X_OVERSIZE;
    Public $Y_OVERSIZE;
    Public $Z_OVERSIZE;
    Public $TO_SCHEDULE;
    Public $MATERIAL;
    Public $THICKNESS;
    Public $WEIGHT;
    Public $CREATOR_ID;
    Public $MODIFIED_ID;
    Public $NOM_CREATOR;
    Public $PRENOM_CREATOR;
    Public $NOM_MODIFIED;
    Public $PRENOM_MODIFIED;
    Public $MODIFIED;
    Public $QL_NFC_ID;
    Public $TOOL_ID;
    Public $START_TIMESTAMPS;
    Public $END_TIMESTAMPS;
    
    Public $TaskTableList;
    
    public function Addask($Id_Type, $UserID, $POST,  $Type , $Technicalcut , $BillOfmMaterial){

        if($Type == 'order'){
            $ColumType = 'ORDER_LINE_ID ';
            $Etat = 1;
        }elseif($Type == 'quote'){
            $ColumType = ' QUOTE_LINE_ID ';
            $Etat = 0;
        }elseif($Type == 'component'){
            $ColumType = ' COMPONENT_ID ';
            $Etat = 0;
        }

        $SERVICE = explode("-", $POST['AddSERVICE_ID']);

        if($Technicalcut == true){
            $ColumTitle =' `SETING_TIME`, `UNIT_TIME`, `ETAT`, `TYPE` , `UNIT_COST`, `UNIT_PRICE`';
            $ColumValue = "'". addslashes($POST['AddSETING_TIME']) ."','". addslashes($POST['AddUNIT_TIME']) ."','". $Etat ."','". addslashes($SERVICE[1]) ."','". addslashes($POST['AddUNIT_COST']) ."','". addslashes($POST['AddUNIT_PRICE']) ."'";
        }
        elseif($BillOfmMaterial == true){
            $ColumTitle =' 	`ARTICLE_ID`, `ETAT`, `TYPE` , `QTY`, `UNIT_COST`, `UNIT_PRICE`, `UNIT_ID`';
            $data = $this->GetQuery('SELECT  '. TABLE_ERP_STANDARD_ARTICLE .'.PRESTATION_ID, 
                                             '. TABLE_ERP_PRESTATION .'.TYPE
                                        FROM '. TABLE_ERP_STANDARD_ARTICLE .'  
                                            LEFT JOIN `'. TABLE_ERP_PRESTATION .'` ON `'. TABLE_ERP_STANDARD_ARTICLE .'`.`PRESTATION_ID` = `'. TABLE_ERP_PRESTATION .'`.`id`
                                        WHERE '. TABLE_ERP_STANDARD_ARTICLE .'.ID = \''. 	addslashes($POST['AddARTICLE_ID']) .'\'', true);
           
            $SERVICE = Array ($data->PRESTATION_ID, $data->TYPE);

            $ColumValue = "'".  addslashes($POST['AddARTICLE_ID']) ."','".  $Etat ."','". addslashes($SERVICE[1]) ."','". addslashes($POST['AddQTY']) ."','". addslashes($POST['AddUNIT_COST']) ."','". addslashes($POST['AddUNIT_PRICE']) ."','". addslashes($POST['AddUNIT_ID']) ."'";
        }

        $req = $this->GetInsert("INSERT INTO ". TABLE_ERP_TASK ." (`LABEL`, `ORDER`, ". $ColumType .", `SERVICE_ID`,  ". $ColumTitle .", `CREATOR_ID`)
                                                             VALUES 
                                                                (
                                                                    '". addslashes($POST['AddLABEL']) ."', 
                                                                    '". addslashes($POST['AddORDER']) ."',
                                                                    '". addslashes($Id_Type) ."',
                                                                    '". addslashes($SERVICE[0]) ."',
                                                                    ". $ColumValue .",
                                                                    '". $UserID ."'
                                                                )
                                                            ");
    }


    public function GETask($id_GET){

    }


    public function GETListTask($id_GET, $Type = null, $week = null, $TabeList = False){

        if($Type == "section"){
            $addLefJoint = 'LEFT JOIN `'. TABLE_ERP_RESSOURCE .'` ON '. TABLE_ERP_PRESTATION .'.id = '. TABLE_ERP_RESSOURCE .'.PRESTATION_ID
            LEFT OUTER JOIN `'. TABLE_ERP_SECTION .'` ON '. TABLE_ERP_RESSOURCE .'.SECTION_ID = '. TABLE_ERP_SECTION .'.id
                            ';
            $AddWhere = TABLE_ERP_SECTION .'.id  = '. addslashes($id_GET) .' AND ';
            
        }
        elseif($Type == "resources"){
            $addLefJoint = 'LEFT JOIN `'. TABLE_ERP_RESSOURCE .'` ON '. TABLE_ERP_PRESTATION .'.id = '. TABLE_ERP_RESSOURCE .'.PRESTATION_ID';
            $AddWhere =  TABLE_ERP_RESSOURCE .'.id = '. addslashes($id_GET) .' AND ';
        }
        elseif($Type == "service"){
            $addLefJoint = '';
            $AddWhere =  TABLE_ERP_TASK .'.SERVICE_ID = '. addslashes($id_GET) .' AND ';
        }
        else{
            $addLefJoint = '';
            $AddWhere =  '';
        }

        if($week != null){
            $AddWhere .= ' AND  FROM_UNIXTIME(`START_TIMESTAMPS`, \'%u\') =  '. addslashes($week) .' AND ';
        }

        

        $query='SELECT DISTINCT '. TABLE_ERP_TASK .'.id,
                        '. TABLE_ERP_TASK .'.ORDER_LINE_ID,
                        '. TABLE_ERP_TASK .'.ORDER,
                        '. TABLE_ERP_TASK .'.SERVICE_ID,
                        '. TABLE_ERP_TASK .'.LABEL,
                        '. TABLE_ERP_TASK .'.SETING_TIME,
                        '. TABLE_ERP_TASK .'.UNIT_TIME,
                        '. TABLE_ERP_TASK .'.UNIT_COST,
                        '. TABLE_ERP_TASK .'.UNIT_PRICE,
                        '. TABLE_ERP_TASK .'.ETAT,
                        '. TABLE_ERP_TASK .'.START_TIMESTAMPS,
                        CAST(FROM_UNIXTIME('. TABLE_ERP_TASK .'.START_TIMESTAMPS) as date) as DATE_START_TIMESTAMPS,
                        CAST(FROM_UNIXTIME('. TABLE_ERP_TASK .'.END_TIMESTAMPS) as date) as END_TIMESTAMPS,
                        '. TABLE_ERP_ORDER_LIGNE .'.QT,
                        '. TABLE_ERP_ORDER_LIGNE .'.LABEL AS LABEL_ORDER_LINE,
                        '. TABLE_ERP_ORDER .'.CODE AS CODE_ORDER,
                        '. TABLE_ERP_PRESTATION .'.CODE,
                        '. TABLE_ERP_PRESTATION .'.ORDRE,
                        '. TABLE_ERP_PRESTATION .'.LABEL AS LABEL_SERVICE,
                        '. TABLE_ERP_PRESTATION .'.COLOR
                    FROM '. TABLE_ERP_TASK .' 
                         LEFT JOIN '. TABLE_ERP_ORDER_LIGNE .' ON '. TABLE_ERP_TASK .'.ORDER_LINE_ID = '. TABLE_ERP_ORDER_LIGNE .'.id
                         LEFT JOIN '. TABLE_ERP_PRESTATION .' ON '. TABLE_ERP_TASK .'.SERVICE_ID = '. TABLE_ERP_PRESTATION .'.id
                         '. $addLefJoint .'
                         LEFT JOIN '. TABLE_ERP_ORDER .' ON '. TABLE_ERP_ORDER_LIGNE .'.ORDER_ID = '. TABLE_ERP_ORDER .'.id
                    WHERE '. $AddWhere .' '. TABLE_ERP_TASK .'.ETAT = 2
                        ORDER BY '. TABLE_ERP_TASK .'.id ';
        if($TabeList){
            
            foreach ($this->GetQuery($query) as $data){

                if(date('W', $data->START_TIMESTAMPS)<strftime("%W", time())) $color='red';
                else $color='green' ;
                $TaskTime = $data->SETING_TIME+$data->UNIT_TIME*$data->QT;
                
                $this->TaskTableList .= '
                                     <tr>
                                        <td style="background-color:'. $color .';">'. date('W', $data->START_TIMESTAMPS)  .'</td>
                                        <td>'. $data->DATE_START_TIMESTAMPS .'</td>
                                        <td>'. $data->END_TIMESTAMPS .'</td>
                                        <td><a href="index.php?page=planning&task='. $data->id .'">#'. $data->id .' - '. $data->CODE_ORDER .' - '. $data->LABEL_ORDER_LINE .' - '. $data->LABEL .' - '. $data->ORDER .'</a></td>
                                        <td>'. $TaskTime .'mn</td>	
                                        <td></td>
                                    </tr>';
            }

            return  $this->TaskTableList;

        }else {
                            
            return  $this->GetQuery($query);                
        }
    }

    public function GETWorkload($id_GET, $Type = null, $week = null, $year = null){

        $query='SELECT FROM_UNIXTIME(`START_TIMESTAMPS`, \'%u\') AS WEEK, 
                        SUM('. TABLE_ERP_TASK .'.SETING_TIME + '. TABLE_ERP_TASK .'.UNIT_TIME * '. TABLE_ERP_ORDER_LIGNE .'.QT) AS WORKLOAD
                FROM '. TABLE_ERP_TASK .' 
                  LEFT JOIN '. TABLE_ERP_ORDER_LIGNE .' ON '. TABLE_ERP_TASK .'.ARTICLE_ID = '. TABLE_ERP_ORDER_LIGNE .'.id
                WHERE '. TABLE_ERP_TASK .'.SERVICE_ID = '. addslashes($id_GET)  .' AND '. TABLE_ERP_TASK .'.ETAT = 2
                GROUP BY FROM_UNIXTIME(`START_TIMESTAMPS`, \'%u\')';

                
        return  $this->GetQuery($query);
    }

    public function GETTechnicalCut($id_GET, $type){

        $AddSQL='';
        if($type == 'order'){
            $AddSQL =TABLE_ERP_TASK .".ETAT,";
            $Clause = 'ORDER_LINE_ID ';
        }elseif($type == 'quote'){
            $Clause = 'QUOTE_LINE_ID ';
        }elseif($type == 'component'){
            $Clause = 'COMPONENT_ID ';
        }

        $TechnicalCut = $this->GetQuery('SELECT '. TABLE_ERP_TASK .'.id,
                                                '. TABLE_ERP_TASK .'.LABEL,
                                                '. TABLE_ERP_TASK .'.ORDER,
                                                '. TABLE_ERP_TASK .'.QUOTE_LINE_ID,
                                                '. TABLE_ERP_TASK .'.ORDER_LINE_ID,
                                                '. TABLE_ERP_TASK .'.SERVICE_ID,
                                                '. TABLE_ERP_TASK .'.COMPONENT_ID,
                                                '. TABLE_ERP_TASK .'.ARTICLE_ID,
                                                '. TABLE_ERP_TASK .'.SETING_TIME,
                                                '. TABLE_ERP_TASK .'.UNIT_TIME,
                                                '. TABLE_ERP_TASK .'.REMAINING_TIME,
                                                '. TABLE_ERP_TASK .'.ADVANCEMENT,
                                                '. $AddSQL .'
                                                '. TABLE_ERP_TASK .'.TYPE,
                                                '. TABLE_ERP_TASK .'.DELAY,
                                                '. TABLE_ERP_TASK .'.UNIT_COST,
                                                '. TABLE_ERP_TASK .'.UNIT_PRICE,
                                                '. TABLE_ERP_PRESTATION .'.CODE AS PRESTA_CODE,
                                                '. TABLE_ERP_PRESTATION .'.LABEL AS LABEL_SERVICE,
                                                '. TABLE_ERP_ORDER_LIGNE .'.QT,
                                                '. TABLE_ERP_ORDER_LIGNE .'.LABEL AS LABEL_ORDER_LINE,
                                                '. TABLE_ERP_ORDER .'.CODE AS CODE_ORDER
                                                FROM `'. TABLE_ERP_TASK .'`
                                                    LEFT JOIN `'. TABLE_ERP_PRESTATION .'` ON `'. TABLE_ERP_TASK .'`.`SERVICE_ID` = `'. TABLE_ERP_PRESTATION .'`.`id`
                                                    LEFT JOIN '. TABLE_ERP_ORDER_LIGNE .' ON '. TABLE_ERP_TASK .'.ORDER_LINE_ID = '. TABLE_ERP_ORDER_LIGNE .'.id
                                                    LEFT JOIN '. TABLE_ERP_ORDER .' ON '. TABLE_ERP_ORDER_LIGNE .'.ORDER_ID = '. TABLE_ERP_ORDER .'.id
                                                WHERE '. TABLE_ERP_TASK .'.'.  $Clause .' = \''. addslashes($id_GET) .'\' AND '. TABLE_ERP_TASK .'.TYPE IN (1,7)
                                                    ORDER BY '. TABLE_ERP_TASK .'.ORDER');

         return $TechnicalCut;
    }

    public function GETNomenclature($id_GET, $type ){

        if($type == 'order'){
            $AddSQL =TABLE_ERP_TASK .".ETAT,";
            $Clause = 'ORDER_LINE_ID ';
        }elseif($type == 'quote'){
            $Clause = 'QUOTE_LINE_ID ';
        }elseif($type == 'component'){
            $Clause = 'COMPONENT_ID ';
        }

        $GETNomenclature = $this->GetQuery('SELECT '. TABLE_ERP_TASK .'.id,
                                                    '. TABLE_ERP_TASK .'.LABEL,
                                                    '. TABLE_ERP_TASK .'.ORDER,
                                                    '. TABLE_ERP_TASK .'.QUOTE_LINE_ID,
                                                    '. TABLE_ERP_TASK .'.ORDER_LINE_ID,
                                                    '. TABLE_ERP_TASK .'.COMPONENT_ID,
                                                    '. TABLE_ERP_TASK .'.ARTICLE_ID,
                                                    '. $AddSQL .'
                                                    '. TABLE_ERP_TASK .'.TYPE,
                                                    '. TABLE_ERP_TASK .'.DELAY,
                                                    '. TABLE_ERP_TASK .'.UNIT_COST,
                                                    '. TABLE_ERP_TASK .'.UNIT_PRICE,
                                                    '. TABLE_ERP_TASK .'.QTY,
                                                    '. TABLE_ERP_TASK .'.QTY_INIT,
                                                    '. TABLE_ERP_TASK .'.QTY_AVIABLE,
                                                    '. TABLE_ERP_TASK .'.UNIT_ID,
                                                    '. TABLE_ERP_TASK .'.X_SIZE,
                                                    '. TABLE_ERP_TASK .'.Y_SIZE,
                                                    '. TABLE_ERP_TASK .'.Z_SIZE,
                                                    '. TABLE_ERP_TASK .'.X_OVERSIZE,
                                                    '. TABLE_ERP_TASK .'.Y_OVERSIZE,
                                                    '. TABLE_ERP_TASK .'.Z_OVERSIZE,
                                                    '. TABLE_ERP_TASK .'.MATERIAL,
                                                    '. TABLE_ERP_TASK .'.THICKNESS,
                                                    '. TABLE_ERP_TASK .'.WEIGHT,
                                                    '. TABLE_ERP_ORDER_LIGNE .'.LABEL AS LABEL_ORDER_LINE,
                                                    '. TABLE_ERP_ORDER .'.CODE AS CODE_ORDER,
                                                    '. TABLE_ERP_STANDARD_ARTICLE .'.LABEL AS ARTICLE_LABEL,
                                                    '. TABLE_ERP_UNIT .'.LABEL AS UNIT_LABEL
                                                    FROM `'. TABLE_ERP_TASK .'`
                                                    LEFT JOIN '. TABLE_ERP_ORDER_LIGNE .' ON '. TABLE_ERP_TASK .'.ORDER_LINE_ID = '. TABLE_ERP_ORDER_LIGNE .'.id
                                                        LEFT JOIN '. TABLE_ERP_ORDER .' ON '. TABLE_ERP_ORDER_LIGNE .'.ORDER_ID = '. TABLE_ERP_ORDER .'.id
                                                        LEFT JOIN '. TABLE_ERP_STANDARD_ARTICLE .' ON  '. TABLE_ERP_TASK .'.ARTICLE_ID = '. TABLE_ERP_STANDARD_ARTICLE .'.id
                                                        LEFT JOIN `'. TABLE_ERP_UNIT .'` ON '. TABLE_ERP_TASK .'.UNIT_ID = `'. TABLE_ERP_UNIT .'`.`id`
                                                    WHERE '. TABLE_ERP_TASK .'.'.  $Clause .' = \''. addslashes($id_GET) .'\' AND '. TABLE_ERP_TASK .'.TYPE IN (2,3,4,5,6,8)
                                                        ORDER BY '. TABLE_ERP_TASK .'.ORDER');
         return $GETNomenclature;
    }
}

