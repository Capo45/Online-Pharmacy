<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 session_start();
$config = require 'config.php';  
$db_host = $config['DB_HOST'];
$db_user = $config['DB_USER'];
$db_password = $config['DB_PASSWORD'];
$db_name = $config['DB_NAME'];
$db_port = $config['DB_PORT']; 
$GLOBALS['conn']="";

$GLOBALS['conn']=new mysqli($db_host, $db_user, $db_password, $db_name, $db_port);
function generateRandomUserId() {
  return random_int(100000, 999999); // Generates a random 6-digit number
}

if(!isset($_SESSION['user_id'])){
  $_SESSION['user_id']=generateRandomUserId(); 
  $stmt = $mysqli->prepare("INSERT INTO users (user_id) VALUES (?)");
  $stmt->bind_param("i", $_SESSION['user_id']);
}
$user=$_SESSION['user_id'];
  
if($_SERVER["REQUEST_METHOD"]=="POST"){
  $action=$_POST['action'];
  $p_id=$_POST['product_id'];
  $new_quantity=$_POST['quantity'];
  switch($action){
   case'update':{
    if($new_quantity !='other'){
      $update="UPDATE cart c SET c.Quantity= $new_quantity WHERE c.Product_id= $p_id AND c.user_id=$user;";
      $run=mysqli_query($GLOBALS['conn'],$update);
    }
    elseif($new_quantity='other'&&isset($_POST['other'])){
      $new_quantity=$_POST['other'];
      $other="UPDATE cart c SET c.Quantity= $new_quantity WHERE c.Product_id= $p_id AND c.user_id=$user;";
      $run_other=mysqli_query($GLOBALS['conn'],$other);
    }
     break;
  }
  
  case'trash':{
   $remove="DELETE FROM cart  WHERE Product_id=$p_id AND user_id=$user;";
   $run=mysqli_query($GLOBALS['conn'],$remove);
   break;
  }
  }}

  $item="SELECT p.Product_id, p.Product_Name,p.Brief_Description, p.Price,
  p.Product_Description,p.Image_path, c.Quantity 
        FROM products p 
        LEFT JOIN cart c ON p.Product_id = c.Product_id
        WHERE c.Quantity>=1 AND c.user_id=$user;";
  $result = mysqli_query($GLOBALS['conn'],$item);

?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Online Pharmacy website</title>
        <meta charset="UTF-8">
        <meta name="description" content="MCPharm is your trusted online pharmacy offering medications, wellness products, supplements, dental care, and cosmetics with fast delivery and personalized support.">
        <meta name="keywords" content="online pharmacy, medications, supplements, dental health, cosmetics, wellness products, MCPharm">
        <meta name="author" content="MCPharm">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!--Navigation bar on top of page implemented using a table and unordered lists for submenus-->
        <section class="navigation_bar">
            <table class="strp">
                <tr>
                    <th id="logo"><a href="homepage.html"><img src="Images/Navigation bar/logo.png" style="width: 5.938rem;height: 4.375rem;"></a></th>
                    <th class="navheading"><h2><a href="Search results page.php?category=Medications">Medications</a></h2>
                    <ul id="submenu1" class="submenus">
                        <li><a href="Search results page.php?sub_category=Pain relief">Pain relief</a></li>
                        <li><a href="Search results page.php?sub_category=Digestive Health">Digestive Health</a></li>
                        <li><a href="Search results page.php?sub_category=Allergy & Cold">Allergy & Cold</a></li>
                        <li><a href="Search results page.php?sub_category=Chronic Condition Management">Chronic Condition Management</a></li>
                    </ul>
                    </th>
                    <th  class="navheading"><h2><a href="Search results page.php?category=Supplements">Supplements</a></h2>
                        <ul id="submenu2" class="submenus">
                            <li><a href="Search results page.php?sub_category=Multi-Vitamins">Multi-Vitamins</a></li>
                            <li><a href="Search results page.php?sub_category=Minerals">Minerals</a></li>
                            <li><a href="Search results page.php?sub_category=Herbal Supplements">Herbal Supplements</a></li>
                            <li><a href="Search results page.php?sub_category=Fitness & Sports Nutrition">Fitness & Sports Nutrition</a></li> 
                        </ul></th>
                    <th class="navheading"><h2><a href="Search results page.php?category=Dental">Dental Health</a></h2>
                        <ul id="submenu3" class="submenus">
                            <li><a href="Search results page.php?sub_category=Toothpaste">Toothpaste</a></li>
                            <li><a href="Search results page.php?sub_category=Mouth Wash">Mouth Wash</a></li>
                            <li><a href="Search results page.php?sub_category=Dental floss">Dental floss</a></li>
                            <li><a href="Search results page.php?sub_category=Toothbrushes">Toothbrushes</a></li>
                        </ul></th>
                    <th class="navheading"><h2><a href="Search results page.php?category=cosmetics">Cosmetics</a></h2>
                        <ul id="submenu4" class="submenus">
                            <li><a href="Search results page.php?sub_category=Skin Care Products">Skin Care Products</a></li>
                            <li><a href="Search results page.php?sub_category=Makeup">Makeup</a></li>
                            <li><a href="Search results page.php?sub_category=Fragrances">Fragrances</a></li>
                            <li><a href="Search results page.php?sub_category=Hair dyes">Hair dyes</a></li> 
                        </ul></th>
                        <form action="Search results page.php" method="GET">
                       <th><div class="searchbar_wrapper"><input type="search" placeholder="Search Item......." name="Searchbar"
                        class="searchbar">
                           </div></th>
                       </form> 
                        <th><a href="#"><img src="Images/Navigation bar/shopping cart icon.png"  style="width: 1.7rem; height: 1.7rem;"></a></th>
                  </tr>
            </table>
     </section>

     <p class="product_title" style="margin-left: 1.5rem; margin-top: 8rem;">Shopping Cart</p>
     <section style="animation:cart 1s;">
      <?php  $total=0;
                foreach($result as $cart_item) {
       ?><form method="POST">
        <div class="cart_items">
            <img src="<?php echo $cart_item['Image_path']; ?>" class="cart_item_image">
            <ul>
                <a href="Product View page.php?product_id=<?php echo htmlspecialchars($cart_item['Product_id']); ?>">
                  <li class="cart_item_title"><?php $product_name = htmlspecialchars($cart_item['Product_Name']); 
                                          echo strlen($product_name) > 45 ? substr($product_name, 0, 45)
                                          . '...' : $product_name; ?></li></a>
                <li class="cart_item_description"><?php $product_desc = htmlspecialchars($cart_item['Brief_Description']); 
                                          echo strlen($product_desc) > 45 ? substr($product_desc, 0, 45)
                                          . '...' : $product_desc; ?></li>
                <li class="cart_item_price">
                  $<?php $price=(int)$cart_item['Price'] * (int)$cart_item['Quantity']; echo $price;
                   $total=$total+$price; $prod=$cart_item['Product_id'];?>
                </li>
                <li>
                <select name="quantity"
                 style="height:2.3rem; width:5rem; font-size:1.5rem;
                        font-family:serif;border-radius: 0.5rem; border:0.1rem #9c0707;
                        border-style:solid; margin-left:1rem; padding-left:0.2rem;">
                <option value="" selected><?php $quantity=$cart_item['Quantity']; echo $quantity; ?></option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="other">other</option>
                </select>
                <input type="hidden" name="product_id" value="<?php echo $prod; ?>">
                <label style="font-size: 1.5rem;font-family:serif; padding-left:1rem;">Please Specify if other:</label>
                <input type="text" name="other" style="border-radius:0.5rem;
                 border:#9c0707 0.1rem; border-style:solid; font-family:serif;font-size:1.5rem; width:5rem;"
                 min="11" max="50" placeholder=" 11->50" value="">             
                <button type="submit" id="update" class="cart_buttons" name="action" value="update">Update</button>

                  <button type="submit" class="cart_buttons" name="action" value="trash">
                    <img src="Images/trash.png" style="width: 1rem;height:1rem;"></button></li>
           </ul>
        </div></form>
        
       <?php 
                }
         
       
       ?>
       <p class="cart_item_title">Your Total is: $<?php echo $total; ?></p><br>
       <?php
       if($result->num_rows>=1){
       ?> 
       <form action="Delivery Details.php"><input type="submit" class="order" value="Confirm Order"></form><?php } ?>
     </section>

     <footer>
            <div class="footer-container">
              <div class="footer-section links">
                <p class="footer_headings">Quick Links</p>
                <ul>
                  <li><a href="#" class="footer_link">About Us</a></li>
                  <li><a href="#" class="footer_link">Services</a></li>
                  <li><a href="#" class="footer_link">Contact</a></li>
                  <li><a href="#" class="footer_link">FAQ</a></li>
                </ul>
              </div>
          
              <div class="footer-section payment-methods">
                <p class="footer_headings">Payment Methods</p>
                <img src="Images/Footer/Visa_Logo.png" alt="Visa"><br>
                <img src="Images/Footer/MasterCard_logo.png" alt="Mastercard"><br>
                <img src="Images/Footer/Paypal-logo.png" alt="PayPal">
              </div>
          
              <div class="footer-section contact-info">
                <p class="footer_headings">Contact Us</p>
                <p>123 Main Street, City, Country</p>
                <p>Email: info@example.com</p>
                <p>Phone: +1 234 567 8900</p>
              </div>
          
              <div class="footer-section social-media">
                <p class="footer_headings">Follow Us</p>
                <a href="#"><img src="Images/Footer/insta_logo_black.png" alt="Instagram"></a>
                <a href="#"><img src="Images/Footer/tiktok_icon_black.png" alt="TikTok"></a>
                <a href="#"><img src="Images/Footer/whatsapp_logo.png" alt="Whatsapp"></a>
              </div>
            </div>
          
            <div class="copyright">
              <p>&copy; 2024 MCPharm. All rights reserved.</p>
            </div>
          </footer>
          
    </body>
</html>