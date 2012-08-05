<?php  
// we strip the id number from the query string  
$sID = $_GET["id"];  
  
// is News Item ID a number  
if (is_numeric($sID)) {  
    // use function sleep() if you want to delay showing the comments  
    //  sleep(1);  
    if ($sID == "20081031") {  
        print '<p>1. This is the first comment. Mary Poppins is my all time favourite.</p>';  
        print '<p>2. This is the second comment. Oh God.</p>';            
    } else if ($sID == "20081030") {  
        print '<p>1. Ugh</p>';  
        print '<p>2. Yup</p>';            
    } else {  
        print 'The number you gave us didn\'t correspond with a News Item.';  
    }  
  
// News Item ID is not a number  
} else {  
print 'that ain\'t a number broh!';  
}  
?> 