<?php

namespace App\Planning;
use \App\SQL;

class Task Extends SQL  {


    Public $id;
    Public $ARTICLE_ID;
    Public $ORDRE;
    Public $PRESTA_ID;
    Public $LABEL;
    Public $TPS_PREP;
    Public $TPS_PRO;
    Public $COUT;
    Public $PRIX;
    Public $ETAT;
    Public $START_TIMESTAMPS;
    Public $END_START_TIMESTAMPS;
    
    public function GETask($id_GET){

    }

    public function GETListTask($id_GET, $Type = null, $week = null, $year = null){

        if($Type == "section"){
            $addLefJoint = 'LEFT JOIN `'. TABLE_ERP_RESSOURCE .'` ON '. TABLE_ERP_PRESTATION .'.id = '. TABLE_ERP_RESSOURCE .'.PRESTATION_ID
                            LEFT JOIN `'. TABLE_ERP_SECTION .'` ON '. TABLE_ERP_RESSOURCE .'.SECTION_ID = '. TABLE_ERP_SECTION .'.id
                            ';
            $AddWhere = TABLE_ERP_SECTION .'.id  = '. addslashes($id_GET) ;
            
        }
        elseif($Type == "resources"){
            $addLefJoint = 'LEFT JOIN `'. TABLE_ERP_RESSOURCE .'` ON '. TABLE_ERP_PRESTATION .'.id = '. TABLE_ERP_RESSOURCE .'.PRESTATION_ID';
            $AddWhere =  TABLE_ERP_RESSOURCE .'.id = '. addslashes($id_GET) ;
        }
        else{
            $addLefJoint = '';
            $AddWhere =  TABLE_ERP_ORDER_TECH_CUT .'.PRESTA_ID = '. addslashes($id_GET) ;
        }

        if($week != null){
            $AddWhere .= ' AND  FROM_UNIXTIME(`START_TIMESTAMPS`, \'%u\') =  '. addslashes($week) .' ';
        }

        

        $query='SELECT '. TABLE_ERP_ORDER_TECH_CUT .'.id,
                        '. TABLE_ERP_ORDER_TECH_CUT .'.ARTICLE_ID,
                        '. TABLE_ERP_ORDER_TECH_CUT .'.ORDRE,
                        '. TABLE_ERP_ORDER_TECH_CUT .'.PRESTA_ID,
                        '. TABLE_ERP_ORDER_TECH_CUT .'.LABEL,
                        '. TABLE_ERP_ORDER_TECH_CUT .'.TPS_PREP,
                        '. TABLE_ERP_ORDER_TECH_CUT .'.TPS_PRO,
                        '. TABLE_ERP_ORDER_TECH_CUT .'.COUT,
                        '. TABLE_ERP_ORDER_TECH_CUT .'.PRIX,
                        '. TABLE_ERP_ORDER_TECH_CUT .'.ETAT,
                        '. TABLE_ERP_ORDER_DATE_PLAN_TASK .'.START_TIMESTAMPS,
                        CAST(FROM_UNIXTIME('. TABLE_ERP_ORDER_DATE_PLAN_TASK .'.START_TIMESTAMPS) as date) as DATE_START_TIMESTAMPS,
                        CAST(FROM_UNIXTIME('. TABLE_ERP_ORDER_DATE_PLAN_TASK .'.END_START_TIMESTAMPS) as date) as DATE_END_START_TIMESTAMPS,
                        '. TABLE_ERP_ORDER_LIGNE .'.QT,
                        '. TABLE_ERP_ORDER_LIGNE .'.LABEL AS LABEL_ORDER_LINE,
                        '. TABLE_ERP_ORDER .'.CODE AS CODE_ORDER,
                        '. TABLE_ERP_PRESTATION .'.CODE,
                        '. TABLE_ERP_PRESTATION .'.ORDRE,
                        '. TABLE_ERP_PRESTATION .'.LABEL AS LABEL_SERVICE,
                        '. TABLE_ERP_PRESTATION .'.	COLOR
                    FROM '. TABLE_ERP_ORDER_TECH_CUT .' 
                         LEFT JOIN '. TABLE_ERP_ORDER_LIGNE .' ON '. TABLE_ERP_ORDER_TECH_CUT .'.ARTICLE_ID = '. TABLE_ERP_ORDER_LIGNE .'.id
                         LEFT JOIN '. TABLE_ERP_ORDER_DATE_PLAN_TASK .' ON '. TABLE_ERP_ORDER_TECH_CUT .'.id = '. TABLE_ERP_ORDER_DATE_PLAN_TASK .'.ORDER_TECHNICAL_CUT_ID	
                         LEFT JOIN '. TABLE_ERP_PRESTATION .' ON '. TABLE_ERP_ORDER_TECH_CUT .'.PRESTA_ID = '. TABLE_ERP_PRESTATION .'.id
                         '. $addLefJoint .'
                         LEFT JOIN '. TABLE_ERP_ORDER .' ON '. TABLE_ERP_ORDER_LIGNE .'.ORDER_ID = '. TABLE_ERP_ORDER .'.id
                    WHERE '. $AddWhere .' AND '. TABLE_ERP_ORDER_TECH_CUT .'.ETAT = 2
                        ORDER BY '. TABLE_ERP_ORDER_TECH_CUT .'.id ';

        return  $this->GetQuery($query);
    }

    public function GETWorkload($id_GET, $Type = null, $week = null, $year = null){

        $query='SELECT FROM_UNIXTIME(`START_TIMESTAMPS`, \'%u\') AS WEEK, 
                        SUM('. TABLE_ERP_ORDER_TECH_CUT .'.TPS_PREP + '. TABLE_ERP_ORDER_TECH_CUT .'.TPS_PRO * '. TABLE_ERP_ORDER_LIGNE .'.QT) AS WORKLOAD
                FROM '. TABLE_ERP_ORDER_TECH_CUT .' 
                  LEFT JOIN '. TABLE_ERP_ORDER_LIGNE .' ON '. TABLE_ERP_ORDER_TECH_CUT .'.ARTICLE_ID = '. TABLE_ERP_ORDER_LIGNE .'.id
                  LEFT JOIN '. TABLE_ERP_ORDER_DATE_PLAN_TASK .' ON '. TABLE_ERP_ORDER_TECH_CUT .'.id = '. TABLE_ERP_ORDER_DATE_PLAN_TASK .'.ORDER_TECHNICAL_CUT_ID
                  
                WHERE '. TABLE_ERP_ORDER_TECH_CUT .'.PRESTA_ID = '. addslashes($id_GET)  .' AND '. TABLE_ERP_ORDER_TECH_CUT .'.ETAT = 2
                GROUP BY FROM_UNIXTIME(`START_TIMESTAMPS`, \'%u\')';

                
        return  $this->GetQuery($query);
    }

}

