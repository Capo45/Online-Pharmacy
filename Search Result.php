<?php
$db_server="127.0.0.1";
$db_user = "newuser";
$db_pass = "12345678.m";
$db_name="mcpharm";
$port=3306;
$conn="";

$conn=new mysqli($db_server ,
 $db_user , $db_pass , $db_name , $port);
 try {

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $cart_id = $_POST['id'];

      $stmt = $conn->prepare("INSERT INTO cart (Product_id, Quantity) VALUES (?,'1')");
      $stmt->bind_param("i", $cart_id); 
      
      if ($stmt->execute()) {
          echo "Product added to cart successfully.";
      } else {
          echo "Error adding product to cart: " . $stmt->error;
      }

      // Close the statement
      $stmt->close();
  }
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}
   if (isset($_GET['Searchbar'])) {

    $search = $conn->real_escape_string($_GET['Searchbar']);
    
    $sql = "SELECT * FROM products WHERE Product_Name LIKE '%$search%' OR Brief_Description LIKE '%$search%' OR Category LIKE '%$search%'";
    $result = $conn->query($sql);
   }
   elseif (isset($_GET['category'])) {
    $search = $conn->real_escape_string($_GET['category']);
    $sql = "SELECT * FROM products WHERE category LIKE '%$search%';";
    $result = $conn->query($sql);
}
elseif (isset($_GET['sub_category'])) {
  $search = $conn->real_escape_string($_GET['sub_category']);
  $sql = "SELECT * FROM products WHERE Sub_category LIKE '%$search%';";
  $result = $conn->query($sql);
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
                       <th><a href="Shopping Cart.php"><img src="Images/Navigation bar/shopping cart icon.png"  style="width: 1.7rem; height: 1.7rem;"></a></th>
                  </tr>
            </table>
     </section>


     <section style="display: flex;
                     flex-wrap: wrap;
                     width: 100%;
                     margin-top: 7rem;">
     <?php

      while($item=mysqli_fetch_assoc($result))
      {
      
      ?><form method="POST" >
        <div class="product-box"> 
        <img class="product-image" src="<?php echo htmlspecialchars($item['Image_path']); ?>" class="advice_images">
          <a href="Product View page.php?product_id=<?php echo htmlspecialchars($item['Product_id']);?>"
           style="text-decoration: none;
           font-size: 1.125rem;
           font-weight: bold;
           margin-bottom: 0.5rem;
           padding-left:1rem;
           padding-top:1.5rem;
           padding-right:0.3rem;
          color: #000000;"><?php $product_name = htmlspecialchars($item['Product_Name']); 
                                          echo strlen($product_name) > 30 ? substr($product_name, 0, 30)
                                          . '...' : $product_name;?></a>
         <p class="product-description"><?php $product_description = htmlspecialchars($item['Brief_Description']); 
                                          echo strlen($product_description) > 30 ? substr($product_description, 0, 30) 
                                          . '...' : $product_description; ?></p>
          <p class="product-description">$<?php echo htmlspecialchars($item['Price']); ?></p>

            <input type="submit" class="add-to-cart-btn" name="add_to_cart" value="Add To Cart">
            <input type="hidden" class="add-to-cart-btn" name="id" value="<?php echo htmlspecialchars($item['Product_id']); ?>">
      </div></form>
      <?php
      }
      ?>
     </section>
        
     <!--Page Footer containing payment options, links to relevant pages and contact tools-->
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
            <a href="https://www.instagram.com/capo_2439/"><img src="Images/Footer/insta_logo_black.png" alt="Instagram"></a>
            <a href="#"><img src="Images/Footer/tiktok_icon_black.png" alt="TikTok"></a>
            <a href="#"><img src="Images/Footer/whatsapp_logo.png" alt="Whatsapp"></a>
          </div>
        </div>
      
        <div class="copyright">
          <p>&copy; 2024 MCPharm. All rights reserved.</p>
        </div>
      </footer>

<?php
   
?> 
</body>

</html>