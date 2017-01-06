<!DOCTYPE html>
<html>
<head>
  <title>POs for product scaning</title>
 
</head>
<body>



<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="target" >
  <label style='color:blue'>Please enter your data in (ABCDABAA ,CCCCCCC, ABCDABAAEE) format to test : </label> 
  <input type="text" name="product_txt" />
  <button type="submit" name="submit" id="process">Submit</button>
</form>

<div class="result">
	<?php 
		include 'scan_terminal.php';
		include 'product_inventory.php';
		// Initialize inventory, listings, and terminal objects.
		$product_inventory = new Inventory();
		// Adding Given Product and pricing details 
		$product_inventory->add("A", 2.00, [4=>'7.00']);
		$product_inventory->add("B", 12.00);
		$product_inventory->add("C", 1.25, [6=>6.00]);
		$product_inventory->add("D", 0.15);
		$product_inventory->add("E", 2.15, [8=>20.00]);
		$product_listing = new Listing($product_inventory);
		$terminal = new Terminal($product_listing);
		// Processing form data
		if (isset($_POST["submit"])) {
			$products = $_POST["product_txt"];
			for ($i = 0; $i < strlen($products); $i++) {
				if ($products[$i] != " ")
					$scannable = $terminal->scan($products[$i]);
				// Check whether data scaned or not
				if (!$scannable)
					echo "Unable to get price for: " . $products[$i] . "<br>";
			}

			echo "<br /><br /><br /><b style=color:blue;'>Cost Of Product : " . $products . " is: $" . number_format($terminal->getTotalCost(), 2, '.', ',') . "</b>";
		}
	?>
</div>
</body>
</html>