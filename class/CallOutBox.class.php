<?php
namespace ERP;
use\ArrayObject;

class CallOutBox extends ArrayObject { 
    //inir constante
    const RED_ALERTE = 1;
    const SUCCESS_ALERTE = 2;
    const INFO_ALERTE = 3;
    const WARGNIN_ALERTE = 4;

    //add line in array
    function add_notification($alert) {
        $this->append($alert);
    }

    //count number of line
    public function count_notification(){
      return  $this->count(); 
    }

    //display notification
    public function display_notification(){
        //only if we have notification
        if ($this->count_notification() > 0 ){

            echo ' <div class="callout">
                        <div class="callout-header">Notification <span class="badge">', $this->count_notification() ,'</span></div>
                        <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">×</span>
                        <div class="callout-container">';
        
            foreach ($this as $key => $value){
                if($value[0] == self::RED_ALERTE){
                    $class = 'alerte';
                }
                elseif($value[0] == self::SUCCESS_ALERTE){
                    $class = 'alert success';
                }
                elseif($value[0] == self::INFO_ALERTE){
                    $class = 'alert info';
                }
                elseif($value[0] == self::WARGNIN_ALERTE){
                    $class = 'alert warning';
                }

                echo '
                    <div class="', $class ,'">
                        <span class="closebtnligne" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                        ', $value[1], '
                    </div>';
            }
            echo'
			    </div>
			</div>';
      }
    }  
}
?>