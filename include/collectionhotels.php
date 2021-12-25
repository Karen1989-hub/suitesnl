
<?php 

	// if (!isset($server)) {
	//     include './server.php';
	//     $server = new Server();
	// }

	if (!isset($db)) {
		include 'include/db.php';
		$db = getdb();
	}

	$data = [];

	function getSuitesByCollectionId($suitesid){
		global $db;

        $sql = "SELECT * FROM property
         INNER JOIN suitescollection ON property.id = suitescollection.propertyid 
         WHERE suitescollection.suitesid = :suitesid";        

        $smtp = $db->prepare($sql);
        $smtp->execute([
            "suitesid"  => $suitesid,
        ]);
        $result = $smtp->fetchAll(\PDO::FETCH_ASSOC);
        return $result;

    }

	if (isset($collectionid)) {

		$data = getSuitesByCollectionId( $collectionid);

		// echo "<pre>";
		// print_r($data);die;

	}


		



?>

        
       <table>            
				<th> id </th>
				<th> naam </th>
				<th> url </th>
				<th> priority </th>
				<th> address </th>
				<th> house_number </th>
				<th> postal_code </th>
				<th> city </th>
				<th> province </th>
				<th> stars </th>
				<th> number_of_rooms </th>
				<th> checkinfrom </th>
				<th> checkintill </th>
				<th> checkoutfrom </th>
				<th> checkouttill </th>
				<th> titel </th>
				<th> usp1 </th>
				<th> usp2 </th>
				<th> usp3 </th>
				<th> hoteltext </th>
				<th> propertyid </th>
				<th> suitesid </th>				
			<?php foreach($data as $val): ?>
	            <tr>                 
		            <td><?php echo isset($val['id']) ? $val['id'] : ''; ?></td>           
					<td><a href="/<?php echo isset($val['url']) ? $val['url'] : ''; ?>/"><?php echo isset($val['naam']) ? $val['naam'] : ''; ?></a></td>    
					<td><?php echo isset($val['url']) ? $val['url'] : ''; ?></td>     
					<td><?php echo isset($val['priority']) ? $val['priority'] : ''; ?></td>   
					<td><?php echo isset($val['address']) ? $val['address'] : ''; ?></td>     
					<td><?php echo isset($val['house_number']) ? $val['house_number'] : ''; ?></td>     
					<td><?php echo isset($val['postal_code']) ? $val['postal_code'] : ''; ?></td>     
					<td><?php echo isset($val['city']) ? $val['city'] : ''; ?></td>     
					<td><?php echo isset($val['province']) ? $val['province'] : ''; ?></td>    
					<td><?php echo isset($val['stars']) ? $val['stars'] : ''; ?></td>    
					<td><?php echo isset($val['number_of_rooms']) ? $val['number_of_rooms'] : ''; ?></td>    
					<td><?php echo isset($val['checkinfrom']) ? $val['checkinfrom'] : ''; ?></td>    
					<td><?php echo isset($val['checkintill']) ? $val['checkintill'] : ''; ?></td>    
					<td><?php echo isset($val['checkoutfrom']) ? $val['checkoutfrom'] : ''; ?></td>    
					<td><?php echo isset($val['checkouttill']) ? $val['checkouttill'] : ''; ?></td>    
					<td><?php echo isset($val['titel']) ? $val['titel'] : ''; ?></td>    
					<td><?php echo isset($val['usp1']) ? $val['usp1'] : ''; ?></td>    
					<td><?php echo isset($val['usp2']) ? $val['usp2'] : ''; ?></td>    
					<td><?php echo isset($val['usp3']) ? $val['usp3'] : ''; ?></td>    
					<td><?php echo isset($val['hoteltext']) ? $val['hoteltext'] : ''; ?></td>    
					<td><?php echo isset($val['propertyid']) ? $val['propertyid'] : ''; ?></td>    
					<td><?php echo isset($val['suitesid']) ? $val['suitesid'] : ''; ?></td>  
					</tr>
			<?php endforeach;?>
        </table>
		
<?php echo isset($val['naam']) ? $val['naam'] : ''; ?>