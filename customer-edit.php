<?php

include('header.php');
include('functions.php');

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

// mysqli select query
if($result) {
    while ($row = mysqli_fetch_assoc($result)) {

        $customer_name = $row['name']; // customer name
        $customer_email = $row['email']; // customer email
        $customer_address_1 = $row['address_1']; // customer address
        $customer_address_2 = $row['address_2']; // customer address
        $customer_town = $row['town']; // customer town
        $customer_county = $row['county']; // customer county
        $customer_postcode = $row['postcode']; // customer postcode
        $customer_phone = $row['phone']; // customer phone number

        //shipping
        $customer_name_ship = $row['name_ship']; // customer name (shipping)
        $customer_address_1_ship = $row['address_1_ship']; // customer address (shipping)
        $customer_address_2_ship = $row['address_2_ship']; // customer address (shipping)
        $customer_town_ship = $row['town_ship']; // customer town (shipping)
        $customer_county_ship = $row['county_ship']; // customer county (shipping)
        $customer_postcode_ship = $row['postcode_ship']; // customer postcode (shipping)
    }
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
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($getID, ENT_QUOTES, 'UTF-8'); ?>">
    <div class="row">
        <div class="col-xs-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Editing Customer (<?php echo htmlspecialchars($getID, ENT_QUOTES, 'UTF-8'); ?>)</h4>
                    <div class="clear"></div>
                </div>
                <div class="panel-body form-group form-group-sm">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control margin-bottom copy-input required" name="customer_name" id="customer_name" placeholder="Enter name" value="<?php echo htmlspecialchars($customer_name, ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control margin-bottom copy-input required" name="customer_address_1" id="customer_address_1" placeholder="Address 1" value="<?php echo htmlspecialchars($customer_address_1, ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control margin-bottom copy-input required" name="customer_town" id="customer_town" placeholder="Town" value="<?php echo htmlspecialchars($customer_town, ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                            <div class="form-group no-margin-bottom">
                                <input type="text" class="form-control copy-input required" name="customer_postcode" id="customer_postcode" placeholder="Postcode" value="<?php echo htmlspecialchars($customer_postcode, ENT_QUOTES, 'UTF-8'); ?>">          
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="input-group float-right margin-bottom">
                                <span class="input-group-addon">@</span>
                                <input type="email" class="form-control copy-input required" name="customer_email" id="customer_email" placeholder="E-mail address" aria-describedby="sizing-addon1" value="<?php echo htmlspecialchars($customer_email, ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control margin-bottom copy-input" name="customer_address_2" id="customer_address_2" placeholder="Address 2" value="<?php echo htmlspecialchars($customer_address_2, ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control margin-bottom copy-input required" name="customer_county" id="customer_county" placeholder="County" value="<?php echo htmlspecialchars($customer_county, ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                            <div class="form-group no-margin-bottom">
                                <input type="text" class="form-control required" name="customer_phone" id="invoice_phone" placeholder="Phone number" value="<?php echo htmlspecialchars($customer_phone, ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
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
                            <div class="form-group">
                                <input type="text" class="form-control margin-bottom required" name="customer_name_ship" id="customer_name_ship" placeholder="Enter name" value="<?php echo htmlspecialchars($customer_name_ship, ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control margin-bottom" name="customer_address_2_ship" id="customer_address_2_ship" placeholder="Address 2" value="<?php echo htmlspecialchars($customer_address_2_ship, ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                            <div class="form-group no-margin-bottom">
                                <input type="text" class="form-control required" name="customer_county_ship" id="customer_county_ship" placeholder="County" value="<?php echo htmlspecialchars($customer_county_ship, ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <input type="text" class="form-control margin-bottom required" name="customer_address_1_ship" id="customer_address_1_ship" placeholder="Address 1" value="<?php echo htmlspecialchars($customer_address_1_ship, ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control margin-bottom required" name="customer_town_ship" id="customer_town_ship" placeholder="Town" value="<?php echo htmlspecialchars($customer_town_ship, ENT_QUOTES, 'UTF-8'); ?>">                     
                            </div>
                            <div class="form-group no-margin-bottom">
                                <input type="text" class="form-control required" name="customer_postcode_ship" id="customer_postcode_ship" placeholder="Postcode" value="<?php echo htmlspecialchars($customer_postcode_ship, ENT_QUOTES, 'UTF-8'); ?>">
                            </div>
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
include('footer.php');
?>
