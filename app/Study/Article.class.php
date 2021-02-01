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

        if($this-> GETArticleCount($id_GET) == 0){ header('Location: index.php?page=article'); }

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

    public function GETTechnicalCut($id_GET, $type='study'){

        if($type === 'quote') {$Table = TABLE_ERP_QUOTE_TECH_CUT;}
        elseif($type === 'order') {$Table = TABLE_ERP_ORDER_TECH_CUT;}
        else  {$Table = TABLE_ERP_STANDARD_TECH_CUT;}

        $TechnicalCut = $this->GetQuery('SELECT '. $Table .'.id,
                                                '. $Table .'.ORDRE,
                                                '. $Table .'.PRESTA_ID,
                                                '. $Table .'.LABEL,
                                                '. $Table .'.TPS_PREP,
                                                '. $Table .'.TPS_PRO,
                                                '. $Table .'.LABEL AS PRESTA_LABEL
                                                FROM `'. $Table .'`
                                                    LEFT JOIN `'. TABLE_ERP_PRESTATION .'` ON `'. $Table.'`.`PRESTA_ID` = `'. TABLE_ERP_PRESTATION .'`.`id`
                                                WHERE '. $Table .'.ARTICLE_ID = \''. addslashes($id_GET) .'\'
                                                    ORDER BY '. $Table .'.ORDRE');
         return $TechnicalCut;
    }

    public function GETNomenclature($id_GET, $type='study'){

        if($type === 'quote') {$Table = TABLE_ERP_QUOTE_NOMENCLATURE;}
        elseif($type === 'order') {$Table = TABLE_ERP_ORDER_NOMENCLATURE;}
        else  {$Table = TABLE_ERP_STANDARD_NOMENCLATURE;}

        $GETNomenclature = $this->GetQuery('SELECT '. $Table .'.id,
                                                    '. $Table .'.ORDRE,
                                                    '. $Table .'.PARENT_ID,
                                                    '. $Table .'.ARTICLE_ID,
                                                    '. $Table .'.LABEL,
                                                    '. $Table .'.QT,
                                                    '. $Table .'.UNIT_ID,
                                                    '. $Table .'.PRIX_U,
                                                    '. $Table .'.PRIX_ACHAT	,
                                                    '. TABLE_ERP_STANDARD_ARTICLE .'.LABEL AS ARTICLE_LABEL,
                                                    '. TABLE_ERP_UNIT .'.LABEL AS UNIT_LABEL
                                                    FROM `'. $Table .'`
                                                        LEFT JOIN `'. TABLE_ERP_STANDARD_ARTICLE .'` ON `'. $Table .'`.`ARTICLE_ID` = `'. TABLE_ERP_STANDARD_ARTICLE .'`.`id`
                                                        LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. $Table .'`.`UNIT_ID` = `'. TABLE_ERP_UNIT .'`.`id`
                                                    WHERE '. $Table .'.PARENT_ID = \''.  addslashes($id_GET) .'\'
                                                        ORDER BY '. $Table .'.ORDRE');
         return $GETNomenclature;
    }

    public function GETSubAssembly($id_GET, $type='study'){

        
        if($type === 'quote') {$Table = TABLE_ERP_QUOTE_SUB_ASSEMBLY;}
        elseif($type === 'order') {$Table = TABLE_ERP_ORDER_SUB_ASSEMBLY;}
        else  {$Table = TABLE_ERP_STANDARD_SUB_ASSEMBLY;}
        
            $GETSubAssembly = $this->GetQuery('SELECT '. $Table .'.id,
                                                    '. $Table .'.PARENT_ID,
                                                    '. $Table .'.ORDRE,
                                                    '. $Table .'.ARTICLE_ID,
                                                    '. $Table .'.QT,
                                                    '. TABLE_ERP_STANDARD_ARTICLE .'.LABEL AS LABEL_ARTICLE
                                                    FROM `'. $Table .'`
                                                        LEFT JOIN `'. TABLE_ERP_STANDARD_ARTICLE .'` ON `'. $Table .'`.`ARTICLE_ID` = `'. TABLE_ERP_STANDARD_ARTICLE .'`.`id`
                                                    WHERE '. $Table .'.PARENT_ID = \''. addslashes($id_GET) .'\'
                                                        ORDER BY '. $Table .'.ORDRE');

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

        if(Article::GETSubAssembly($parent_id, $type)!=NULL)
        {
            foreach(Article::GETSubAssembly($parent_id, $type) as $data)
            {
                echo '<li><span><a href="index.php?page=article&id='. $data->ARTICLE_ID .'">'.  $data->LABEL_ARTICLE .' </a>x '.  $data->QT .'- parent : '. $parent_id .'</span> 
                             <ul>';
      
                    // SECOND RANK PART TECHNICAL CUT
                    foreach (Article::GETTechnicalCut($data->ARTICLE_ID, $type) as $dataTechnicalCutRank2){

                         $TpsTotal = $dataTechnicalCutRank2->TPS_PREP + $dataTechnicalCutRank2->TPS_PRO; 
                         echo '<li>'. $TpsTotal .' hrs - '. $dataTechnicalCutRank2->PRESTA_LABEL .'</li>';
                     }

                    // SECONDE RANK PART NOMENCLATURE
                    foreach (Article::GETNomenclature($data->ARTICLE_ID, $type) as $dataNomenclatureRank2){  

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
