<?php

include_once'header.php';
include_once'functions.php';

$getID = isset($_GET['id']) ? $_GET['id'] : ''; // Always sanitize the ID input

// Connect to the database
$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

// output any connection error
if ($mysqli->connect_error) {
    die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
}

// the query
$query = "SELECT * FROM store_customers WHERE id = '" . $mysqli->real_escape_string($getID) . "'";

$result = mysqli_query($mysqli, $query);

// Check if there is a result and store it in $customerData
if ($result && mysqli_num_rows($result) > 0) {
    $customerData = mysqli_fetch_assoc($result);
} else {
    $customerData = []; // Initialize empty array in case no result
}


// // mysqli select query
// if($result) {
//     while ($row = mysqli_fetch_assoc($result)) {

//         $customer_name = $row['name']; // customer name
//         $customer_email = $row['email']; // customer email
//         $customer_address_1 = $row['address_1']; // customer address
//         $customer_address_2 = $row['address_2']; // customer address
//         $customer_town = $row['town']; // customer town
//         $customer_county = $row['county']; // customer county
//         $customer_postcode = $row['postcode']; // customer postcode
//         $customer_phone = $row['phone']; // customer phone number

//         //shipping
//         $customer_name_ship = $row['name_ship']; // customer name (shipping)
//         $customer_address_1_ship = $row['address_1_ship']; // customer address (shipping)
//         $customer_address_2_ship = $row['address_2_ship']; // customer address (shipping)
//         $customer_town_ship = $row['town_ship']; // customer town (shipping)
//         $customer_county_ship = $row['county_ship']; // customer county (shipping)
//         $customer_postcode_ship = $row['postcode_ship']; // customer postcode (shipping)
//     }
// }

// Function to handle form population
function populateField($row, $field) {
    return isset($row[$field]) ? htmlspecialchars($row[$field], ENT_QUOTES, 'UTF-8') : '';
}


/* close connection */
$mysqli->close();

?>

<h1>Edit Customer</h1>
<hr>

<div id="response" class="alert alert-success" style="display:none;">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <div class="message"></div>
</div>

<form method="post" id="update_customer">
    <input type="hidden" name="action" value="update_customer">
    <input type="hidden" name="id" value="<?php echo populateField($customerData, 'id'); ?>">
    <div class="row">
        <div class="col-xs-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Editing Customer (<?php echo populateField($customerData, 'id'); ?>)</h4>
                    <div class="clear"></div>
                </div>
                <div class="panel-body form-group form-group-sm">
                    <div class="row">
                        <div class="col-xs-6">
                            <?php
                            // Fields for customer information (first column)
                            $customerFields1 = [
                                'customer_name' => 'name',
                                'customer_email' => 'email',
                                'customer_address_1' => 'address_1',
                                'customer_address_2' => 'address_2',
                            ];

                            foreach ($customerFields1 as $field => $dbColumn) {
                                echo "<div class='form-group'>
                                        <input type='text' class='form-control margin-bottom copy-input required' name='$field' id='$field' placeholder='" . ucfirst(str_replace('_', ' ', $field)) . "' value='" . populateField($customerData, $dbColumn) . "'>
                                    </div>";
                            }
                            ?>
                        </div>
                        <div class="col-xs-6">
                            <?php
                            // Fields for customer information (second column)
                            $customerFields2 = [
                                'customer_town' => 'town',
                                'customer_county' => 'county',
                                'customer_postcode' => 'postcode',
                                'customer_phone' => 'phone'
                            ];

                            foreach ($customerFields2 as $field => $dbColumn) {
                                echo "<div class='form-group'>
                                        <input type='text' class='form-control margin-bottom copy-input required' name='$field' id='$field' placeholder='" . ucfirst(str_replace('_', ' ', $field)) . "' value='" . populateField($customerData, $dbColumn) . "'>
                                    </div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-6 text-right">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Shipping Information</h4>
                </div>
                <div class="panel-body form-group form-group-sm">
                    <div class="row">
                        <div class="col-xs-6">
                            <?php
                            // Fields for shipping information (first column)
                            $shippingFields1 = [
                                'customer_name_ship' => 'name_ship',
                                'customer_address_1_ship' => 'address_1_ship',
                                'customer_address_2_ship' => 'address_2_ship'
                            ];

                            foreach ($shippingFields1 as $field => $dbColumn) {
                                echo "<div class='form-group'>
                                        <input type='text' class='form-control margin-bottom required' name='$field' id='$field' placeholder='" . ucfirst(str_replace('_', ' ', $field)) . "' value='" . populateField($customerData, $dbColumn) . "'>
                                    </div>";
                            }
                            ?>
                        </div>
                        <div class="col-xs-6">
                            <?php
                            // Fields for shipping information (second column)
                            $shippingFields2 = [
                                'customer_town_ship' => 'town_ship',
                                'customer_county_ship' => 'county_ship',
                                'customer_postcode_ship' => 'postcode_ship'
                            ];

                            foreach ($shippingFields2 as $field => $dbColumn) {
                                echo "<div class='form-group'>
                                        <input type='text' class='form-control margin-bottom required' name='$field' id='$field' placeholder='" . ucfirst(str_replace('_', ' ', $field)) . "' value='" . populateField($customerData, $dbColumn) . "'>
                                    </div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 margin-top btn-group">
            <input type="submit" id="action_update_customer" class="btn btn-success float-right" value="Update Customer" data-loading-text="Updating...">
        </div>
    </div>
</form>

<?php
include_once'footer.php';
?>
