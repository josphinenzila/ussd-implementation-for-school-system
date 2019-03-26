  <?php

//Ensure ths code runs only after a POST from AT
if(!empty($_POST) && !empty($_POST['phoneNumber'])){
	require_once('dbConnector.php');
	
	//Receive the POST from AT
	$sessionId     =$_POST['sessionId'];
	$serviceCode   =$_POST['serviceCode'];
	$phoneNumber   =$_POST['phoneNumber'];
	$text          =$_POST['text'];

	// Explode the text to get the value of the latest interaction - think 1*1
	$textArray=explode('*', $text);
	$userResponse=trim(end($textArray));

	//Set the default level of the user
	$level=0;

	//Check the level of the user from the DB and retain default level if none is found for this session
	$stmt = $db->query("select level from session_levels where session_id ='".$sessionId." '");
	$stmt->execute();
	
	if($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
  		$level = $result['level'];
	}	

	//Check if the user is in the db
	$stmt = $db->query("SELECT * FROM all_contacts_ussd WHERE phone1 LIKE '%".$phoneNumber."%' OR phone2 LIKE '%".$phoneNumber."%'");
	$stmt->execute();
    
    $userAvailable = $stmt->fetch(PDO::FETCH_ASSOC);

	//Check if the user is available (yes)->Serve the menu; 
	if($userAvailable['school_id'] OR $userAvailable['phone1']!=NULL OR $userAvailable['phone2']!=NULL){
		//Serve the Services Menu (if the user is fully registered,level 0 and 1 serve the basic menus
		if($level==0 || $level==1){
			//Check that the user actually typed something, else demote level and start at home
			switch ($userResponse) {
			  
			    case "1":
			        if($level==1){
			            
                        // Check fee balance
                        $stmt = $db->query("SELECT * FROM fee_balance_ussd WHERE parent_phone1 LIKE '%".$phoneNumber."%' OR parent_phone2 LIKE '%".$phoneNumber."%'");
                        $stmt->execute();
                        
                        
                        if($stmt->rowCount() > 0){
                           echo "CON "; 
                           
                            foreach($stmt->fetchALL(PDO::FETCH_ASSOC) as $row){
                                
                                $date=$row['date_posted'];
                                $phpdate=strtotime($date);
                                $new_date=date("d/m/Y", $phpdate);
                           
		                        //Respond with Fee Balance
                               $balance="Fee Balance for " .$row['student_name']." as at " .$new_date." is Ksh.".$row['fee_balance']."\n"; 
                          	   echo $balance;
                            }
                             
                            $back = "0:Back\n";
                            echo $back;
    
				            //Update sessions to level 1
				            $stmt = $db->query("UPDATE `session_levels` SET `level`=1 where `session_id`='".$sessionId."'");
				    	    $stmt->execute();
			  			    // Print the response onto the page so that our gateway can read it
			  			    header('Content-type: text/plain');
 			  			  
                      } else {

                        $response= "CON Fee Balance not available at the moment\n" ;
                        $response .="0:Back\n";
                        //Update sessions to level 1
				        $stmt = $db->query("UPDATE `session_levels` SET `level`=1 where `session_id`='".$sessionId."'");
				    	$stmt->execute();

			  			// Print the response onto the page so that our gateway can read it
			  			header('Content-type: text/plain');
 			  			echo $response;	 
       
                        } 
                            
			        } 
			        break;
			      
			        
			    case "2":
			    	if($level==1){
			    	    
			    		//Find exam results
						$stmt = $db->query("SELECT * FROM exam_results_ussd WHERE (parent_phone1 LIKE '%".$phoneNumber."%' OR parent_phone2 LIKE '%".$phoneNumber."%')");
                        $stmt->execute();
                        
                        if($stmt->rowCount() > 0){
                           echo "CON "; 
                           
                            foreach($stmt->fetchALL(PDO::FETCH_ASSOC) as $row){
                                //while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                //extract($row);
                                $date=$row['date_posted'];
                                $phpdate=strtotime($date);
                                $new_date=date("d/m/Y", $phpdate);

                                $results= "Results for ".$row['student_name']." for ".$row['exam_name']." as at ".$new_date."\n\n".$row['results']."\n\n"; 
                                echo $results;
                            }
                        
                            $back = "0:Main menu\n";
                            echo $back;
    
				            //Update sessions to level 1
				            $stmt = $db->query("UPDATE `session_levels` SET `level`=1 where `session_id`='".$sessionId."'");
				    	    $stmt->execute();
			  			    // Print the response onto the page so that our gateway can read it
			  			    header('Content-type: text/plain');
 			  			  
                        }
                        
                       else {

                        $response= "CON Exam Results not available at the moment\n " ;
                        $response .= "0:Back\n";
                        //Update sessions to level 1
				        $stmt = $db->query("UPDATE `session_levels` SET `level`=1 where `session_id`='".$sessionId."'");
				    	$stmt->execute();

			  			// Print the response onto the page so that our gateway can read it
			  			header('Content-type: text/plain');
 			  			echo $response;	 
       
                        }  
					
			        }
			        break;
			      
			    case "3":
			    	if($level==1){
	
			    		// Find events
						$stmt = $db->query("SELECT DISTINCT event_name,event_details,start_date,end_date,school_id,school_name FROM events_ussd WHERE start_date >='".date("Y/m/d")."' AND (phone1 LIKE '%".$phoneNumber."%' OR phone2 LIKE '%".$phoneNumber."%') ORDER BY start_date ASC");
                        $stmt->execute();

						if($stmt->rowCount() > 0){
                           echo "CON "; 
                           
                            foreach($stmt->fetchALL(PDO::FETCH_ASSOC) as $row){
                                //while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                //extract($row);
                                
                                $date=$row['start_date'];
                                $phpdate=strtotime($date);
                                $new_date=date("d/m/Y", $phpdate);
                 
                                //Display Events
					            $events= "-".$row['event_name']." is on ".$new_date." at " .$row['school_name']."\n" ;
					            echo $events;
                               }
                        
                               $back = "0:Back\n";
                               echo $back;
                            
                               //Update sessions to level 1
				               $stmt = $db->query("UPDATE `session_levels` SET `level`=1 where `session_id`='".$sessionId."'");
				    	       $stmt->execute();
			  			       // Print the response onto the page so that our gateway can read it
			  			      header('Content-type: text/plain');
 			  			        
                             } else {
                        
                                $response= "CON Events not available at the moment\n " ;
                                $response .= "0:Back\n";
                                //Update sessions to level 1
				                $stmt = $db->query("UPDATE `session_levels` SET `level`=1 where `session_id`='".$sessionId."'");
				    	        $stmt->execute();

			  			        // Print the response onto the page so that our gateway can read it
			  			        header('Content-type: text/plain');
 			  			        echo $response;	 
                        }
					
			    	}
			    	break;	
			    	
			    case "4":
			    	if($level==1){
			    		//9e. Choose Class
						$response = "CON Choose Class\n";
						$response .= "1. Form 1\n";
						$response .= "2. Form 2\n";
						$response .= "3. Form 3\n";
						$response .= "4. Form 4\n";
						

						//Update sessions to level 9
				    	$stmt = $db->query("UPDATE `session_levels` SET `level`=9 where `session_id`='".$sessionId."'");
				    	$stmt->execute();

			  			// Print the response onto the page so that our gateway can read it
			  			header('Content-type: text/plain');
 			  			echo $response;	 
 			    		
			    	}
			        break;
			    case "5":
			    	if($level==1){
			    	    
			    		// Find payment instructions
					    $stmt = $db->query("SELECT DISTINCT description,school_name,school_id FROM payment_instructions_ussd WHERE (phone1 LIKE '%".$phoneNumber."%' OR phone2 LIKE '%".$phoneNumber."%')");
                        $stmt->execute();

						if($stmt->rowCount() > 0){
                           echo "CON "; 
                           
                            foreach($stmt->fetchALL(PDO::FETCH_ASSOC) as $row){
                                //while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                //extract($row);
                                $instructions= $row['school_name']."\n".$row['description']."\n";
					            echo $instructions;
					        
                            //Update sessions to level 1
                            $stmt = $db->query("UPDATE `session_levels` SET `level`=1 where `session_id`='".$sessionId."'");
				    	    $stmt->execute();

			  			    // Print the response onto the page so that our gateway can read it
			  			    header('Content-type: text/plain');
 			  			   
                            }
                        
                               $back = "0:Back\n";
                               echo $back;
                            
                               //Update sessions to level 1
				               $stmt = $db->query("UPDATE `session_levels` SET `level`=1 where `session_id`='".$sessionId."'");
				    	       $stmt->execute();
			  			       // Print the response onto the page so that our gateway can read it
			  			      header('Content-type: text/plain');
 			  			        
                             } else {
                        
                                $response= "CON Payment details not available at the moment\n " ;
                                $response .= "0:Back\n";
                                //Update sessions to level 1
				                $stmt = $db->query("UPDATE `session_levels` SET `level`=1 where `session_id`='".$sessionId."'");
				    	        $stmt->execute();

			  			        // Print the response onto the page so that our gateway can read it
			  			        header('Content-type: text/plain');
 			  			        echo $response;	 
                        }
					
			    	}
			    	break;	
			        
			        
			     default:
			         //9b. Graduate user to next level & Serve Main Menu
			        	$stmt = $db->query("INSERT INTO `session_levels`(`session_id`,`phoneNumber`,`level`) VALUES('".$sessionId."','".$phoneNumber."',1)");
			        	$stmt->execute();
                        //Serve our services menu
						$response = "CON Welcome to USSD Schools\nChoose option.\n";
						$response .= " 1. Fee Balance\n";
						$response .= " 2. Exam Results\n";
						$response .= " 3. News and Events\n";
						$response .= " 4. Fee Structure\n";						
						$response .= " 5. Payment Details\n";
																																					

			  			// Print the response onto the page so that our gateway can read it
			  			header('Content-type: text/plain');
 			  			echo $response;	
 			  			break;
			         
			   
			}
			
        }
        
	

    else{
			
			switch ($level){
			      case 9:
					switch ($userResponse) {
					    case "1":
					        
			    		// Find Form 1 Fee Structure
						$stmt = $db->query("SELECT DISTINCT class,term1,term2,term3,total,date_posted,school_id,school_name FROM fee_structure_ussd WHERE class='FORM1' AND (phone1 LIKE '%".$phoneNumber."%' OR phone2 LIKE '%".$phoneNumber."%')");
                        $stmt->execute();
                        
						if($stmt->rowCount() > 0){
                           echo "CON "; 
                           
                         foreach($stmt->fetchALL(PDO::FETCH_ASSOC) as $row){
                                //while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                //extract($row);
						        $date=$row['date_posted'];
                                $phpdate=strtotime($date);
                                $new_date=date("d/m/Y", $phpdate);
                        
                                $term1_fees=$row['term1'];
                                $term2_fees=$row['term2'];
                                $term3_fees=$row['term3'];
                                $total_fees=$row['total'];
						    
						       //Show Form 1 Fee Structure
					           $feeStructure= "Fee Stucture\n".$row['school_name']."\nTerm 1: Ksh." .$term2_fees. " \nTerm 2: Ksh." .$term2_fees. " \nTerm 3: Ksh." .$term3_fees. " \nTotal :Ksh. " .$total_fees."\n";
                               echo $feeStructure;
                           
						    }
                           
                           $back = "0:Back\n";
                           echo $back;
                            
                            //Update sessions to level 1
				           $stmt = $db->query("UPDATE `session_levels` SET `level`=1 where `session_id`='".$sessionId."'");
				    	   $stmt->execute();
			  			   // Print the response onto the page so that our gateway can read it
			  			   header('Content-type: text/plain');
 			  			        
                            } else {
                                 $response= "CON Form 1 Fee Structure not available at the moment\n " ;
                                $response .= "0:Back\n";
                                //Update sessions to level 1
				                $stmt = $db->query("UPDATE `session_levels` SET `level`=1 where `session_id`='".$sessionId."'");
				    	        $stmt->execute();

			  			        // Print the response onto the page so that our gateway can read it
			  			        header('Content-type: text/plain');
 			  			        echo $response;	 
                                }
        					
			    	      break;	
                                

					    case "2":
					
			    		// Find Form 2 Fee Structure
						$stmt = $db->query("SELECT DISTINCT class,term1,term2,term3,total,date_posted,school_id,school_name FROM fee_structure_ussd WHERE class='FORM2' AND (phone1 LIKE '%".$phoneNumber."%' OR phone2 LIKE '%".$phoneNumber."%')");
                        $stmt->execute();
                        
						if($stmt->rowCount() > 0){
                           echo "CON "; 
                           
                         foreach($stmt->fetchALL(PDO::FETCH_ASSOC) as $row){
                                //while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                //extract($row);
						        $date=$row['date_posted'];
                                $phpdate=strtotime($date);
                                $new_date=date("d/m/Y", $phpdate);
                        
                                $term1_fees=$row['term1'];
                                $term2_fees=$row['term2'];
                                $term3_fees=$row['term3'];
                                $total_fees=$row['total'];
						    
						       //Show Form 2 Fee Structure
					           $feeStructure= "Fee Stucture\n".$row['school_name']."\nTerm 1: Ksh." .$term2_fees. " \nTerm 2: Ksh." .$term2_fees. " \nTerm 3: Ksh." .$term3_fees. " \nTotal :Ksh. " .$total_fees."\n";
                               echo $feeStructure;
                           
						    }
                           
                           $back = "0:Back\n";
                           echo $back;
                            
                            //Update sessions to level 1
				           $stmt = $db->query("UPDATE `session_levels` SET `level`=1 where `session_id`='".$sessionId."'");
				    	   $stmt->execute();
			  			   // Print the response onto the page so that our gateway can read it
			  			   header('Content-type: text/plain');
 			  			        
                            } else {
                                 $response= "CON Form 2 Fee Structure not available at the moment\n " ;
                                $response .= "0:Back\n";
                                //Update sessions to level 1
				                $stmt = $db->query("UPDATE `session_levels` SET `level`=1 where `session_id`='".$sessionId."'");
				    	        $stmt->execute();

			  			        // Print the response onto the page so that our gateway can read it
			  			        header('Content-type: text/plain');
 			  			        echo $response;	 
                                }
        					
			    	      break;
			    	      
					    case "3":

			    		// Find Form 3 Fee Structure
						$stmt = $db->query("SELECT DISTINCT class,term1,term2,term3,total,date_posted,school_id,school_name FROM fee_structure_ussd WHERE class='FORM3' AND (phone1 LIKE '%".$phoneNumber."%' OR phone2 LIKE '%".$phoneNumber."%')");
                        $stmt->execute();
                        
						if($stmt->rowCount() > 0){
                           echo "CON "; 
                           
                         foreach($stmt->fetchALL(PDO::FETCH_ASSOC) as $row){
                                //while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                //extract($row);
						        $date=$row['date_posted'];
                                $phpdate=strtotime($date);
                                $new_date=date("d/m/Y", $phpdate);
                        
                                $term1_fees=$row['term1'];
                                $term2_fees=$row['term2'];
                                $term3_fees=$row['term3'];
                                $total_fees=$row['total'];
						    
						       //Show Form 3 Fee Structure
					           $feeStructure= "Fee Stucture\n".$row['school_name']."\nTerm 1: Ksh." .$term2_fees. " \nTerm 2: Ksh." .$term2_fees. " \nTerm 3: Ksh." .$term3_fees. " \nTotal :Ksh. " .$total_fees."\n";
                               echo $feeStructure;
                           
						    }
                           
                           $back = "0:Back\n";
                           echo $back;
                            
                            //Update sessions to level 1
				           $stmt = $db->query("UPDATE `session_levels` SET `level`=1 where `session_id`='".$sessionId."'");
				    	   $stmt->execute();
			  			   // Print the response onto the page so that our gateway can read it
			  			   header('Content-type: text/plain');
 			  			        
                            } else {
                                 $response= "CON Form 3 Fee Structure not available at the moment\n " ;
                                $response .= "0:Back\n";
                                //Update sessions to level 1
				                $stmt = $db->query("UPDATE `session_levels` SET `level`=1 where `session_id`='".$sessionId."'");
				    	        $stmt->execute();

			  			        // Print the response onto the page so that our gateway can read it
			  			        header('Content-type: text/plain');
 			  			        echo $response;	 
                                }
        					
			    	      break;	
				        
				        case "4":
					  
			    		// Find Form 4 Fee Structure
						$stmt = $db->query("SELECT DISTINCT class,term1,term2,term3,total,date_posted,school_id,school_name FROM fee_structure_ussd WHERE class='FORM4' AND (phone1 LIKE '%".$phoneNumber."%' OR phone2 LIKE '%".$phoneNumber."%')");
                        $stmt->execute();
                        
						if($stmt->rowCount() > 0){
                           echo "CON "; 
                           
                         foreach($stmt->fetchALL(PDO::FETCH_ASSOC) as $row){
                                //while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                //extract($row);
						        $date=$row['date_posted'];
                                $phpdate=strtotime($date);
                                $new_date=date("d/m/Y", $phpdate);
                        
                                $term1_fees=$row['term1'];
                                $term2_fees=$row['term2'];
                                $term3_fees=$row['term3'];
                                $total_fees=$row['total'];
						    
						       //Show Form 4 Fee Structure
					           $feeStructure= "Fee Stucture\n".$row['school_name']."\nTerm 1: Ksh." .$term2_fees. " \nTerm 2: Ksh." .$term2_fees. " \nTerm 3: Ksh." .$term3_fees. " \nTotal :Ksh. " .$total_fees."\n";
                               echo $feeStructure;
                           
						    }
                           
                           $back = "0:Back\n";
                           echo $back;
                            
                            //Update sessions to level 1
				           $stmt = $db->query("UPDATE `session_levels` SET `level`=1 where `session_id`='".$sessionId."'");
				    	   $stmt->execute();
			  			   // Print the response onto the page so that our gateway can read it
			  			   header('Content-type: text/plain');
 			  			        
                            } else {
                                 $response= "CON Form 4 Fee Structure not available at the moment\n " ;
                                $response .= "0:Back\n";
                                //Update sessions to level 1
				                $stmt = $db->query("UPDATE `session_levels` SET `level`=1 where `session_id`='".$sessionId."'");
				    	        $stmt->execute();

			  			        // Print the response onto the page so that our gateway can read it
			  			        header('Content-type: text/plain');
 			  			        echo $response;	 
                                }
        					
			    	      break;	
				        
				        
				       
					}				
		        
		        	
			}
        
    }
	    
	}
    
    else{
       $response = "END Sorry, phone number is not registered for USSDSCHOOLS Service.\n";
       	// Print the response onto the page so that our gateway can read it
	  header('Content-type: text/plain');
	  echo $response;
       
    }
}
    

    
    

        
	
	
	
	
	

?>
