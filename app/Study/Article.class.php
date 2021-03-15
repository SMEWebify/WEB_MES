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
        
        if($this-> GETArticleCount($id_GET) === 0){ header('Location: index.php?page=article'); }
       
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

    public function GETTechnicalCut($id_GET, $TechnicalCutTable){

        $AddSQL='';
        if($TechnicalCutTable == TABLE_ERP_ORDER_TECH_CUT){
            $AddSQL =TABLE_ERP_ORDER_TECH_CUT .".ETAT,";
        }

        $TechnicalCut = $this->GetQuery('SELECT '. $TechnicalCutTable .'.id,
                                                '. $TechnicalCutTable .'.ARTICLE_ID,
                                                '. $TechnicalCutTable .'.ORDRE,
                                                '. $TechnicalCutTable .'.PRESTA_ID,
                                                '. $TechnicalCutTable .'.LABEL,
                                                '. $TechnicalCutTable .'.TPS_PREP,
                                                '. $TechnicalCutTable .'.TPS_PRO,
                                                '. $TechnicalCutTable .'.COUT,
                                                '. $TechnicalCutTable .'.PRIX,
                                                '. $AddSQL .'
                                                '. TABLE_ERP_PRESTATION .'.CODE AS PRESTA_CODE,
                                                '. TABLE_ERP_PRESTATION .'.LABEL AS PRESTA_LABEL
                                                FROM `'. $TechnicalCutTable .'`
                                                    LEFT JOIN `'. TABLE_ERP_PRESTATION .'` ON `'. $TechnicalCutTable.'`.`PRESTA_ID` = `'. TABLE_ERP_PRESTATION .'`.`id`
                                                WHERE '. $TechnicalCutTable .'.ARTICLE_ID = \''. addslashes($id_GET) .'\'
                                                    ORDER BY '. $TechnicalCutTable .'.ORDRE');
         return $TechnicalCut;
    }

    public function GETNomenclature($id_GET, $NomenclatureTable ){

        $GETNomenclature = $this->GetQuery('SELECT '. $NomenclatureTable .'.id,
                                                    '. $NomenclatureTable .'.ORDRE,
                                                    '. $NomenclatureTable .'.PARENT_ID,
                                                    '. $NomenclatureTable .'.ARTICLE_ID,
                                                    '. $NomenclatureTable .'.LABEL,
                                                    '. $NomenclatureTable .'.QT,
                                                    '. $NomenclatureTable .'.UNIT_ID,
                                                    '. $NomenclatureTable .'.PRIX_U,
                                                    '. $NomenclatureTable .'.PRIX_ACHAT	,
                                                    '. TABLE_ERP_STANDARD_ARTICLE .'.LABEL AS ARTICLE_LABEL,
                                                    '. TABLE_ERP_UNIT .'.LABEL AS UNIT_LABEL
                                                    FROM `'. $NomenclatureTable .'`
                                                        LEFT JOIN `'. TABLE_ERP_STANDARD_ARTICLE .'` ON `'. $NomenclatureTable .'`.`ARTICLE_ID` = `'. TABLE_ERP_STANDARD_ARTICLE .'`.`id`
                                                        LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. $NomenclatureTable .'`.`UNIT_ID` = `'. TABLE_ERP_UNIT .'`.`id`
                                                    WHERE '. $NomenclatureTable .'.PARENT_ID = \''.  addslashes($id_GET) .'\'
                                                        ORDER BY '. $NomenclatureTable .'.ORDRE');
         return $GETNomenclature;
    }

    public function GETSubAssembly($id_GET, $SubAssemblesTable){
        
            $GETSubAssembly = $this->GetQuery('SELECT '. $SubAssemblesTable .'.id,
                                                    '. $SubAssemblesTable .'.PARENT_ID,
                                                    '. $SubAssemblesTable .'.ORDRE,
                                                    '. $SubAssemblesTable .'.ARTICLE_ID,
                                                    '. $SubAssemblesTable .'.QT,
                                                    '. TABLE_ERP_STANDARD_ARTICLE .'.LABEL AS LABEL_ARTICLE
                                                    FROM `'. $SubAssemblesTable .'`
                                                        LEFT JOIN `'. TABLE_ERP_STANDARD_ARTICLE .'` ON `'. $SubAssemblesTable .'`.`ARTICLE_ID` = `'. TABLE_ERP_STANDARD_ARTICLE .'`.`id`
                                                    WHERE '. $SubAssemblesTable .'.PARENT_ID = \''. addslashes($id_GET) .'\'
                                                        ORDER BY '. $SubAssemblesTable .'.ORDRE');

         return $GETSubAssembly;
    }


    public function GETArticleList($IdData=0, $Select = true){

        $this->ArticleList ='';
        $query='SELECT id, CODE, LABEL   FROM '. TABLE_ERP_STANDARD_ARTICLE .' ORDER BY LABEL';
        if($Select){
            foreach ($this->GetQuery($query) as $data){
            
                $this->ArticleList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->LABEL .'</option>';
            }
            
            return  $this->ArticleList;
            
        }else {
            return  $this->GetQuery($query);
        }  
    }
}


class ArticleTreeStructure Extends Article  {

    Public $level = 1;

    public function GetTreeStructure($parent_id, $type='study') {

        if(Article::GETSubAssembly($parent_id, TABLE_ERP_STANDARD_SUB_ASSEMBLY)!=NULL)
        {
            foreach(Article::GETSubAssembly($parent_id, TABLE_ERP_STANDARD_SUB_ASSEMBLY) as $data)
            {
                echo '<li><span> '.  $data->QT .' x <a href="index.php?page=article&id='. $data->ARTICLE_ID .'">'.  $data->LABEL_ARTICLE .' </a></span> 
                             <ul>';
      
                    // SECOND RANK PART TECHNICAL CUT
                    foreach (Article::GETTechnicalCut($data->ARTICLE_ID, TABLE_ERP_STANDARD_TECH_CUT) as $dataTechnicalCutRank2){

                         $TpsTotal = $dataTechnicalCutRank2->TPS_PREP + $dataTechnicalCutRank2->TPS_PRO; 
                         echo '<li>'. $TpsTotal .' hrs - '. $dataTechnicalCutRank2->PRESTA_LABEL .'</li>';
                     }

                    // SECONDE RANK PART NOMENCLATURE
                    foreach (Article::GETNomenclature($data->ARTICLE_ID, TABLE_ERP_STANDARD_NOMENCLATURE) as $dataNomenclatureRank2){  

                          echo '<li> '. $dataNomenclatureRank2->QT  .' '. $dataNomenclatureRank2->UNIT_LABEL  .' - '. $dataNomenclatureRank2->ARTICLE_LABEL .'</li>';
                    }

                $this->level = $this->level+1;

                //Recursive suite
                $this->GetTreeStructure($data->ARTICLE_ID, $type);
              
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
