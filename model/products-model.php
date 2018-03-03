<?php
/* 
 * Products model
 */

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