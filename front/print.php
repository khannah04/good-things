<?php 

    
    //making sure we got here using POST
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        $note = $_POST["note"];

        if(empty($note)){
            header("Location: homepage.php"); 
            exit(); 
            
        }

        //html special chars does not let the user inject code into website
        else{
            //storeInArray(htmlspecialchars($note)); 
            header("Location: submission.php");
        }
        

       
        //print_r($)
    }
    else {
        $note = ""; 
    }
    
    
function storeInArray($notes, $newnote){
    if(!empty($newnote)){
        $notes[] = $newnote;
        //echo $newnote; 
        print_r($notes); 
    }
   
}
