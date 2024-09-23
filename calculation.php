<?php
// Your JSON data
$json_data = '{"result":[{"Title":"North Goa Tour","Rs":"1500","Discount":"50","OfferPrice":"1450","Rate":"100"},
{"Title":"Harvalem Waterfall","Rs":"3000","Discount":"500","OfferPrice":"2500","Rate":"50"},
{"Title":"South Goa Tour","Rs":"1500","Discount":"50","OfferPrice":"1450","Rate":"30"},
{"Title":"Amboli Waterfall","Rs":"3000","Discount":"500","OfferPrice":"2500","Rate":"10"},
{"Title":"Nirvana Sunset Cruise","Rs":"1500","Discount":"50","OfferPrice":"1450"},
{"Title":"North Goa Tour","Rs":"3000","Discount":"500","OfferPrice":"2500"},
{"Title":"Harvalem Waterfall","Rs":"1500","Discount":"50","OfferPrice":"1450"},
{"Title":"North Goa Tour","Rs":"3000","Discount":"500","OfferPrice":"2500"}]}';

// Decode JSON data
$output = json_decode($json_data, true);

// Encode the entire $output['result'] array into a JavaScript variable
$js_data = json_encode($output['result']);
?>
