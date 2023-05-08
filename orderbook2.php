<?php 
    $pair = $_GET['pair'];

    $increase = $_GET['increase'];
    $decrease = $_GET['decrease'];

    //Connecting to Redis server on localhost 
    $redis = new Redis(); 
    $redis->connect('172.17.0.2', 6379); 

    switch ($pair) {
        case "INCH/USD":
            $keys = $redis->keys("*INCHUSD*");
            break;
        case "VSY/USD":
            $keys = $redis->keys("*VSYUSD*");
            break;
        case "AAVE/USD":
            $keys = $redis->keys("*AAVEUSD*");
            break;
        case "ADA/USD":
            $keys = $redis->keys("*ADAUSD*");
            break;
        case "ALBT/USD":
            $keys = $redis->keys("*ALBTUSD*");
            break;
        case "AXS/USD":
            $keys = $redis->keys("*AXSUSD*");
            break;
        case "ZCN/USD":
            $keys = $redis->keys("*ZCNUSD*");
            break;
        case "BEST/USD":
            $keys = $redis->keys("*BESTUSD*");
            break;
        case "ETP/USD":
            $keys = $redis->keys("*ETPUSD*");
            break;
        case "SNX/USD":
            $keys = $redis->keys("*SNXUSD*");
            break;
        case "BDOG/USD":
            $keys = $redis->keys("*DOGUSD*");
            break;
        case "CLO/USD":
            $keys = $redis->keys("*CLOUSD*");
            break;
        case "YGG/USD":
            $keys = $redis->keys("*YGGUSD*");
            break;
        default:
            // nếu không tìm thấy giá trị nào phù hợp, ta có thể gán $keys = null hoặc thực hiện một hành động khác tùy theo yêu cầu
            $keys = null;
            break;
    }
    
   // Get the values for the matching keys
$values = $redis->mGet(array_slice($keys, 0, 20));

// Define the table header
$table_header = "<table border='1'>";
$table_header .= "<tr><th style=\"color: red; padding: 0px 63px;\">Time</th>";

// Add ask columns to the table header
for ($i = 1; $i <= 25; $i++) {
    $table_header .= "<th>ask_price_$i</th><th>ask_count_$i</th><th>ask_mount_$i</th>";
}

// Add bid columns to the table header
for ($i = 1; $i <= 25; $i++) {
    $table_header .= "<th>bid_price_$i</th><th>bid_count_$i</th><th>bid_mount_$i</th>";
}

$table_header .= "</tr>";

// Define the table body
$table_body = "<tbody>";

// Sort the values based on the ask_price_1 column
$ask_price_1_column = array();
foreach ($values as $key => $value) {
    $row = explode(",", $value);
    $ask_price_1_column[$key] = $row[1];
}

if ($increase) {
    asort($ask_price_1_column);
} elseif ($decrease) {
    arsort($ask_price_1_column);
}

$sorted_values = array();
foreach ($ask_price_1_column as $key => $value) {
    $sorted_values[] = $values[$key];
}

// Add the sorted rows to the table body
foreach ($sorted_values as $value) {
    $row = explode(",", $value);
    $timestamp = $row[0]; // Get the timestamp value
    $date = date("Y-m-d H:i:s", $timestamp/1000); // Convert timestamp to real time
    $table_body .= "<tr><td>" . $date . "</td>"; // Add the converted date to the table body
    for ($i = 1; $i < count($row); $i++) {
        $table_body .= "<td>" . $row[$i] . "</td>";
    }
    $table_body .= "</tr>";
}

$table_body .= "</tbody>";

// Define the table footer
$table_footer = "</table>";

// Combine the header, body and footer to create the table
$table = $table_header . $table_body . $table_footer;

// Echo the table
echo $table;
?>
