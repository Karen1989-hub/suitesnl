
<br>
$arrival = <?= $arrival;?>  
<br>
$departure =  <?= $departure;?>  
<br>
$collection = <?= $collection;?> 

<?php

	function getSuitesroomsByPropertyId($id){
		global $db;

		$sql = "SELECT * FROM `suitesrooms` where `propertyid`=:id ORDER BY `propertyid` DESC";
		
		$stmt = $db->prepare($sql);
    	$stmt->execute([
			"id" => $id
    	]);
    	$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);   
    	return $result;
	}	

	function ollPhotosByRoomId($roomId){
		global $db;

		$sql = "SELECT `photo_id` from `room_photos` WHERE room_id=:roomId ORDER BY displayorder ASC";

		$smtp = $db->prepare($sql);
        $smtp->execute([
            "roomId"  => $roomId,
        ]);
        $result = $smtp->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
	}

	$type = 'hotel';
	//echo $hotel_id;die;
	//$hotel_id = 1242;
	$ch = curl_init("https://search-av.hotels.nl/?id=".$hotel_id."&type=".$type."&arrival=".$arrival."&departure=".$departure);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);

	$json = curl_exec($ch);
	curl_close($ch);	

	$json = json_decode($json);
	// echo "<pre>";
	// var_dump($json);
	// die;

	//our DB
	$sutesrooms = getSuitesroomsByPropertyId($hotel_id);
	
	//API DB
	$room_ratetype = $json->hotels[0]->room_ratetype;	

	$rooms = [];
	if($room_ratetype != null && $sutesrooms != null){
		foreach($sutesrooms as $sute){
			foreach($room_ratetype as $room){
				if($room->room_id == $sute['roomid']){			
					array_push($rooms,$room);
					break;
				}	
			}
		}
	}	
?>	
<?php
// echo "<pre>";
// print_r($rooms);

?>

	<?php if(!empty($rooms)): ?>		
	<div style="width:100%; overflow: scroll;">
		<table cellspacing=10 >
            <tr>
                <th>Image</th>
                <th>Room_id</th>
                <th>Hotel_id</th>
				<th>Room_name</th>
				<th>Description</th>
				<th>min_price</th>
				<th>max_price</th>
				<th>min_stay_price</th>
				<th>min_numpersons</th>
				<th>max_persons</th>
				<th>min_stay</th>
				<th>rate_type_id</th>
				<th>room_rate_type_id</th>
				<th>additionalCostInfo</th>
				<th>additional_cost_info</th>
				<th>citytax_included</th>
				<th>citytax_type</th>
				<th>citytax</th>
				<th>flags</th>
				<th>hasServiceCost</th>
				<th>isDeal</th>
				<th>persons</th>
				<th>rate_type_min_stay</th>
				<th>rate_type_max_stay</th>
				<th>availabilitylistitem</th>
				<th>guarantee_method</th>
				<th>cancel_policy</th>
				<th>cancellation_timestamp</th>
				<th>cancellation_till_time</th>
				<th>cancelation</th>
				<th>hotdeal</th>
				<th>req_cc</th>
				<th>rate_type_name_visible</th>
				<th>rate_type_name_default</th>
				<th>specialdeal_title</th>
				<th>has_dinner</th>
				<th>rate_type_name</th>
				<th>dealParity</th>
				<th>breakfast_included</th>
				<th>provider</th>
				<th>arrangement</th>
				<th>special</th>
				<th>show</th>
				<th>discount</th>
				<th>smartDealDiscount</th>
				<th>all_agents</th>			
			</tr>
			<?php foreach($rooms as $key => $room): ?>
            <tr>                
				<?php
				$url = $room->room_image_url;
				$arrurl = explode("/",$url);
				$img = end($arrurl);
				$ollRoomsPhoto = ollPhotosByRoomId($img);				
				?>				
				<td>				
					<div class="slideshow-container">
						<?php foreach($ollRoomsPhoto as $key1=>$val1): ?>
							<div class="mySlides fade roomsId_<?php echo $key; ?>" style="display:<?php if($key1==0):?>block<?php else: ?>none<?php endif ?>">
							<div class="numbertext"><?php echo $key1+1; ?> / <?php echo count($ollRoomsPhoto); ?></div>
							<img src="https://www.hotels.nl/assets/images/rooms/<?= $room->room_id."-".$val1['photo_id'] ?>.jpg" alt="">							
							</div>
						<?php endforeach ?>	
						<input type="hidden" class="slid roomsNum<?php echo $key; ?>" value="<?php echo $key; ?>">
                    	<input type="hidden" class="slid photoCount<?php echo $key; ?>" value="<?php echo count($ollRoomsPhoto); ?>">
                    	<input type="hidden" class="slid showPhotoIndex<?php echo $key; ?>" value="1">							

						<a class="prev" data="<?php echo $key; ?>">&#10094;</a>
						<a class="next" data="<?php echo $key; ?>">&#10095;</a>

					</div>					
				</td>
                <td> <?php echo isset($room->room_id)   ? $room->room_id : ''; ?></td>
                <td> <?php echo isset($room->hotelid)   ? $room->hotelid : ''; ?></td>
				<td> <?php echo isset($room->room_name)   ? $room->room_name : ''; ?></td>
				<td> <?php echo isset($room->typeDescription)   ? $room->typeDescription : ''; ?></td>
				<td> <?php echo isset($room->min_price)   ? $room->min_price : ''; ?></td>
				<td> <?php echo isset($room->max_price)   ? $room->max_price : ''; ?></td>
				<td> <?php echo isset($room->min_stay_price)   ? $room->min_stay_price : ''; ?></td>
				<td> <?php echo isset($room->min_numpersons)   ? $room->min_numpersons : ''; ?></td>
				<td> <?php echo isset($room->max_persons)   ? $room->max_persons : ''; ?></td>
				<td> <?php echo isset($room->min_stay)   ? $room->min_stay : ''; ?></td>
				<td> <?php echo isset($room->rate_type_id)   ? $room->rate_type_id : ''; ?></td>
				<td> <?php echo isset($room->room_rate_type_id)   ? $room->room_rate_type_id : ''; ?></td>
				<td> <?php echo isset($room->additionalCostInfo)   ? $room->additionalCostInfo : ''; ?></td>
				<td> <?php echo isset($room->additional_cost_info)   ? $room->additional_cost_info : ''; ?></td>
				<td> <?php echo isset($room->citytax_included)   ? $room->citytax_included : ''; ?></td>
				<td> <?php echo isset($room->citytax_type)   ? $room->citytax_type : ''; ?></td>
				<td> <?php echo isset($room->citytax)   ? $room->citytax : ''; ?></td>
				<td> <?php if(isset($room->flags)){
								foreach($room->flags as $flag){
									echo $flag."<br>";
								}
							} else { echo "";} 
					  ?>
				</td>
				<td> <?php echo isset($room->hasServiceCost)   ? $room->hasServiceCost : ''; ?></td>
				<td> <?php echo isset($room->isDeal)   ? $room->isDeal : ''; ?></td>
				<td> <?php echo isset($room->persons)   ? : ''; ?> </td>
				<td> <?php echo isset($room->rate_type_min_stay)   ? $room->rate_type_min_stay : ''; ?></td>
				<td> <?php echo isset($room->rate_type_max_stay)   ? $room->rate_type_max_stay : ''; ?></td>
				<td> <?php if(isset($room->availabilitylistitem)){					
						echo "type: ";
						echo isset($room->availabilitylistitem->type)   ? $room->availabilitylistitem->type.'<br>' : '';
						echo "title: ";
						echo isset($room->availabilitylistitem->title)   ? $room->availabilitylistitem->title.'<br>' : '';
						echo "titlevisible: ";
						echo isset($room->availabilitylistitem->titlevisible)   ? $room->availabilitylistitem->titlevisible.'<br>' : '';
						echo "labelvisible: ";
						echo isset($room->availabilitylistitem->labelvisible)   ? $room->availabilitylistitem->labelvisible.'<br>' : '';
						echo "labeltext: ";
						echo isset($room->availabilitylistitem->labeltext)   ? $room->availabilitylistitem->labeltext.'<br>' : '';
						echo "class: ";
						echo isset($room->availabilitylistitem->class)   ? $room->availabilitylistitem->class.'<br>' : '';
						echo "lastMinute: ";
						echo isset($room->availabilitylistitem->lastMinute)   ? $room->availabilitylistitem->lastMinute.'<br>' : '';
						} else { echo '';} ?> </td>	 
				<td> <?php if(isset($room->guarantee_method)){
						foreach($room->guarantee_method as $val){
							echo "url: ".$val->url."<br>";
							echo "isCC: ".$val->isCC."<br>";
							echo "type: ".$val->type."<br>";
							echo "-------<br>";
						}
						} else { echo '';} ?> </td>						
				<td> <?php if(isset($room->cancel_policy)){
						echo "cancel_policy_type_id: ";
						echo isset($room->cancel_policy->cancel_policy_type_id)   ? $room->cancel_policy->cancel_policy_type_id.'<br>' : '';
						echo "cancel_policy_action_id: ";
						echo isset($room->cancel_policy->cancel_policy_action_id)   ? $room->cancel_policy->cancel_policy_action_id.'<br>' : '';
						echo "cancel_policy_value: ";
						echo isset($room->cancel_policy->cancel_policy_value)   ? $room->cancel_policy->cancel_policy_value.'<br>' : '';
						echo "typeDescription: ";
						echo isset($room->cancel_policy->typeDescription)   ? $room->cancel_policy->typeDescription.'<br>' : '';
						echo "actionDescription: ";
						echo isset($room->cancel_policy->actionDescription)   ? $room->cancel_policy->actionDescription.'<br>' : '';
						} else { echo '';}?> </td>
				<td> <?php echo isset($room->cancellation_timestamp)   ? $room->cancellation_timestamp : ''; ?></td>
				<td> <?php if(isset($room->cancellation_till_time)){
						foreach($room->cancellation_till_time as $val){
							echo $val;
						}						
						} else {echo '';}?></td>
				<td> <?php echo isset($room->cancelation)   ? $room->cancelation : ''; ?></td>
				<td> <?php echo isset($room->hotdeal)   ? $room->hotdeal : ''; ?></td>
				<td> <?php echo isset($room->req_cc)   ? $room->req_cc : ''; ?></td>
				<td> <?php echo isset($room->rate_type_name_visible)   ? $room->rate_type_name_visible : ''; ?></td>
				<td> <?php echo isset($room->rate_type_name_default)   ? $room->rate_type_name_default : ''; ?></td>
				<td> <?php echo isset($room->specialdeal_title)   ? $room->specialdeal_title : ''; ?></td>
				<td> <?php echo isset($room->has_dinner)   ? $room->has_dinner : ''; ?></td>
				<td> <?php echo isset($room->rate_type_name)   ? $room->rate_type_name : ''; ?></td>
				<td> <?php echo isset($room->dealParity)   ? $room->dealParity : ''; ?></td>
				<td> <?php echo isset($room->breakfast_included)   ? $room->breakfast_included : ''; ?></td>
				<td> <?php echo isset($room->provider)   ? $room->provider : ''; ?></td>
				<td> <?php echo isset($room->arrangement)   ? $room->arrangement : ''; ?></td>
				<td> <?php echo isset($room->special)   ? $room->special : ''; ?></td>
				<td> <?php echo isset($room->show)   ? $room->show : ''; ?></td>
				<td> <?php echo isset($room->discount)   ? $room->discount : ''; ?></td>
				<td> <?php echo isset($room->smartDealDiscount)   ? $room->smartDealDiscount : ''; ?></td>
				<td> <?php if(isset($room->all_agents->cityTax)){
								foreach($room->all_agents->cityTax as $val){
									echo "amount: ".$val->amount."<br>";
									echo "type: ".$val->type."<br>";
									echo "included: ".$val->included."<br>";
									echo "description: ".$val->description."<br>";
									echo "useGrossAmount: ".$val->useGrossAmount."<br>";
									echo "name: ".$val->name."<br>";
									echo "included_price: ".$val->included_price."<br>";
								}
							}else { echo '';}?>
            </tr>
			<?php endforeach ?>	
        </table>
	</div>
		
	<?php else: ?>
		<p><strong>NO ROOM</strong></p>		
	<?php endif ?>	