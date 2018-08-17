//1. Price your hotel request
		
         case 'priceyourhotelreq':
         {
                if(isset($params['userno']) && isset($params['loc']) && isset($params['rating']) && isset($params['price']) && isset($params['rooms']) && isset ($params['checkindate']) && isset ($params['nights']) && isset ($params['adults']) && isset($params['child']) ){

                    $user_no 		= $params['userno'];
                    $user_location 	= $params['loc'];
                    $rating 		= $params['rating'];
                    //$distance 		= $params['distance'];
                    $price 			= $params['price'];
                    $rooms 			= $params['rooms'];
                    $checkindate 	= $params['checkindate'];
                    $checkoutdate 	= $params['checkoutdate'];
                    $nights 		= $params['nights'];
                    $adults 		= $params['adults'];
                    $child 			= $params['child'];

                    loggerLogMessage("PriceYourHotel ".$user_no." Searching for hotel. (Name your price service)");
                    //$jsonData = $webserviceObj->priceYourHotelReq($user_no, $user_location, $rating, $distance, $price, $rooms, $checkindate, $nights, $adults, $child);
                    $jsonData = $webserviceObj->priceYourHotelReq($user_no, $user_location, $rating, $price, $rooms, $checkindate,$checkoutdate, $nights, $adults, $child);
                }

              else {
                $jsonData = array(
                    'result' => array( "message" => "Please provide correct data!"),
                    'status' => "NOK"
                );
              }
                break;
          }

		//2. This service will called from cron when request has been placed
		
         case 'priceyourhotelsms':
         {
                $sender 	= $params['sender'];
                $req_id 	= $params['requestid'];
                //$reply 	= $params['reply'];

                $price 		= isset($params['price'])? $params['price'] : '';
				if($price != '' && $price < 500){
					loggerLogMessage("PriceYourHotelSMS -- invalid reply price" );
						$jsonData = array(
							'result' => array( "message" => "You are providing invalid price"),
							'status' => "NOK"
							);
				}else{
					loggerLogMessage("PriceYourHotelSMS -- From ".$sender. "RequestID=".$req_id."Price=".$price);
					
					if($sender != '' && $req_id != '') {
						$jsonData = array(
							'result' => array( "message" => "Got SMS "),
							'status' => "OK");
						$jsonData = $webserviceObj->priceYourHotelSms($sender, $req_id, $price);
					}else {
						loggerLogMessage("PriceYourHotelSMS -- Not Valid Message" );
						$jsonData = array(
							'result' => array( "message" => "Please provide correct data!"),
							'status' => "NOK"
						);
					}
				}

                break;
          }
		//Removed
        case 'priceyourhotelstatus':
         {
                $userno = $params['userno'];

                if($userno != '') {
                    loggerLogMessage("PriceYourHotelStatus -- From ".$userno);

                    $jsonData = $webserviceObj->priceYourHotelStatus($userno);
                }
                else {
                    loggerLogMessage("PriceYourHotelStatus -- Not Valid User" );
                    $jsonData = array(
                         'message' => "Please provide correct data!",
                        'status' => "NOK"
                    );
                }

                break;
          }
		
		//3. List of hotel which reply placed by travel agent.
		
         case 'pyhmyhotels':
         {
                $userno = $params['userno'];
                $pyhreqid = $params['pyhreqid'];
				if($userno != '') {
                    loggerLogMessage("pyhmyhotels -- From ".$userno." for ".$pyhreqid);
					$jsonData = $webserviceObj->pyhMyHotels($userno, $pyhreqid);
                }
                else {
                    loggerLogMessage("PYHMyHHotels -- Not Valid User" );
                    $jsonData = array(
                         'message' => "Please provide correct data!",
                        'status' => "NOK"
                    );
                }

                break;
          }
		
		

         /*case 'pyhbookingconfirm':
         {
                $userno = $params['userno'];
                $pyhreqid = $params['pyhreqid'];
                $hotelid = $params['hotelid'];
                $amountpaid = $params['amountpaid'];

                if($userno != '' && $pyhreqid !='' && $hotelid != '') {
                    loggerLogMessage("pyhBookingConfirm -- From ".$userno." for ".$pyhreqidi ."hotel ".$hotelid);

                    $jsonData = $webserviceObj->pyhBookingConfirm($userno, $pyhreqid, $hotelid, $amountpaid);
                }
                else {
                    loggerLogMessage("MyPYHBookingConfirm -- Not Valid Info" );
                    $jsonData = array(
                         'message' => "Please provide correct data!",
                        'status' => "NOK"
                    );
                }

                break;
          }
		  */
		
		  case "bookingConfirmation":
			$userno 		= $params['userno'];
			$hotelReqId 	= $params['hotelReqId'];
            if (isset($userno) && isset($hotelReqId)){
                $jsonData = $webserviceObj->bookingConfirmation($userno,$hotelReqId);
            }else{
				$jsonData = array(
					'result' => array(
						"message" => "Provide complete data",
						"userno"  => $userno
					),
					'status' => "NOK"
				);
            }
		
		
		break;
		
	case 'pyhBookingConfirm':
		{
	
			$userno 		= $params['userno'];
			$hotelReqId 	= $params['hotelReqId'];
			$amountpaid 	= $params['amountpaid'];
			$eoFee	 		= $params['eo_fee'];
			$name 			= $params['name'];
			$mobile 		= $params['mobile'];
			$email 			= $params['email'];
			
			$env		= isset($params['env_type']) ? $params['env_type'] : '';
			$bookingStatus		= isset($params['status']) ? $params['status'] : '';
			$userRequestId		= isset($params['user_request_id']) ? $params['user_request_id'] : '';
			$orderId 			= isset($params['order_id']) ? $params['order_id'] : '';
			$txnDate 			= isset($params['txn_date']) ? $params['txn_date'] : '';
			$txnId	 			= isset($params['txn_id']) ? $params['txn_id'] : '';
			$respCode 			= isset($params['resp_code']) ? $params['resp_code'] : '';
			$paymentMode 		= isset($params['payment_mode']) ? $params['payment_mode'] : '';
			$bankTxnId 			= isset($params['bank_txn_id']) ? $params['bank_txn_id'] : '';
			$gatewayName 		= isset($params['gateway_name']) ? $params['gateway_name'] : '';
			$respMsg	 		= isset($params['resp_msg']) ? $params['resp_msg'] : '';
			$appPaymentGateway	= isset($params['app_payment_gateway']) ? $params['app_payment_gateway'] : '';
			$bookingId			= isset($params['booking_id']) ? $params['booking_id'] : '';
			$bankName			= isset($params['bank_name']) ? $params['bank_name'] : '';
			$checksumGeneration	= isset($params['generate_checksum']) ? $params['generate_checksum'] : FALSE;
			$allPaymentInfo		= isset($params['all_payment_info']) ? $params['all_payment_info'] : '';
			$taxValue			= isset($params['tax_fee']) ? $params['tax_fee'] : '';
			$bookingPrice		= isset($params['booking_price']) ? $params['booking_price'] : '';
			
			
			$checkSum	 		= ''; 
			$isVerifiedChecksum = '';		
            //_8755
			$fakeTransaction = FALSE;
			if($bankTxnId != ''){
				$fakeTransId = substr($bankTxnId, -5);
				if($fakeTransId == '_8755'){
					$fakeTransaction = TRUE;	
				}
			}
			if($fakeTransaction == TRUE){
				header("HTTP/1.1 401 Not Found");
				$json_data = array( 'result' => array(
								'msg' 				=> "Invalid transaction attempt",
								'booking_id' 		=> '',
								'user_request_id' 	=> $userRequestId,
								'hotelReqId' 		=> $hotelReqId,
								'payment_status' 	=> 'FAILED',
								'file' 				=> ''
							),
						'status' => "NOK"
				);
			}else{
				if($userno 		!= '' && 
				$hotelReqId != '' && 
				$amountpaid != '' && 
				$eoFee		!= '' && 
				$name		!= '' && 
				$mobile		!= '' && 
				$email		!= '' 
				){
					
                    loggerLogMessage("pyhBookingConfirm -- From ".$userno." for ".$pyhreqidi ."hotel ".$hotelid);
					
					loggerLogMessage("pyhBookingConfirm -- Going to create Checksum");
					
					if($bookingId == ''){
						$bookingId 	= createBookingId();
						
						//$bookingId	= $bookingId.generateRandomToken(6);
						
						
						$params['booking_id'] = $bookingId;
						
						
						require_once('paytm/customPaytm.php');
						
						$checkSum = generateChecksum($params, $env);
						loggerLogMessage("pyhBookingConfirm -- Checksum created".$checkSum);
						
						$isVerifiedChecksum = verifyChecksum($params,$checkSum, $env);
						loggerLogMessage("pyhBookingConfirm -- Verification ".$isVerified);
						
					
						
					}
					
                    $jsonData = $webserviceObj->pyhBookingConfirm($userno, $hotelReqId, $amountpaid, $eoFee, $name, $mobile, $email, $bookingStatus, $userRequestId, $orderId, $txnDate,$txnId,$respCode,$paymentMode, $bankTxnId, $gatewayName,$respMsg,$appPaymentGateway,$bookingId,$checkSum, $checksumGeneration,$isVerifiedChecksum,$allPaymentInfo,$taxValue,$bookingPrice);
                }
                else {
                    loggerLogMessage("pyhBookingConfirm -- Not Valid Info" );
                    $jsonData = array(
                         'message' => "Please provide correct data!",
                        'status' => "NOK"
                    );
                }
			}
			

                break;
          }
		  
		  
		//4: pyhDetails: hotelReqId
		case 'pyhDetails':
         {
            $userno 		= $params['userno'];
			$hotelReqId 	= $params['hotelReqId'];
			
            if (isset($userno) && isset($hotelReqId)){
                $jsonData = $webserviceObj->getHotelDetails($userno,$hotelReqId);
            }else{
				$jsonData = array(
					'result' => array(
						"message" => "Provide complete data",
						"userno"  => $userno
					),
					'status' => "NOK"
				);
            }
			break;
		 }
		 


		case "pyhcancellation":
		{
			$userno 		= isset($params['userno']) ? $params['userno'] : '';
			$requestId 		= isset($params['pyhreqid']) ? $params['pyhreqid'] : '';
			if ($userno != '' &&  $requestId != ''){
                $jsonData = $webserviceObj->pyhRequestCancellation($userno,$requestId);
				
            }else{
				$jsonData = array(
					'result' => array(
						"message" => "Provide complete data",
						"userno"  => $userno
					),
					'status' => "NOK"
				);
            }
			break;
		}	
			