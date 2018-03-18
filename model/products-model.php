<?php
/* 
 * Products model
 */

function getProductsByCategory($type){
 $db = acmeConnect();
 $sql = 'SELECT * FROM inventory WHERE categoryId IN (SELECT categoryId FROM categories WHERE categoryName = :catType)';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':catType', $type, PDO::PARAM_STR);
 $stmt->execute();
 $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
 $stmt->closeCursor();
 return $products;
}

function getItemById($invId){
  $db = acmeConnect();
  $sql = 'SELECT * FROM inventory WHERE invId = :invId';
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
  $stmt->execute();
  $item = $stmt->fetch(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $item;
}
//Insert new category into database
function addCategory($categoryName){
    //create connection object
    $db = acmeConnect();
    //sql statement
    $sql = 'INSERT INTO categories (categoryName) VALUES (:categoryName)';
    
   //creates prepared statement
    $stmt = $db->prepare($sql);
    // swap out varialbes for actual values
    //tell database the type of data
    $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
    
    //use the prepared statement to insert data
    $stmt->execute();
    //check to see if it worked
    $rowsChanged = $stmt->rowCount();
    //close connection
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}
//Insert new product into inventory table database
function addProduct($invName, $invDescription, $invImage,
        $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation,
        $categoryID, $invVendor, $invStyle){
    //create connection object
    $db = acmeConnect();
    //sql statement
    $sql = 'INSERT INTO inventory (invName, invDescription, invImage, invThumbnail,
            invPrice, invStock, invSize, invWeight, invLocation, categoryID,
            invVendor,invStyle) VALUES (:invName, :invDescription, :invImage, :invThumbnail,
            :invPrice, :invStock, :invSize, :invWeight, :invLocation, :categoryID,
            :invVendor, :invStyle)';
   //creates prepared statement
    $stmt = $db->prepare($sql);
    // swap out varialbes for actual values
    //tell database the type of data
    $stmt->bindValue(':invName', $invName, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
    $stmt->bindValue(':invSize', $invSize, PDO::PARAM_INT);
    $stmt->bindValue(':invWeight', $invWeight, PDO::PARAM_INT);
    $stmt->bindValue(':invLocation', $invLocation, PDO::PARAM_STR);
    $stmt->bindValue(':categoryID', $categoryID, PDO::PARAM_INT);
    $stmt->bindValue(':invVendor', $invVendor, PDO::PARAM_STR);
    $stmt->bindValue(':invStyle', $invStyle, PDO::PARAM_STR);
    //use the prepared statement to insert data
    $stmt->execute();
    //check to see if it worked
    $rowsChanged = $stmt->rowCount();
    //close connection
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}
//update product
function updateProduct($invName, $invDescription, $invImage,
        $invThumbnail, $invPrice, $invStock, $invSize, $invWeight, $invLocation,
        $categoryID, $invVendor, $invStyle, $invId){
    //create connection object
    $db = acmeConnect();
    //sql statement
    $sql = 'UPDATE inventory SET invName = :invName, invDescription = :invDescription, invImage = :invImage, invThumbnail =:invThumbnail,
            invPrice = :invPrice, invStock = :invStock, invSize = :invSize, invWeight = :invWeight, invLocation = :invLocation, categoryID = :categoryID,
            invVendor = :invVendor,invStyle = :invStyle WHERE invId = :invId';
   //creates prepared statement
    $stmt = $db->prepare($sql);
    // swap out varialbes for actual values
    //tell database the type of data
    $stmt->bindValue(':invName', $invName, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
    $stmt->bindValue(':invSize', $invSize, PDO::PARAM_INT);
    $stmt->bindValue(':invWeight', $invWeight, PDO::PARAM_INT);
    $stmt->bindValue(':invLocation', $invLocation, PDO::PARAM_STR);
    $stmt->bindValue(':categoryID', $categoryID, PDO::PARAM_INT);
    $stmt->bindValue(':invVendor', $invVendor, PDO::PARAM_STR);
    $stmt->bindValue(':invStyle', $invStyle, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);

    //use the prepared statement to insert data
    $stmt->execute();
    //check to see if it worked
    $rowsChanged = $stmt->rowCount();
    //close connection
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    return $rowsChanged;
}
//delete product
function deleteProduct($invId){
    $db = acmeConnect();
    $sql = 'DELETE FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}
//get list of products names and IDs
function getProductBasics(){
  $db = acmeConnect();
  $sql = 'SELECT invName, invId FROM inventory ORDER BY invName ASC';
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt->closeCursor();
  return $products;
}
// Get product information by invId
function getProductInfo($invId){
 $db = acmeConnect();
 $sql = 'SELECT * FROM inventory WHERE invId = :invId';
 $stmt = $db->prepare($sql);
 $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
 $stmt->execute();
 $prodInfo = $stmt->fetch(PDO::FETCH_ASSOC);
 $stmt->closeCursor();
 return $prodInfo;
}
