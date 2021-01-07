<?php

include_once('crypt.php') ;
include_once('../config.php') ;
include_once('inc.php');

// die ('yes');
if (isset($_POST['create_case'])) {

	include "chkuploadfile.php";

	//print_r($_FILES);
	//print "DONE " . date("His");
	//exit();
    //include 'uploadfile.php'; <- remove by suwich 2020-12-30 - chg to post base64 to webhook //
    
	// $linkFile = array_filter($linkFile, function($value) { return !is_null($value) && $value !== ''; });
    // $file = array_filter($_FILES['file']['name'], function($value) { return !is_null($value) && $value !== ''; });
    // print_r($_FILES['file']);
    // exit(); 
    create_case($_POST,$FILEUPLOADARR);
}

function create_case($data,$FILEUPLOADARR)
{


    try{

        $url = TVSS_WEBHOOK; 
        
        $idcard = encryptString($_POST['idcard']);
        $ch = curl_init( $url );


        $JsonFile = array();
        // foreach ($_POST['file'] as $key => $value) {
        //     $JsonFile["file$key"] = $value ;
        //     $JsonFile["linkFile$key"] = 'https://devytuapp.tellvoice.com/youtellus/uploads/file/'.$_POST['linkFile'][$key];

        // }

		/*
        foreach ($file['name'] as $key => $value) {
            if( $value !=''){

                $JsonFile["file$key"] = $value ;
                $JsonFile["linkFile$key"] = 'https://devytuapp.tellvoice.com/youtellus/uploads/file/'.$file['linkFile'][$key];
    
            }

        }
		*/
		
		

        ///////////// set json data ////////////
        $Jsonbody = array(  "name"=> $_POST['name']
                            ,"idCard"=> $idcard
                            ,"tel"=> $_POST['tel'] 
                            ,"email"=> $_POST['email']
                            ,"idUser"=> isset($_POST['iduser'])? $_POST['iduser'] : "" 
                            // ,"description"=> $_POST['description']
                            ,'textfeedsubtype' => ($_POST['other'])==''? $_POST['textfeedsubtype'] : $_POST['other'] 
                            ,"complaintId"=> isset($_POST['complaintId'])? $_POST['complaintId'] : "" 
                            ,"nameDelegate"=> isset($_POST['nameDelegate'])? $_POST['nameDelegate'] : "" 
                            ,"service"=> isset($_POST['service'])? $_POST['service'] : "" 
                            ,"serviceId"=> isset($_POST['serviceID'])? $_POST['serviceID'] : "" 
                            ,"relationOption"=> isset($_POST['relationOptions'])? $_POST['relationOptions'] : "" 
                            ,"numId"=> isset($_POST['numID'])? $_POST['numID'] : "" 
                            ,"nameAuthorizedPerson"=> isset($_POST['nameAuthorizedPerson'])? $_POST['nameAuthorizedPerson'] : "" 
                            
                            ,"nameAttorneyPerson"=> isset($_POST['nameAttorneyPerson'])? $_POST['nameAttorneyPerson'] : "" 
                            ,"idcardAttorneyPerson"=> isset($_POST['idcardAttorneyPerson'])? $_POST['idcardAttorneyPerson'] : "" 
                            ,"problem"=> isset($_POST['problem'])? $_POST['problem'] : "" 
                            ,"reqToBank"=> isset($_POST['reqToBank'])? $_POST['reqToBank'] : "" 
                            
                            ,"position"=> isset($_POST['position'])? $_POST['position'] : "" 
                            ,"nameOwner"=> isset($_POST['nameOwner'])? $_POST['nameOwner'] : "" 
                            //,"file"=>json_encode($JsonFile)
							,"fileul"=>$FILEUPLOADARR
                            ,"lang"=>$_POST['lang']
                        );
        

        $ParamArr = array(   
                            "feedTitle"=> $_POST['feedsubtype'].' : '.$_POST['tel'].' '.$_POST['name']
                            ,"feedType"=> $_POST['feedtype']
                            ,"feedSubType"=> $_POST['feedsubtype']
                            ,"feedBody"=> json_encode($Jsonbody)
                            
                        );
        
        $payload = json_encode( $ParamArr);

        // die(var_dump($payload));

        // $ParamArr = array( "data"=> "FIK TEST" );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        # Return response instead of printing.
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);
        # Print response.
        // ;
        
        // die(print_r( "<pre>$result</pre>"));

        header("Location: ../index.php?page=thanks");

    }catch (Exception $e) {
        $msg = "error";
        header("Location: ../index.php?page=error&msg=$msg");
    }
}


 ?>