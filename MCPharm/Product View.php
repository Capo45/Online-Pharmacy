<?php
$db_server="127.0.0.1";
$db_user = "newuser";
$db_pass = "12345678.m";
$db_name="mcpharm";
$port=3306;
$conn="";

$conn=new mysqli($db_server ,
 $db_user , $db_pass , $db_name , $port);
   
   
   if (isset($_GET['product_id'])) {
    // Retrieve the search query from the search bar
    $search = $conn->real_escape_string($_GET['product_id']);

    // SQL query to fetch data from the database based on the search input
    $sql = "SELECT * FROM products WHERE Product_id LIKE '%$search%'";
    $related = "SELECT * FROM products WHERE Category_id =( SELECT Category_id 
                                                            FROM products WHERE product_id=$search) 
                                                            AND product_id != $search LIMIT 4";

    // Execute the query
    $result = $conn->query($sql);
    $related = $conn->query($related);
   }
?> 

<!DOCTYPE HTML>
<html>
    <head>
        <title>Online Pharmacy website</title>
        <link rel="stylesheet" href="style.css">
    </head>
    
    <body>
        <!--Navigation bar on top of page implemented using a table and unordered lists for submenus-->
        <section class="navigation_bar">
            <table class="strp">
             <tr>
                 <th id="logo"><a href="homepage.html"><img src="Images/Navigation bar/logo.png" style="width: 5.938rem;height: 4.375rem;"></a></th>
                 <th class="navheading" ><h2>Medications</h2>
                 <ul id="submenu1" class="submenus">
                     <li>Pain relief</li>
                     <li>Digestive Health</li>
                     <li>Allergy & Cold</li>
                     <li>Chronic Condition Management</li>
                 </ul>
                 </th>
                 <th  class="navheading"><h2>Supplements</h2>
                     <ul id="submenu2" class="submenus">
                         <li>Multi-Vitamins</li>
                         <li>Minerals</li>
                         <li>Herbal Supplements</li>
                         <li>Fitness & Sports Nutrition</li> 
                     </ul></th>
                 <th class="navheading"><h2>Dental Health</h2>
                     <ul id="submenu3" class="submenus">
                         <li>Toothpaste</li>
                         <li>Mouth Wash</li>
                         <li>Dental floss</li>
                         <li>Toothbrushes</li>
                     </ul></th>
                 <th class="navheading"><h2>Cosmetics</h2>
                     <ul id="submenu4" class="submenus">
                         <li>Skin Care Products</li>
                         <li>Makeup</li>
                         <li>Fragrances</li>
                         <li>Hair dyes</li> 
                     </ul></th>
                     <form action="Search Result.php" method="GET">
                    <th><div class="searchbar_wrapper"><input type="search" placeholder="Search Item......." name="Searchbar"
                     class="searchbar" width="20rem">
                        </div></th>
                    </form> 
                     <th><a href="#"><img src="Images/Navigation bar/shopping cart icon.png"  style="width: 1.7rem; height: 1.7rem;"></a></th>
               </tr>
            </table>
     </section>
        <br>
        <br>

        <?php
        while($row=mysqli_fetch_assoc($result)){
        ?>
        <section style="margin-top: 5rem;">
            <div class="product_layout"><img src="<?php echo $row["Image_path"];?>" class="product_image">
               <div>
                <ul class="product_description" style="width:40rem;">
                  <li class="product_title"><?php echo htmlspecialchars($row["Product_Name"]);?></li>
                  <li style="word-break: break-all;"><?php echo htmlspecialchars($row["Brief_Description"]);?></li>
                  <li style="color: #9c0707; font-size: 2rem;">$ <?php echo htmlspecialchars($row["Price"]);?></li>
                   <li><label>Quantity: </label>
                    <select>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;<button class="addto_cart">Add to cart</button></li>
                </ul>
               </div> 
            </div>
            <div style="margin-left: 2.5rem;width: 55rem; margin-top: 5rem;">
              <p class="product_title">Description</p>
              <p style="font-size: 1.5rem;"><?php echo htmlspecialchars($row["Product_Description"]);?></p>
            </div>
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
        ?>
        <div class="product-box">
        <img class="product-image" src="<?php echo $recco["Image_path"]; ?>" class="advice_images">
          <a href="Product View.php?product_id=<?php echo $recco['Product_id']; ?>"
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
          <button class="add-to-cart-btn">Add to Cart</button>
      </div>
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