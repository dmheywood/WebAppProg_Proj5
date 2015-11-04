<?php
require_once("db_connect.php");
$conn2 = mysqli_connect("localhost", "DavidMHeywood", "2Bor!2b?");
if (!$conn) {
	die("Your connection died a miserable death");
}

mysqli_select_db($conn, "shared");
mysqli_select_db($conn2, "DavidMHeywood");

// list of variables
$yourName = $_POST['yourName'];
$email = $_POST['email'];
$phoneNumber = $_POST['phoneNumber'];
$orderCode = $_POST['orderCode'];
$quantity = $_POST['quantity'];

$selectQuery = "SELECT
`imperial_china_menu`.`id` AS `item_id`,
`imperial_china_menu`.`displayName` AS `name`,
`imperial_china_menu`.`price` AS `price`  
FROM 
`imperial_china_menu` 
WHERE
`menu`= 'lunch' AND `id` = '%s'";

$selectResult = mysqli_query($conn, $selectQuery);

if(!$selectResult) {
	die("Couldn't select from the imperial_china_menu table");
}
// if we are here, the SELECT was successful, so we can use
// that data. Chack below between the body tags
?>

<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Imperial China Chinese Restaurant: Order Online!</title>
<link rel="stylesheet" type="text/css" href="styles.css"/>
</head>
<body>
<div id="wrapper">
  <div id="wrapper_inner">
    <div id="inner_logo">
      <div id="header">
        <h1>Imperial China Chinese Restaurant</h1>
        <h2>Voted Greater Portland's Best Chinese Restaurant from 1995 through 2008</h2>
        <p>220 Maine Mall Road (Mall Plaza)</p>
        <p> South Portland, Maine 04106</p>
        <p>Phone: (207) 774-4292</p>
      </div>
      <div id="menu">
        <ul>
          <li id="menu_home"><a href="#">Home</a></li>
          <li id="menu_menu"><a href="#">Menu</a></li>
          <li id="menu_about"><a href="#">About Us</a></li>
          <li id="menu_contact"><a href="#">Contact Us</a></li>
        </ul>
      </div>
      <div id="info">
        <ul>
          <li>Hunan Restaurant </li>
          <li>Fine Dining </li>
          <li>Phone Orders</li>
        </ul>
      </div>
      <div id="pageContent">
        <h2>Your Order Summary</h2>
        <div id="restaurant_menu">
          <table>
            <tr>
              <th>Item</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Subtotal</th>
            </tr>
            <?php 
	foreach ($_POST['order'] as $orderId => $quantity) {	
	 if($quantity > 0){		
	$custOrder = sprintf($selectQuery, $orderId);
	
	
	$lineItem = mysqli_query($conn, $custOrder);
			
	$row = mysqli_fetch_assoc($lineItem);
	
	$insertQuery = "INSERT INTO `imperialChina`(`orderCode`, `quantity`, `yourName`, `email`, `phoneNumber`) VALUES ('%s','%s','%s','%s','%s')";
	
	$completeInsert = sprintf($insertQuery,
							$orderId,
							$quantity,							
							$yourName,
							$email,
							$phoneNumber
							);							
				
// actually do the insert
mysqli_query($conn2, $completeInsert); 
?>
            <tr>
              <?php
    $price = $row['price'];
	$subtotal = ($row['price'] * $quantity);
	$pricef = sprintf("%.2f", $price);
	$subtotalf = sprintf("%.2f", $subtotal);	
	$total +=  $subtotalf;
	$totalf = sprintf("%.2f", $total);
?>
              <td><?php echo($row['name']); ?></td>
              <td align="right"> $<?php echo ($pricef); ?></td>
              <td align="right"><?php echo($quantity); ?></td>
              <td align="right"> $<?php echo($subtotalf); ?></td>
            </tr>
            <?php
	 }
}
?>
          </table>
          <h3> ORDER TOTAL: $<?php echo($totalf) ?> </h3>
          <p><a href="lunchOrder.php">back to lunch menu</a></p>
          <h3>&nbsp;</h3>
        </div>
        <p>&nbsp;</p>
      </div>
    </div>
  </div>
  <div id="footer">
    <div id="address">
      <p>Imperial China Chinese Restaurant  <br />
        Address: 220 Maine Mall Road (Mall Plaza) <br />
        South Portland, Maine 04106<br />
        Phone: (207) 774-4292<br />
        E-mail: <a href="mailto:imperialchina@maine.com">imperialchina@maine.com</a></p>
    </div>
    <div id="hours">
      <p>Hours of Operation:<br />
        Sunday - Thursday 11:00 AM to 9:30 PM<br />
        Friday - Saturday 11:00 AM to 10:30 PM<br />
        We Speak: Chinese &amp; English<br />
      </p>
    </div>
    <div id="cc"> We Accept:
      <ul>
        <li id="li_amex"><span>American Express</span></li>
        <li id="li_discover"><span>Discover</span></li>
        <li id="li_mc"><span>Master Card</span></li>
        <li id="li_visa"><span>VISA</span></li>
      </ul>
    </div>
  </div>
</div>
</body>
</html>
<?php mysqli_close($conn); ?>
<?php mysqli_close($conn2); ?>