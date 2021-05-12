<?php

namespace App\Study;
use \App\Planning\Task;

class Article Extends Task  {

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
    Public $LABEL_SERVICE;
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
                                            '. TABLE_ERP_PRESTATION .'.LABEL AS LABEL_SERVICE,
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
                echo '<li><span> '.  $data->QT .' x <a href="index.php?page=article&id='. $data->ARTICLE_ID  .'">'.  $data->LABEL_ARTICLE 	 .' </a></span> 
                             <ul>';
      
                    // SECOND RANK PART TECHNICAL CUT
                    foreach (Article::GETTechnicalCut($data->ARTICLE_ID	, 'component') as $dataTechnicalCutRank2){

                         $TpsTotal = $dataTechnicalCutRank2->SETING_TIME + $dataTechnicalCutRank2->UNIT_TIME; 
                         echo '<li>'. $TpsTotal .' hrs - '. $dataTechnicalCutRank2->LABEL_SERVICE .'</li>';
                     }

                    // SECONDE RANK PART NOMENCLATURE
                    foreach (Article::GETNomenclature($data->ARTICLE_ID	, 'component') as $dataNomenclatureRank2){  

                          echo '<li> '. $dataNomenclatureRank2->QTY  .' '. $dataNomenclatureRank2->UNIT_LABEL  .' - '. $dataNomenclatureRank2->ARTICLE_LABEL .'</li>';
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
