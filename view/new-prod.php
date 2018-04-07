<?php
//only logged in users with level 2 or higher can enter
if($_SESSION['clientData']['clientLevel'] < 2){
  header('Location: /acme/');
  exit;
}

//build the categories options list
  $catList = '<select name="categoryID" required>';
  $catList .= '<option value="" autofocus >select a category</option>';
  foreach ($categories as $category) { 
    $catList .= "<option value='$category[categoryID]'";
    if(isset($categoryID)){
      if($category['categoryID'] === $categoryID){
        $catList.= ' selected ';
      }
    }
    $catList .= ">$category[categoryName]</option>";
  }
  $catList .= '</select>';
?>
<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="UTF-8">
        <title> Prod MGMT | Acme, Inc.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/acme/css/normalize.css">
        <link rel="stylesheet" href="/acme/css/screen.css">
        <link href="https://fonts.googleapis.com/css?family=Bangers" rel="stylesheet">
    </head>
    <body class="home">
        <div id="container">
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/header.php'; ?>
            <nav id="primary-nav">
                <?php echo $navList; ?>
            </nav>
            <main>
                <?php
                    if (isset($message)) {
                    echo $message;
                    }
                ?>
                <form action="/acme/products/" method="post" class="acmeform">
                    <fieldset>
                        <legend>Create New Product</legend>
                        <?php echo $catList; ?>
                        <label><span>Product Name:</span><input type="text" size="25" name="invName" <?php if(isset($invName)){echo "value='$invName'";} ?> placeholder="name" pattern="[a-zA-Z0-9 .,]{3,50}" title="Only letters and numbers please. A minimum of 3 characters." required></label>
                        <label><span>Product Description:</span><textarea name="invDescription" required><?php if(isset($invDescription)){echo $invDescription;} ?></textarea></label>
                        <label><span>Path to Image:</span><input type="text" size="50" name="invImage" <?php if(isset($invImage)){echo "value='$invImage'";} ?> placeholder="path to image" pattern="[a-zA-Z0-9\.\-\/]{3,50}" title="Only letters, numbers and / please. A minimum of 3 characters." required></label>
                        <label><span>Path to Thumbnail:</span><input type="text" size="50" name="invThumbnail" <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";} ?> placeholder="path to thumbnail" pattern="[a-zA-Z0-9\.\-\/]{3,50}" title="Only letters, numbers and / please. A minimum of 3 characters." required></label>
                        <label><span>Product Price:</span><input type="number" min="0.01" step="0.01" size="15" name="invPrice" <?php if(isset($invPrice)){echo "value='$invPrice'";} ?> placeholder="0.00" title="Only numbers and a decimal point please." required></label>
                        <label><span>Amount in Stock:</span><input type="number" min="0" size="15" name="invStock" <?php if(isset($invStock)){echo "value='$invStock'";} ?> placeholder="0" title="Only numbers please." required></label>
                        <label><span>Product Size</span><input type="number" min="0" size="15" name="invSize" <?php if(isset($invSize)){echo "value='$invSize'";} ?> placeholder="0" title="Only numbers please." required></label>
                        <label><span>Product Weight</span><input type="number" min="0" size="15" name="invWeight" <?php if(isset($invWeight)){echo "value='$invWeight'";} ?> placeholder="0" title="Only numbers please." required></label>
                        <label><span>Product Location:</span><input type="text" size="35" name="invLocation" <?php if(isset($invLocation)){echo "value='$invLocation'";} ?> placeholder="location of product" pattern="[a-zA-Z0-9 .,]{3,35}" title="Only letters and numbers please. A minimum of 3 characters." required></label>
                        <label><span>Product Vendor:</span><input type="text" size="25" name="invVendor" placeholder="vendor name" <?php if(isset($invVendor)){echo "value='$invVendor'";} ?> pattern="[a-zA-Z0-9 .,]{3,20}" title="Only letters and numbers please. A minimum of 3 characters." required></label>
                        <label><span>Product Style:</span><input type="text" size="25" name="invStyle" placeholder="stlye name" <?php if(isset($invStyle)){echo "value='$invStyle'";} ?> pattern="[a-zA-Z0-9 .,]{3,20}" title="Only letters and numbers please. A minimum of 3 characters." required></label>
                    </fieldset>
                    <input type="submit" value="Add a New Product" class="submitBtn">
                    <!--add the action key-value pair-->
                    <input type="hidden" name="action" value="addProduct">
                </form>
            </main>
            <footer id="primary-footer">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/acme/common/footer.php'; ?>
            </footer>
        </div>
    </body>
</html>
