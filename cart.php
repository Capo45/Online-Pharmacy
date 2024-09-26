<?php
$db_server="127.0.0.1";
$db_user = "newuser";
$db_pass = "12345678.m";
$db_name="mcpharm";
$port=3306;
$GLOBALS['conn']="";

$GLOBALS['conn']=new mysqli($db_server ,
$db_user , $db_pass , $db_name , $port);
  

  $item="SELECT p.Product_id, p.Product_Name,p.Brief_Description, p.Price,p.Product_Description,p.Image_path, c.Quantity 
        FROM products p 
        LEFT JOIN cart c ON p.Product_id = c.Product_id
        WHERE c.Quantity>=1;";
  $result = mysqli_query($GLOBALS['conn'],$item);

if($_SERVER["REQUEST_METHOD"]=="POST"){
  $clear = "DELETE FROM cart";
  $reset = mysqli_query($GLOBALS['conn'],$clear);
  header("Location: Order received.html");
    exit();
}


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
     <section>
      <?php  
                while ($cart_item = mysqli_fetch_assoc($result)) {
       ?><form method="GET" action="Shopping Cart.php">
        <div class="cart_items">
            <img src="<?php echo $cart_item['Image_path']; ?>" class="cart_item_image">
            <ul>
                <a href="Product View page.php?product_id=<?php echo htmlspecialchars($cart_item['Product_id']); ?>"><li class="cart_item_title"><?php $product_name = htmlspecialchars($cart_item['Product_Name']); 
                                          echo strlen($product_name) > 45 ? substr($product_name, 0, 45)
                                          . '...' : $product_name; ?></li></a>
                <li class="cart_item_description"><?php $product_desc = htmlspecialchars($cart_item['Brief_Description']); 
                                          echo strlen($product_desc) > 45 ? substr($product_desc, 0, 45)
                                          . '...' : $product_desc; ?></li>
                <li class="cart_item_price">$<?php echo htmlspecialchars($cart_item['Price']); ?></li>
                <li><button class="cart_buttons"  id="minusBtn">-</button>
                  <input style="font-size: 1.25rem; font-weight:bold; width:1rem; border-style:none;margin-left: 0.45rem;" 
                  id="quantity" value="<?php $quantity=htmlspecialchars($cart_item['Quantity']); echo$quantity; ?>" readonly>
                  <button class="cart_buttons" id="plusBtn">+</button> 
                  <button class="cart_buttons" id="trash"><img src="Images/trash.png" style="width: 1rem;height:1rem;"></button></li>
           </ul>
        </div></form>
       <?php 
       }
       if($result->num_rows>=1){
       ?> 
       <form method="POST"><input type="submit" class="order" value="Confirm Order"></form><?php } ?>
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