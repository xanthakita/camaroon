<?php

	require_once("./vendor/autoload.php");

	class mongoTest {

		function __construct()
		{
			$this->db = ( new MongoDB\Client )->beerlist->taplist;
		}

		public function insertNewItem( $itemInfo = [] )
		{
			if( empty( $itemInfo ) ) {
				return false;
			}
			// must not be empty if it got here insert it
			
			$insertable = $this->db->insertOne([
				'tap_number' => $itemInfo['tap_number'], 
				'Brewery' => $itemInfo['brewery'],   
				'Brew' => $itemInfo['brew'],
				'ABV' => $itemInfo['abv'],  
				'Price' => $itemInfo['price'], 
				'Pour' => $itemInfo['pour'], 
				'description' => $itemInfo['description']
			]);
			return $insertable->getInsertedId();	
		
		}

		public function getCount()
		{
			return $this->db->count();
		}

		public function findCurrentTap( $itemInfo )
		{
			//echo "in findCurrentTap: $itemInfo".PHP_EOL;
			/* if( empty( $itemInfo ) ) {
				return false;
			} */
			$keys = array("tap_number");
			$findarray = array_fill_keys($keys, intval($itemInfo) );
			//var_dump($findarray);
			$retval = $this->db->findOne( $findarray );
			return $retval;
		}

		public function findAll($first_tap, $last_tap )
		{
			$retval ="";
			$keys = array("tap_number");
			for($x=intval($first_tap) ; $x<=intval($last_tap) ; $x++) {
			$findarray = array_fill_keys($keys, $x );
			$tap = $this->db->findOne( $findarray );
			$retval.="<tr><td>#".$tap->tap_number."<td>".$tap->Brewery." ".$tap->Brew."<td>".$tap->ABV * 100;
			$retval.="%<td>".$tap->Pour."Oz.<td>$".money_format("%.2n", $tap->Price);
			}
			return $retval;

		}

		public function getAll( )
		{
   			$cursor = $this->db->find();

		return $cursor;


		}

		public function findAll_test( )
		{
   			$cursor = $this->db->find(
			    [
	        	    'tap_number' =>  array( '$gt' => 0)
	       		    ]
		        );

		return $cursor;


		}
/*
		public function getTaps_Greer( )
		{
   			$cursor = $this->db->find(
			    [
				    'tap_number' =>  array( '$gt' => 0),
				    'Location' => array( '$eq' => "Greer")
	       		    ]
		        );

   			$cursor=$this->db->sort(array('tap_number' => 1));
		return $cursor;
		}
/*/
		public function getTaps_Greer( )
		{
			$query = array('Location' => array( '$eq' => 'Greer'));
			$options = array('sort' => array('tap_number' => 1));
   			// $cursor = $this->db->find($query )->sort( array('tap_number' => 1));
				$cursor = $this->db->find($query, $options );
		return $cursor;
		}
			
		public function getItem( $id )
		{
   			$cursor = $this->db->find(
			    [
				    '_id' =>  array( '$eq' => $id)
	       		    ]
		        );
		return $cursor;
		}
		
		public function getTaps_Landrum( )
		{
   			$cursor = $this->db->find(
			    [
				    'tap_number' =>  array( '$gt' => 0),
				    'Location' => array( '$eq' => "Landrum" )
	       		    ]
		        );
   			$cursor=$this->db->sort(array('tap_number' => 1));
		return $cursor;
		}



		public function update()
		{
			//echo "<pre>"; var_dump($_POST);
			$cursor = $this->db->updateOne(
				[
					'_id' => array( '$eq' => $_POST['_id'])
				],
				[
					'$set' => [ 'Location' => $_POST['Location'],
								'tap_number' => (int)$_POST['tap_number'],
								'SKU' => $_POST['SKU'],
								'Brewery' => $_POST['Brewery'],
								'Brew' => $_POST['Brew'],
								'ABV' => (float)$_POST['ABV'],
								'Price' => (float)$_POST['Price'],
								'Pour' => $_POST['Pour'],
								'Category' => $_POST['Category'],
								'Type' => $_POST['Type'],
								'Rating' => (float)$_POST['Rating'],
								'Discount' => (float)$_POST['Discount'],
								'Description' => $_POST['Description']
							  ]
				]);
			//echo "<pre> test:".PHP_EOL; var_dump($e->getWriteResult()->getWriteErrors());
			//exit;
		}
	}


?>
