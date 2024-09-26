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
      $quantity = $_POST['quantity'];
      $stmt = $conn->prepare("INSERT INTO cart (Product_id, Quantity) VALUES (?,?)");
      $stmt->bind_param("ii", $cart_id, $quantity); 
      
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
   
   if (isset($_GET['product_id'])) {
    
    $product = $conn->real_escape_string($_GET['product_id']);

    $sql = "SELECT * FROM products WHERE Product_id LIKE '%$product%'";
    $related = "SELECT * FROM products WHERE Category_id =( SELECT Category_id 
                                                            FROM products WHERE product_id=$product) 
                                                            AND product_id != $product LIMIT 4";

    // Execute the query
    $result = $conn->query($sql);
    $related = $conn->query($related);
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
        <br>
        <br>

        <?php
        while($row=mysqli_fetch_assoc($result)){
        ?>
        <section style="margin-top: 5rem;">
        <form method="POST">
            <div class="product_layout"><img src="<?php echo $row["Image_path"];?>" class="product_image">
               <div>
                <ul class="product_description" style="width:40rem;">
                  <li class="product_title"><?php echo htmlspecialchars($row["Product_Name"]);?></li>
                  <li style="word-break: break-all;"><?php echo htmlspecialchars($row["Brief_Description"]);?></li>
                  <li style="color: #9c0707; font-size: 2rem;">$ <?php echo htmlspecialchars($row["Price"]);?></li>
                   <li><label style="font-size: 2.5rem;color:#9c0707;">Quantity: </label>
                    <select name="quantity" style="height:2.3rem; width:2.5rem; font-size:1.5rem;
                                                   font-family:serif;border-radius: 0.5rem; border:0.1rem #9c0707;
                                                   border-style:solid;">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="hidden" class="addto_cart" name="id" value="<?php echo htmlspecialchars($row['Product_id']); ?>">
                    <button class="addto_cart" name="Add_cart" value="add_to_cart">Add To Cart</button></form></li>
                </ul>
               </div> 
            </div>
            <div style="margin-left: 2.5rem;width: 55rem; margin-top: 5rem;">
              <p class="product_title">Description</p>
              <p style="font-size: 1.5rem;"><?php echo htmlspecialchars($row["Product_Description"]);?></p>
            </div></form>
        </section>
        <?php
        }
        ?>
        
        <p class="product_title" style="margin-left: 1.5rem; margin-top: 5rem;">Related Products</p>
        <section  style="display: flex;
                     flex-wrap: wrap;
                     width: 100%;">
          <?php 
         while($recco=mysqli_fetch_assoc($related)){
        ?><form method="POST">
        <div class="product-box">
        <img class="product-image" src="<?php echo $recco["Image_path"]; ?>" class="advice_images">
          <a href="Product View page.php?product_id=<?php echo $recco['Product_id']; ?>"
           style="text-decoration: none;
           font-size: 1.125rem;
           font-weight: bold;
           margin-bottom: 0.5rem;
           padding-left:1rem;
           padding-top:1.5rem;
           padding-right:0.3rem;
          color: #000000;"><?php $product_name = $recco["Product_Name"]; 
                                          echo strlen($product_name) > 30 ? substr($product_name, 0, 30)
                                          . '...' : $product_name; ?></a>
         <p class="product-description"><?php $product_description = $recco["Brief_Description"]; 
                                          echo strlen($product_description) > 30 ? substr($product_description, 0, 30) 
                                          . '...' : $product_description; ?></p>
          <p class="product-description">$<?php echo $recco["Price"]; ?></p>
          
            <button class="add-to-cart-btn" name="Add_cart" value="add_to_cart">Add to Cart</button>
   
          
      </div>       
      </form>
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