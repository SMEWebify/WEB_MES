<?php

namespace App\UI;

use \App\Language\Language;
use \App\SQL;

$langue = new Language('Language', 'manage-company', $User->LANGUAGE);

class Document Extends SQL  {

    Public $DocumentList;

    public function GETAjaxScript($TYPE, $IDTYPE){

        return '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript">
        $(function() {

            // preventing page from redirecting
            $("html").on("dragover", function(e) {
                e.preventDefault();
                e.stopPropagation();
                $("h1").text("Drag here");
            });

            $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });

            // Drag enter
            $(\'.upload-area\').on(\'dragenter\', function (e) {
                e.stopPropagation();
                e.preventDefault();
                $("h1").text("Drop");
            });

            // Drag over
            $(\'.upload-area\').on(\'dragover\', function (e) {
                e.stopPropagation();
                e.preventDefault();
                $("h1").text("Drop");
            });

            // Drop
            $(\'.upload-area\').on(\'drop\', function (e) {
                e.stopPropagation();
                e.preventDefault();

                $("h1").text("Upload");

                var file = e.originalEvent.dataTransfer.files;
                var fd = new FormData();

                fd.append(\'file\', file[0]);

                uploadData(fd);
            });

            // Open file selector on div click
            $("#uploadfile").click(function(){
                $("#file").click();
            });

            // file selected
            $("#file").change(function(){
                var fd = new FormData();

                var files = $(\'#file\')[0].files[0];

                fd.append(\'file\',files);

                uploadData(fd);
            });
            });

            // Sending AJAX request and upload file
            function uploadData(formdata){

            $.ajax({
                url: \'../include/include_upload.php?type='. $TYPE .'&id='. $IDTYPE .'\',
                type: \'post\',
                data: formdata,
                contentType: false,
                processData: false,
                dataType: \'json\',
                success: function(response){
                    addThumbnail(response);
                }
            });
            }

            // Added thumbnail
            function addThumbnail(data){
            $("#uploadfile h1").remove(); 
            var len = $("#uploadfile div.thumbnail").length;

            var num = Number(len);
            num = num + 1;

            var name = data.name;
            var size = convertSize(data.size);
            var src = data.src;

            // Creating an thumbnail
            $("#uploadfile").append(\'<div id="thumbnail_\'+num+\'" class="thumbnail"></div>\');
            $("#thumbnail_"+num).append(\'<img src="\'+src+\'" width="100%" height="78%">\');
            $("#thumbnail_"+num).append(\'<span class="size">\'+size+\'<span>\');

            }

            // Bytes conversion
            function convertSize(size) {
            var sizes = [\'Bytes\', \'KB\', \'MB\', \'GB\', \'TB\'];
            if (size == 0) return \'0 Byte\';
            var i = parseInt(Math.floor(Math.log(size) / Math.log(1024)));
            return Math.round(size / Math.pow(1024, i), 2) + \' \' + sizes[i];
            }
            </script>';
     }


    public function GETDropZone(){

        return '<div id="drop_file_zone">
                <input type="file" name="file" id="file">
                <div class="upload-area"  id="uploadfile">
                    <h1>Drag and Drop file here<br/>Or<br/>Click to select file</h1>
                </div>
            </div>';
     }

    public function GETDocumentList($TYPE, $page, $IDTYPE, $Titre){

       
        $query='SELECT '. TABLE_ERP_ATTACHED_DOCUMENT .'.id,
                        '. TABLE_ERP_ATTACHED_DOCUMENT .'.LABEL,
                        '. TABLE_ERP_ATTACHED_DOCUMENT .'.DATE,
                        '. TABLE_ERP_ATTACHED_DOCUMENT .'.PATH_FILE,
                        '. TABLE_ERP_ATTACHED_DOCUMENT .'.SIZE,
                        '. TABLE_ERP_ATTACHED_DOCUMENT .'.CREATOR_USER_ID,
                        '. TABLE_ERP_ATTACHED_DOCUMENT .'.'. $TYPE .',
                        '. TABLE_ERP_EMPLOYEES .'.NOM,
                        '. TABLE_ERP_EMPLOYEES .'.PRENOM
                FROM '. TABLE_ERP_ATTACHED_DOCUMENT .'
                  LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` ON `'. TABLE_ERP_ATTACHED_DOCUMENT .'`.`CREATOR_USER_ID` = `'. TABLE_ERP_EMPLOYEES .'`.`idUSER`
                WHERE '. TABLE_ERP_ATTACHED_DOCUMENT .'.'. $TYPE .'= '. $IDTYPE .'
                ORDER BY  '. TABLE_ERP_ATTACHED_DOCUMENT .'.id DESC';

         $this->DocumentList .= '<table class="content-table">
				<thead>
					<tr>
						<th></th>
						<th>'. $Titre[0] .'</th>
						<th>'. $Titre[1] .'</th>
						<th>'. $Titre[2] .'</th>
						<th>'. $Titre[3] .'</th>
						<th>'. $Titre[4] .'</th>
					</tr>
				</thead>
				<tbody>';

				foreach ($this->GetQuery($query) as $data){
                    $this->DocumentList .= '<tr>
						<td><a href="index.php?page='. $page .'&id='. $IDTYPE .'&deleteFile='. $data->id .'" title="Supprimer la ligne">&#10007;</a></td>
						<td>'. $data->LABEL .'</td>
						<td>'. $data->DATE .'</td>
						<td>'. $data->PATH_FILE .'</td>
						<td>'. $data->SIZE .'</td>
						<td>'. $data->NOM .' '. $data->PRENOM .'</td>
					</tr>';
                }

                $this->DocumentList .= '</tbody>
			</table>';
        
            return  $this->DocumentList;
    }

    Public Function DeleteFile($IdFile){

        $this->GetDelete("DELETE FROM ". TABLE_ERP_ATTACHED_DOCUMENT ." WHERE id='". addslashes($IdFile)."'");
    }
}