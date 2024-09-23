<?php
$db_server="127.0.0.1";
$db_user = "newuser";
$db_pass = "12345678.m";
$db_name="mcpharm";
$port=3306;
$conn="";

$conn=new mysqli($db_server ,
 $db_user , $db_pass , $db_name , $port);
   
   
   if (isset($_GET['Searchbar'])) {
    // Retrieve the search query from the search bar
    $search = $conn->real_escape_string($_GET['Searchbar']);

    // SQL query to fetch data from the database based on the search input
    $sql = "SELECT * FROM products WHERE Product_Name LIKE '%$search%' OR Brief_Description LIKE '%$search%' OR Category LIKE '%$search%'";

    // Execute the query
    $result = $conn->query($sql);
   }
?> 
<!DOCTYPE HTML>
<html>
    <head>
        <title>Online Pharmacy website</title>
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </head>
    
    <body>
     
        <!--Navigation bar on top of page implemented using a table and unordered lists for submenus-->
        <section class="navigation_bar">
            <table class="strp">
             <tr>
                 <th id="logo"><a href="homepage.html"><img src="Images/Navigation bar/logo.png" style="width: 5.938rem;height: 4.375rem;"></a></th>
                 <th class="navheading"><h2><a href="Search Result.php?Searchbar=medicatoins" style="text-decoration: none; color:#000000;">Medications</a></h2>
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

     <section style="display: flex;
                     flex-wrap: wrap;
                     width: 100%;
                     margin-top: 7rem;">
     <?php
      while($row=mysqli_fetch_assoc($result)){
      ?>
        <div class="product-box">
        <img class="product-image" src="<?php echo $row["Image_path"]; ?>" class="advice_images">
          <a href="Product View.php?product_id=<?php echo $row['Product_id']; ?>"
           style="text-decoration: none;
           font-size: 1.125rem;
           font-weight: bold;
           margin-bottom: 0.5rem;
           padding-left:1rem;
           padding-top:1.5rem;
           padding-right:0.3rem;
          color: #000000;"><?php $product_name = $row["Product_Name"]; 
                                          echo strlen($product_name) > 30 ? substr($product_name, 0, 30)
                                          . '...' : $product_name; ?></a>
         <p class="product-description"><?php $product_description = $row["Brief_Description"]; 
                                          echo strlen($product_description) > 30 ? substr($product_description, 0, 30) 
                                          . '...' : $product_description; ?></p>
          <p class="product-description">$<?php echo $row["Price"]; ?></p>
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