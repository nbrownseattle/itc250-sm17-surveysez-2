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
    
}//end of my survey class
