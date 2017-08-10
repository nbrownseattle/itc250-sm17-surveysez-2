<?php

//My_survey.php nicole brown 08/07/2017
namespace SurveySez;

class My_survey extends Survey
{

        function __construct($id)
        {
            parent::__construct($id);
           
        }//end of My_survey constructor
    
    //we added our function from 
        function showQuestions()
        {
            if($this->TotalQuestions > 0)
            {#be certain there are questions
                foreach($this->aQuestion as $question)
                {#print data for each 

                    echo '

                    <div class="panel panel-primary">
                      <div class="panel-heading">
                        <h3 class="panel-title">' . $question->Text . '</h3>
                      </div>
                      <div class="panel-body">
                        <p>' . $question->Description . '</p>
                        ' . $question->showAnswers() . ' 
                      </div>
                    </div>

                    ';

                }
            }else{
                echo "There are currently no questions for this survey.";	
            }          
	}# end showQuestions() method
    /*
    Will take in SurveyID and show list of responses for that survey
    */
    
    public static function responseList($id){
        
        $myReturn = '';
        
        $sql = "select * from sm17_responses where SurveyID=" . (int)$id;
        
        #reference images for pager
        $prev = '<img src="' . VIRTUAL_PATH . 'images/arrow_prev.gif" border="0" />';
        $next = '<img src="' . VIRTUAL_PATH . 'images/arrow_next.gif" border="0" />';

        # Create instance of new 'pager' class
        $myPager = new \Pager(10,'',$prev,$next,'');
        $sql = $myPager->loadSQL($sql);  #load SQL, add offset

        # connection comes first in mysqli (improved) function
        $result = mysqli_query(\IDB::conn(),$sql) or die(trigger_error(mysqli_error(\IDB::conn()), E_USER_ERROR));

        if(mysqli_num_rows($result) > 0)
        {#records exist - process
            if($myPager->showTotal()==1){$itemz = "response";}else{$itemz = "responses";}  //deal with plural
            $myReturn .= '<div align="center">We have ' . $myPager->showTotal() . ' ' . $itemz . '!</div>';

                  $myReturn .= '

                  <table class="table table-striped table-hover ">
          <thead>
            <tr>
                <th>Date Taken</th>
            </tr>
          </thead>
          <tbody>
                  ';

            while($row = mysqli_fetch_assoc($result))
            {# process each row

                $myReturn .= '
                <tr>                  
                    <td><a href="' . VIRTUAL_PATH . 'surveys/response_view.php?id=' . (int)$row['ResponseID'] . '">' . dbOut($row['DateAdded']) . '</a></td>       
               </tr>       
            ';              

                /*$myReturn .= '
                            <tr>
                                <td>' . dbOut($row['AdminName']) . '</td>
                                <td><a href="' . VIRTUAL_PATH . 'surveys/survey_view.php?id=' . (int)$row['SurveyID'] . '">' . dbOut($row['Title']) . '</a></td>
                                <td>' . dbOut($row['DateAdded']) . '</td>
                           </tr>       
                        '; */

                    }

            $myReturn .='
              </tbody>
            </table>
        ';

            $myReturn .= $myPager->showNAV(); # show paging nav, only if enough records	 
        }else{#no records
            $myReturn .= "<div align=center>There are currently no responses to this survey.</div>";	
        }
        @mysqli_free_result($result);
        
          
        
            
        return $myReturn;
        
    }//end responseList()
    
    

}//end of my survey class
