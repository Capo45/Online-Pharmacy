<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 session_start();
 $db_host = getenv('DB_HOST');
 $db_user = getenv('DB_USER');
 $db_password = getenv('DB_PASSWORD');
 $db_name = getenv('DB_NAME');
 $db_port = getenv('DB_PORT');  
 $conn="";

$conn=new mysqli($db_host, $db_user, $db_password, $db_name, $db_port);

$user=$_SESSION['user_id'];

 $item="SELECT p.Product_id, p.Product_Name,p.Brief_Description, p.Price,p.Product_Description,p.Image_path, c.Quantity , c.user_id
 FROM products p 
 LEFT JOIN cart c ON p.Product_id = c.Product_id
 WHERE c.Quantity>=1 AND c.user_id=$user;";
 $result = mysqli_query($conn,$item);

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $name=$_POST['name'];
    $surname=$_POST['surname'];
    $address_1=$_POST['address1'];
    $address_2=$_POST['address2'];
    $postal_code=$_POST['postalCode'];
    $floor=$_POST['floor'];
    $apartment=$_POST['apartment'];
    $phone=$_POST['Phone'];
    $email=$_POST['email'];
    $additional_comments=$_POST['comments'];
    $receipt_id=random_int(100000, 999999);
    $bill="INSERT INTO receipts(Receipt_id,Firstname,Surname,Address_1,Address_2,Postal_code,Floor,Apartment,Phone,Email,Additional_comments)
    VALUES('$receipt_id','$name','$surname','$address_1','$address_2','$postal_code','$floor','$apartment','$phone','$email','$additional_comments');";
    $generate=mysqli_query($conn,$bill);
    header("Location:Order received.php");
    exit();
  }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Delivery Details Form</title>
        <meta charset="UTF-8">
        <meta name="description" content="MCPharm is your trusted online pharmacy offering medications, wellness products, supplements, dental care, and cosmetics with fast delivery and personalized support.">
        <meta name="keywords" content="online pharmacy, medications, supplements, dental health, cosmetics, wellness products, MCPharm">
        <meta name="author" content="MCPharm">
        <meta name="viewport" content="width=device-width, initial-scale=0.75">
        <link rel="icon" href="Images/Navigation bar/tab icon.png" type="image/png">
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
    <section class="navigation_bar">
    <div class="sidenav" id="sidenav">
    <div id="sidemenu_top"><a href="index.html"><img src="Images/Navigation bar/logo.png" id="side-logo"></a> 
    <button id="close_sidenav" onclick="closeNav()"><img src="Images/Navigation bar/exit.png"></button></div>
     <div class="categories">
        <label for="check1"><img src="Images/Navigation bar/down.png" id="arrow"></label>
        <input type="checkbox" id="check1" class="checkbox">
        <a class="categ" href="Search results page.php?category=Medications">Medications</a>
        <div id="submenu1" class="submenus">
        <a href="Search results page.php?sub_category=Pain relief">Pain relief</a></li>
        <br><a href="Search results page.php?sub_category=Digestive Health">Digestive Health</a></li>
        <br><a href="Search results page.php?sub_category=Allergy & Cold">Allergy & Cold</a></li>
        <br><a href="Search results page.php?sub_category=Chronic Condition Management">Chronic Condition Management</a></li>
    </div>
    </div>
    
    
    <div class="categories">
        <label for="check2"><img src="Images/Navigation bar/down.png" id="arrow"></label>
        <input type="checkbox" id="check2" class="checkbox">
        <a class="categ" href="Search results page.php?category=Supplements">Supplements</a>
        <div id="submenu2" class="submenus">
        <a href="Search results page.php?sub_category=Multi-Vitamins">Multi-Vitamins</a>
        <br><a href="Search results page.php?sub_category=Minerals">Minerals</a>
        <br><a href="Search results page.php?sub_category=Herbal Supplements">Herbal Supplements</a>
        <br><a href="Search results page.php?sub_category=Fitness & Sports Nutrition">Fitness & Sports Nutrition</a></> 
        </div>
    </div>
      
        <div class="categories">
            <label for="check3"><img src="Images/Navigation bar/down.png" id="arrow"></label>
            <input type="checkbox" id="check3" class="checkbox">
            <a class="categ" href="Search results page.php?category=Dental">Dental Health</a>
            <div id="submenu3" class="submenus">
                <a href="Search results page.php?sub_category=Toothpaste">Toothpaste</a>
                <br><a href="Search results page.php?sub_category=Mouth Wash">Mouth Wash</a>
                <br><a href="Search results page.php?sub_category=Dental floss">Dental floss</a>
                <br><a href="Search results page.php?sub_category=Toothbrushes">Toothbrushes</a>
            </div>    
        </div>
        <div class="categories">
            <label for="check4"><img src="Images/Navigation bar/down.png" id="arrow"></label>
            <input type="checkbox" id="check4" class="checkbox">
            <a class="categ" href="Search results page.php?category=cosmetics">Cosmetics</a>
            <div id="submenu4" class="submenus">
                <a href="Search results page.php?sub_category=Skin Care Products">Skin Care Products</a>
                <br><a href="Search results page.php?sub_category=Makeup">Makeup</a>
                <br><a href="Search results page.php?sub_category=Fragrances">Fragrances</a>
                <br><a href="Search results page.php?sub_category=Hair dyes">Hair dyes</a> 
            </ul>
        </div>
    </div>
    </div>
    <div class="strp">
      <button id="sidemenu" onclick="openNav()"><img src="Images/Navigation bar/menu.png" id="sidemenu_image"></button>
      <a href="index.html"><img src="Images/Navigation bar/logo.png" style="width: 3.938rem;height: 3rem; padding-left: 2rem; padding-top: 0;"></a>
        
       <form action="Search results page.php" method="GET">
         <div class="searchbar_wrapper"><input type="search" placeholder="Search Item......." name="Searchbar"
            class="searchbar">
         </div></form> 
         <a href="Shopping Cart.php"><img src="Images/Navigation bar/shopping cart icon.png"  id="cart_icon"></a>
     </div>
     </section>

   <section class="details_section">
   <form method="POST">
   <div class="details_container" style="animation: details 1s;">
    <p class="product_title" style="margin-left: 1rem;">Delivery Details</p>
    <ul>
        <li><label class="details">Name: </label><br><input class="fields" type="text" name="name" required></li><br>
        <li><label class="details">Surname: </label><br><input class="fields" type="text" name="surname" required></li>
        <li><label class="details">Address 1:</label><br><input class="fields" type="text" name="address1" placeholder="State, City...." required></li><br>
        <li><label class="details">Address 2:<label><br><input class="fields" type="text" name="address2" placeholder="Street, Building...."></li><br>
        <li><label class="details">Postal code:</label><input id="mini" class="fields" type="number" name="postalCode" maxlength="5" required><br><br>
        <label class="details">Floor: </label><input id="mini"  class="fields" type="number" name="floor" required><br><br>   
        <label class="details">Apartment:</label><input id="mini"  class="fields" type="number" name="apartment" required></li><br>
        <li><label class="details">Phone:</label><br><input class="fields" type="tel" name="Phone" placeholder="Ex: (123) 456 789"
         maxlength="10" minlength="10" required></li><br>
        <li><label class="details">Email:</label><br><input class="fields" type="email" name="email" placeholder="Ex: 123@email.com" required></li><br>
        <li><label class="details">Additional Comments:</label><br><input id="comment" class="fields" type="text" name="comments" placeholder="Additional comments" maxlength="50"></li>
    </ul>

    <input class="place_order" type="submit" value="Place Order">
   </div></form>

   <div class="details_container" style="animation: bills 2s;"><p class="product_title" style="margin-left: 1rem;">Items</p>
   <div style="background-color: #ec4747a2; border-radius:0.5rem;border-style:none;padding:0.5rem"><?php $total=0;
     while($items=mysqli_fetch_assoc($result)){
        $product_name=$items['Product_Name'];
        $quantity=$items['Quantity'];
        $price=(int)$items['Price'] * (int)$items['Quantity'];
        $total=$total+$price;
   ?>

   <p class="bill"><?php echo $quantity; echo"X "; echo $product_name; echo ":   $"; echo $price;?></p>  
   <?php } ?></div>
   <p class="bill" id="total">Your total is: $<?php echo $total ?></p>
   </div>
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

   <script>
    function openNav() {
     document.getElementById("sidenav").classList.add("active");}

   function closeNav() {
    document.getElementById("sidenav").classList.remove("active");}
    </script>
    </body>
</html>