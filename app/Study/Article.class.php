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

        $Article = $this->GetQuery('SELECT '. TABLE_ERP_STANDARD_ARTICLE .'.id,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.CODE,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.LABEL,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.IND,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.PRESTATION_ID,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.FAMILLE_ID,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.ACHETER,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.PRIX_ACHETER,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.VENDU,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.PRIX_VENDU,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.UNITE_ID,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.MATIERE,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.EP,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.DIM_X,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.DIM_Y,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.DIM_Z,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.POIDS,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.SUR_X,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.SUR_Y,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.SUR_Z,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.COMMENT,
                                            '. TABLE_ERP_STANDARD_ARTICLE .'.IMAGE,
                                            '. TABLE_ERP_UNIT .'.LABEL AS UNIT_LABEL,
                                            '. TABLE_ERP_PRESTATION .'.LABEL AS PRESTATION_LABEL,
                                            '. TABLE_ERP_PRESTATION .'.TYPE,
                                            '. TABLE_ERP_SOUS_FAMILLE .'.LABEL AS FAMILLE_LABEL
                                            FROM '. TABLE_ERP_STANDARD_ARTICLE .'
                                                LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. TABLE_ERP_STANDARD_ARTICLE .'`.`UNITE_ID` = `'. TABLE_ERP_UNIT .'`.`id`
                                                LEFT JOIN `'. TABLE_ERP_PRESTATION .'` ON `'. TABLE_ERP_STANDARD_ARTICLE .'`.`PRESTATION_ID` = `'. TABLE_ERP_PRESTATION .'`.`id`
                                                LEFT JOIN `'. TABLE_ERP_SOUS_FAMILLE .'` ON `'. TABLE_ERP_STANDARD_ARTICLE .'`.`FAMILLE_ID` = `'. TABLE_ERP_SOUS_FAMILLE .'`.`id`
                                            WHERE '. TABLE_ERP_STANDARD_ARTICLE .'.ID = \''. 	addslashes($id_GET) .'\'', true, 'App\Study\Article');
        return $Article;
    }

    public function GETArticleCount($ID = null, $Clause = null){
        
        if($ID != null){
            $Clause = 'WHERE id = \''. $ID .'\'';
        }

        $ArticleCount = $this->GetCount(TABLE_ERP_STANDARD_ARTICLE,'id', $Clause);
        return $ArticleCount;
    }

    public function GETTechnicalCut($id_GET){
        $TechnicalCut = $this->GetQuery('SELECT '. TABLE_ERP_STANDARD_TECH_CUT .'.Id,
                                                '. TABLE_ERP_STANDARD_TECH_CUT .'.ORDRE,
                                                '. TABLE_ERP_STANDARD_TECH_CUT .'.PRESTA_ID,
                                                '. TABLE_ERP_STANDARD_TECH_CUT .'.LABEL,
                                                '. TABLE_ERP_STANDARD_TECH_CUT .'.TPS_PREP,
                                                '. TABLE_ERP_STANDARD_TECH_CUT .'.TPS_PRO,
                                                '. TABLE_ERP_PRESTATION .'.LABEL AS PRESTA_LABEL
                                                FROM `'. TABLE_ERP_STANDARD_TECH_CUT .'`
                                                    LEFT JOIN `'. TABLE_ERP_PRESTATION .'` ON `'. TABLE_ERP_STANDARD_TECH_CUT .'`.`PRESTA_ID` = `'. TABLE_ERP_PRESTATION .'`.`id`
                                                WHERE '. TABLE_ERP_STANDARD_TECH_CUT .'.ARTICLE_ID = \''. addslashes($id_GET) .'\'
                                                    ORDER BY '. TABLE_ERP_STANDARD_TECH_CUT .'.ORDRE');
         return $TechnicalCut;
    }

    public function GETNomenclature($id_GET){
        $GETNomenclature = $this->GetQuery('SELECT '. TABLE_ERP_STANDARD_NOMENCLATURE .'.Id,
                                                    '. TABLE_ERP_STANDARD_NOMENCLATURE .'.ORDRE,
                                                    '. TABLE_ERP_STANDARD_NOMENCLATURE .'.PARENT_ID,
                                                    '. TABLE_ERP_STANDARD_NOMENCLATURE .'.ARTICLE_ID,
                                                    '. TABLE_ERP_STANDARD_NOMENCLATURE .'.LABEL,
                                                    '. TABLE_ERP_STANDARD_NOMENCLATURE .'.QT,
                                                    '. TABLE_ERP_STANDARD_NOMENCLATURE .'.UNIT_ID,
                                                    '. TABLE_ERP_STANDARD_NOMENCLATURE .'.PRIX_U,
                                                    '. TABLE_ERP_STANDARD_NOMENCLATURE .'.PRIX_ACHAT	,
                                                    '. TABLE_ERP_STANDARD_ARTICLE .'.LABEL AS ARTICLE_LABEL,
                                                    '. TABLE_ERP_UNIT .'.LABEL AS UNIT_LABEL
                                                    FROM `'. TABLE_ERP_STANDARD_NOMENCLATURE .'`
                                                        LEFT JOIN `'. TABLE_ERP_STANDARD_ARTICLE .'` ON `'. TABLE_ERP_STANDARD_NOMENCLATURE .'`.`ARTICLE_ID` = `'. TABLE_ERP_STANDARD_ARTICLE .'`.`id`
                                                        LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. TABLE_ERP_STANDARD_NOMENCLATURE .'`.`UNIT_ID` = `'. TABLE_ERP_UNIT .'`.`id`
                                                    WHERE '. TABLE_ERP_STANDARD_NOMENCLATURE .'.PARENT_ID = \''.  addslashes($id_GET) .'\'
                                                        ORDER BY '. TABLE_ERP_STANDARD_NOMENCLATURE .'.ORDRE');
         return $GETNomenclature;
    }

    public function GETSubAssembly($id_GET){
        
            $GETSubAssembly = $this->GetQuery('SELECT '. TABLE_ERP_STANDARD_SUB_ASSEMBLY .'.id,
                                                    '. TABLE_ERP_STANDARD_SUB_ASSEMBLY .'.PARENT_ID,
                                                    '. TABLE_ERP_STANDARD_SUB_ASSEMBLY .'.ORDRE,
                                                    '. TABLE_ERP_STANDARD_SUB_ASSEMBLY .'.ARTICLE_ID,
                                                    '. TABLE_ERP_STANDARD_SUB_ASSEMBLY .'.QT,
                                                    '. TABLE_ERP_STANDARD_ARTICLE .'.LABEL AS LABEL_ARTICLE
                                                    FROM `'. TABLE_ERP_STANDARD_SUB_ASSEMBLY .'`
                                                        LEFT JOIN `'. TABLE_ERP_STANDARD_ARTICLE .'` ON `'. TABLE_ERP_STANDARD_SUB_ASSEMBLY .'`.`ARTICLE_ID` = `'. TABLE_ERP_STANDARD_ARTICLE .'`.`id`
                                                    WHERE '. TABLE_ERP_STANDARD_SUB_ASSEMBLY .'.PARENT_ID = \''. addslashes($id_GET) .'\'
                                                        ORDER BY '. TABLE_ERP_STANDARD_SUB_ASSEMBLY .'.ORDRE');

         return $GETSubAssembly;
    }


    public function GETArticleList($IdData=0){

        $this->ArticleList ='';
        $query='SELECT Id, CODE, LABEL   FROM '. TABLE_ERP_STANDARD_ARTICLE .'';
		foreach ($this->GetQuery($query) as $data){
           
			$this->ArticleList .='<option value="'. $data->Id .'" '. selected($IdData, $data->Id) .'>'. $data->LABEL .'</option>';
		}
        
        return  $this->ArticleList;
    }
}


class ArticleTreeStructure Extends Article  {

    Public $level = 1;

    public function GetTreeStructure($parent_id) {

        if(Article::GETSubAssembly($parent_id)!=NULL)
        {
            foreach(Article::GETSubAssembly($parent_id) as $data)
            {
                echo '<li><span><a href="index.php?page=article&id='. $data->ARTICLE_ID .'">'.  $data->LABEL_ARTICLE .' </a>x '.  $data->QT .'- parent : '. $parent_id .'</span> 
                             <ul>';
      
                    // SECOND RANK PART TECHNICAL CUT
                    foreach (Article::GETTechnicalCut($data->ARTICLE_ID) as $dataTechnicalCutRank2){

                         $TpsTotal = $dataTechnicalCutRank2->TPS_PREP + $dataTechnicalCutRank2->TPS_PRO; 
                         echo '<li>'. $TpsTotal .' hrs - '. $dataTechnicalCutRank2->PRESTA_LABEL .'</li>';
                     }

                    // SECONDE RANK PART NOMENCLATURE
                    foreach (Article::GETNomenclature($data->ARTICLE_ID) as $dataNomenclatureRank2){  

                          echo '<li> '. $dataNomenclatureRank2->QT  .' '. $dataNomenclatureRank2->UNIT_LABEL  .' - '. $dataNomenclatureRank2->ARTICLE_LABEL .'</li>';
                    }

                $this->level = $this->level+1;

                //Recursive suite
                $this->GetTreeStructure($data->ARTICLE_ID);
              
            }
        }
        else{
            $Endloop = 1;
            while ($Endloop < $this->level):
                    echo '</ul>';
                echo '</li>';
                $Endloop++;
            endwhile;
            $this->level=1;
        }  
    }
}
