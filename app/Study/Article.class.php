<?php

namespace App\Study;
use \App\SQL;

class Article Extends SQL  {

    Public $id;
    Public $CODE;
    Public $LABEL;
    Public $IND;
    Public $PRESTATION_ID;
    Public $FAMILLE_ID;
    Public $ACHETER;
    Public $PRIX_ACHETER;
    Public $VENDU;
    Public $PRIX_VENDU;
    Public $UNITE_ID;
    Public $MATIERE;
    Public $EP;
    Public $DIM_X;
    Public $DIM_Y;
    Public $DIM_Z;
    Public $POIDS;
    Public $SUR_X;
    Public $SUR_Y;
    Public $SUR_Z;
    Public $COMMENT;
    Public $IMAGE;
    Public $UNIT_LABEL;
    Public $PRESTATION_LABEL;
    Public $TYPE;
    Public $FAMILLE_LABEL;

    Public $ArticleList;

    public function GETArticle($id_GET){

        $Article = $this->GetQuery('SELECT '. TABLE_ERP_ARTICLE .'.id,
                                            '. TABLE_ERP_ARTICLE .'.CODE,
                                            '. TABLE_ERP_ARTICLE .'.LABEL,
                                            '. TABLE_ERP_ARTICLE .'.IND,
                                            '. TABLE_ERP_ARTICLE .'.PRESTATION_ID,
                                            '. TABLE_ERP_ARTICLE .'.FAMILLE_ID,
                                            '. TABLE_ERP_ARTICLE .'.ACHETER,
                                            '. TABLE_ERP_ARTICLE .'.PRIX_ACHETER,
                                            '. TABLE_ERP_ARTICLE .'.VENDU,
                                            '. TABLE_ERP_ARTICLE .'.PRIX_VENDU,
                                            '. TABLE_ERP_ARTICLE .'.UNITE_ID,
                                            '. TABLE_ERP_ARTICLE .'.MATIERE,
                                            '. TABLE_ERP_ARTICLE .'.EP,
                                            '. TABLE_ERP_ARTICLE .'.DIM_X,
                                            '. TABLE_ERP_ARTICLE .'.DIM_Y,
                                            '. TABLE_ERP_ARTICLE .'.DIM_Z,
                                            '. TABLE_ERP_ARTICLE .'.POIDS,
                                            '. TABLE_ERP_ARTICLE .'.SUR_X,
                                            '. TABLE_ERP_ARTICLE .'.SUR_Y,
                                            '. TABLE_ERP_ARTICLE .'.SUR_Z,
                                            '. TABLE_ERP_ARTICLE .'.COMMENT,
                                            '. TABLE_ERP_ARTICLE .'.IMAGE,
                                            '. TABLE_ERP_UNIT .'.LABEL AS UNIT_LABEL,
                                            '. TABLE_ERP_PRESTATION .'.LABEL AS PRESTATION_LABEL,
                                            '. TABLE_ERP_PRESTATION .'.TYPE,
                                            '. TABLE_ERP_SOUS_FAMILLE .'.LABEL AS FAMILLE_LABEL
                                            FROM '. TABLE_ERP_ARTICLE .'
                                                LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. TABLE_ERP_ARTICLE .'`.`UNITE_ID` = `'. TABLE_ERP_UNIT .'`.`id`
                                                LEFT JOIN `'. TABLE_ERP_PRESTATION .'` ON `'. TABLE_ERP_ARTICLE .'`.`PRESTATION_ID` = `'. TABLE_ERP_PRESTATION .'`.`id`
                                                LEFT JOIN `'. TABLE_ERP_SOUS_FAMILLE .'` ON `'. TABLE_ERP_ARTICLE .'`.`FAMILLE_ID` = `'. TABLE_ERP_SOUS_FAMILLE .'`.`id`
                                            WHERE '. TABLE_ERP_ARTICLE .'.ID = \''. 	addslashes($id_GET) .'\'', true, 'App\Study\Article');
        return $Article;
    }

    public function GETTechnicalCut($id_GET){
        $TechnicalCut = $this->GetQuery('SELECT '. TABLE_ERP_DEC_TECH .'.Id,
                                                '. TABLE_ERP_DEC_TECH .'.ORDRE,
                                                '. TABLE_ERP_DEC_TECH .'.PRESTA_ID,
                                                '. TABLE_ERP_DEC_TECH .'.LABEL,
                                                '. TABLE_ERP_DEC_TECH .'.TPS_PREP,
                                                '. TABLE_ERP_DEC_TECH .'.TPS_PRO,
                                                '. TABLE_ERP_PRESTATION .'.LABEL AS PRESTA_LABEL
                                                FROM `'. TABLE_ERP_DEC_TECH .'`
                                                    LEFT JOIN `'. TABLE_ERP_PRESTATION .'` ON `'. TABLE_ERP_DEC_TECH .'`.`PRESTA_ID` = `'. TABLE_ERP_PRESTATION .'`.`id`
                                                WHERE '. TABLE_ERP_DEC_TECH .'.ARTICLE_ID = \''. addslashes($id_GET) .'\'
                                                    ORDER BY '. TABLE_ERP_DEC_TECH .'.ORDRE');
         return $TechnicalCut;
    }

    public function GETNomenclature($id_GET){
        $GETNomenclature = $this->GetQuery('SELECT '. TABLE_ERP_NOMENCLATURE .'.Id,
                                                    '. TABLE_ERP_NOMENCLATURE .'.ORDRE,
                                                    '. TABLE_ERP_NOMENCLATURE .'.PARENT_ID,
                                                    '. TABLE_ERP_NOMENCLATURE .'.ARTICLE_ID,
                                                    '. TABLE_ERP_NOMENCLATURE .'.LABEL,
                                                    '. TABLE_ERP_NOMENCLATURE .'.QT,
                                                    '. TABLE_ERP_NOMENCLATURE .'.UNIT_ID,
                                                    '. TABLE_ERP_NOMENCLATURE .'.PRIX_U,
                                                    '. TABLE_ERP_NOMENCLATURE .'.PRIX_ACHAT	,
                                                    '. TABLE_ERP_ARTICLE .'.LABEL AS ARTICLE_LABEL,
                                                    '. TABLE_ERP_UNIT .'.LABEL AS UNIT_LABEL
                                                    FROM `'. TABLE_ERP_NOMENCLATURE .'`
                                                        LEFT JOIN `'. TABLE_ERP_ARTICLE .'` ON `'. TABLE_ERP_NOMENCLATURE .'`.`ARTICLE_ID` = `'. TABLE_ERP_ARTICLE .'`.`id`
                                                        LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. TABLE_ERP_NOMENCLATURE .'`.`UNIT_ID` = `'. TABLE_ERP_UNIT .'`.`id`
                                                    WHERE '. TABLE_ERP_NOMENCLATURE .'.PARENT_ID = \''.  addslashes($id_GET) .'\'
                                                        ORDER BY '. TABLE_ERP_NOMENCLATURE .'.ORDRE');
         return $GETNomenclature;
    }

    public function GETSubAssembly($id_GET){
            $GETSubAssembly = $this->GetQuery('SELECT '. TABLE_ERP_SOUS_ENSEMBLE .'.id,
                                                    '. TABLE_ERP_SOUS_ENSEMBLE .'.PARENT_ID,
                                                    '. TABLE_ERP_SOUS_ENSEMBLE .'.ORDRE,
                                                    '. TABLE_ERP_SOUS_ENSEMBLE .'.ARTICLE_ID,
                                                    '. TABLE_ERP_SOUS_ENSEMBLE .'.QT,
                                                    '. TABLE_ERP_ARTICLE .'.LABEL AS LABEL_ARTICLE
                                                    FROM `'. TABLE_ERP_SOUS_ENSEMBLE .'`
                                                        LEFT JOIN `'. TABLE_ERP_ARTICLE .'` ON `'. TABLE_ERP_SOUS_ENSEMBLE .'`.`ARTICLE_ID` = `'. TABLE_ERP_ARTICLE .'`.`id`
                                                    WHERE '. TABLE_ERP_SOUS_ENSEMBLE .'.PARENT_ID = \''. addslashes($id_GET) .'\'
                                                        ORDER BY '. TABLE_ERP_SOUS_ENSEMBLE .'.ORDRE');
         return $GETSubAssembly;
    }


    public function GETArticleList($IdData=0){

        $this->ArticleList ='<option value="0">Aucune</option>';
        $query='SELECT Id, CODE, LABEL   FROM '. TABLE_ERP_ARTICLE .'';
		foreach ($this->GetQuery($query) as $data){
           
			$this->ArticleList .='<option value="'. $data->Id .'" '. selected($IdData, $data->Id) .'>'. $data->LABEL .'</option>';
		}
        
        return  $this->ArticleList;
    }
}
