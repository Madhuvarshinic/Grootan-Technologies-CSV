<?php
//index.php
$connect = mysqli_connect("localhost", "root", "", "testing");
$message = '';

if(isset($_POST["upload"]))
{
 if($_FILES['product_file']['name'])
 {
  $filename = explode(".", $_FILES['product_file']['name']);
  if(end($filename) == "csv")
  {
   $handle = fopen($_FILES['product_file']['tmp_name'], "r");
   while($data = fgetcsv($handle))
   {
    $product_id = mysqli_real_escape_string($connect, $data[0]);
    $product_category = mysqli_real_escape_string($connect, $data[1]);  
                $product_name = mysqli_real_escape_string($connect, $data[2]);
    $product_price = mysqli_real_escape_string($connect, $data[3]);
    $query = "
     UPDATE daily_product 
     SET product_category = '$product_category', 
     product_name = '$product_name', 
     product_price = '$product_price' 
     WHERE product_id = '$product_id'
    ";
    mysqli_query($connect, $query);
   }
   fclose($handle);
   header("location: index.php?updation=1");
  }
  else
  {
   $message = '<label class="text-danger">Please Select CSV File only</label>';
  }
 }
 else
 {
  $message = '<label class="text-danger">Please Select File</label>';
 }
}

if(isset($_GET["updation"]))
{
 $message = '<label class="text-success">Product Updation Done</label>';
}

$query = "SELECT * FROM daily_product";
$result = mysqli_query($connect, $query);
?>