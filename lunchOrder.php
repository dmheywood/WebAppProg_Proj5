<?php
require_once("db_connect.php");

mysqli_select_db($conn, "shared");

$selectQuery = "SELECT  `id` , `displayName` ,  `price` ,  `menu` ,  `attrs` 
FROM  `imperial_china_menu` 
WHERE  `menu` =  'lunch'";

$selectResult = mysqli_query($conn, $selectQuery);

// test the result to see if it succeeded
if (!$selectResult) {
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
<link rel="stylesheet" type="text/css" href="styles.css">
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
        <h2>Lunch Menu</h2>
        <div id="restaurant_menu">
          <h2>Order Lunch Online for Take-Out</h2>
          <p>Please fill in how many of each item you would like, and click the "Place Order" button.</p>
          <form action="confirmation.php" method="post">
            <p>
              <label for="yourName">Your name:</label>
              <input type="text" required name="yourName" id="yourName">
            </p>
            <p>
              <label for="email">Your e-mail address:</label>
              <input type="email" required name="email" id="email">
            </p>
            <p>
              <label for="phoneNumber">Your phone number:</label>
              <input type="tel" required name="phoneNumber" id="phoneNumber">
            </p>
            <table style="width:100%">
              <?php
// a while loop does the stuff in the{} over and over
// as long as the thing in the () is true;
// the following loops continues to get the next row
// and the go into the {}, until there are no more rows
while($row = mysqli_fetch_assoc($selectResult)) {
// $row is like $_POST, with named sections inside it.
// Each section name is a field name in the database table.
// for example: 'pet_name', "owner_name', etc.
?>
              <tr>
                <td style="width:10%"><input type="text" name="order[<?php echo($row['id']);?>]" value="0" size="2" maxlength="2"></td>
                <td><?php echo($row['displayName']); if ($row['attrs'] == 'hotSpicy') {
					echo("<strong> *</strong>");}?></td>
                <td style="width:10%"> $<?php echo($row['price']);?></td>
              </tr>
              <?php
}
// get a single row from the result set.
?>
            </table>
            <p>
              <input type="submit" name="submit" id="submit" value="Place Order">
            </p>
          </form>
          <h3>&nbsp;</h3>
        </div>
        <p>&nbsp;</p>
      </div>
    </div>
  </div>
  <div id="footer">
    <div id="address">
      <p>Imperial China Chinese Restaurant   <br />
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
