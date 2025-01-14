<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once 'config.php';

// Get the requested API endpoint
$endpoint = isset($_GET['endpoint']) ? $_GET['endpoint'] : '';

switch ($endpoint) {
    case 'models':
        getModels($conn);
        break;
    case 'customers':
        getCustomers($conn);
        break;
    case 'orders':
        getOrders($conn);
        break;
    case 'raw-materials':
        getRawMaterials($conn);
        break;
    case 'suppliers':
        getSuppliers($conn);
        break;
    default:
        echo json_encode(['message' => 'Invalid API endpoint']);
        break;
}

// Fetch all models
function getModels($conn)
{
    $sql = "SELECT * FROM model";
    $result = $conn->query($sql);
    $models = [];
    while ($row = $result->fetch_assoc()) {
        array_push($models, $row);
    }
    echo json_encode($models);
}

// Fetch all customers
function getCustomers($conn)
{
    $sql = "SELECT * FROM customer";
    $result = $conn->query($sql);
    $customers = [];
    while ($row = $result->fetch_assoc()) {
        array_push($customers, $row);
    }
    echo json_encode($customers);
}

// Fetch all orders
function getOrders($conn)
{
    $sql = "SELECT
            o.order_numb,
            o.customer_numb,
            c.customer_name,
            o.order_date,
            o.order_total,
            o.order_filled
        FROM
            `order` o
        JOIN customer c ON
            o.customer_numb = c.customer_numb";
    $result = $conn->query($sql);
    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[$row['order_numb']] = $row;
        $orders[$row['order_numb']]['orders'] = [];
    }

    $sql = "SELECT
                ol.order_numb,
                ol.model_numb,
                m.model_description,
                ol.quantity_ordered,
                ol.unit_price,
                ol.line_total
            FROM
                order_line ol
            JOIN model m ON
                ol.model_numb = m.model_numb";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if (isset($orders[$row['order_numb']])) {
                $orders[$row['order_numb']]['orders'][] = $row;
            }
        }
    }
    echo json_encode(array_values($orders));
}

// Fetch all raw materials
function getRawMaterials($conn)
{
    $sql = "SELECT * FROM raw_material";
    $result = $conn->query($sql);
    $rawMaterials = [];
    while ($row = $result->fetch_assoc()) {
        array_push($rawMaterials, $row);
    }
    echo json_encode($rawMaterials);
}

// Fetch all suppliers
function getSuppliers($conn)
{
    $sql = "SELECT * FROM supplier";
    $result = $conn->query($sql);
    $suppliers = [];
    while ($row = $result->fetch_assoc()) {
        array_push($suppliers, $row);
    }
    echo json_encode($suppliers);
}

$conn->close();
?>