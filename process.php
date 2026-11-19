
<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$name = trim($_POST['customer_name'] ?? '');
$type = $_POST['customer_type'] ?? '';
$product = $_POST['product'] ?? '';

$quantity = filter_var(
    $_POST['quantity'] ?? null,
    FILTER_VALIDATE_INT
);

$budget = filter_var(
    $_POST['budget'] ?? null,
    FILTER_VALIDATE_FLOAT
);

$valid = $name !== ''
    && in_array($type, ['regular', 'member', 'groomer'], true)
    && in_array($product, ['P1', 'P2', 'P3', 'P4', 'P5'], true)
    && $quantity !== false
    && $quantity !== null
    && $quantity >= 1
    && $quantity <= 10
    && $budget !== false
    && $budget !== null
    && $budget >= 0;

if (!$valid) {
    include 'header.php';
    echo '<p class="error">Invalid order. Please check your input.</p>';
    echo '<a href="index.php">Return to order form</a>';
    include 'footer.php';
    exit;
}

// PHP 8 match expression: identifies the selected product.
$item = match ($product) {
    'P1' => ['Dog Collar', 400, 50],
    'P2' => ['Pet Bandana', 250, 35],
    'P3' => ['Paw Toy', 200, 20],
    'P4' => ['Pet Leash', 350, 40],
    'P5' => ['Pet Bowl', 300, 25],
};

[$productName, $price, $stock] = $item;

// Check available stock.
if ($quantity > $stock) {
    include 'header.php';
    echo '<p class="error">Insufficient stock for this order.</p>';
    echo '<p>Available stock: ' . $stock . ' pieces</p>';
    echo '<a href="index.php">Return to order form</a>';
    include 'footer.php';
    exit;
}

// Calculate subtotal.
$subtotal = $price * $quantity;

// Determine customer discount.
if ($type === 'member') {
    $rate = 0.10;
} elseif ($type === 'groomer') {
    $rate = 0.05;
} else {
    $rate = 0;
}

// Calculate discount and tax.
$discount = $subtotal * $rate;
$afterDiscount = $subtotal - $discount;
$tax = $afterDiscount * 0.20;
$total = $afterDiscount + $tax;

// Display order receipt.
include 'header.php';

echo '<h2>Order Receipt</h2>';

echo '<p>Customer: ' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</p>';
echo '<p>Customer Type: ' . htmlspecialchars($type) . '</p>';

echo '<h3>Items Ordered</h3>';

for ($i = 1; $i <= $quantity; $i++) {
    echo '<p>' . $i . '. '
        . htmlspecialchars($productName)
        . ' - PHP ' . number_format($price, 2)
        . '</p>';
}

echo '<p>Subtotal: PHP ' . number_format($subtotal, 2) . '</p>';
echo '<p>Discount: PHP ' . number_format($discount, 2) . '</p>';
echo '<p>Tax (20%): PHP ' . number_format($tax, 2) . '</p>';

echo '<h2>Final Bill: PHP ' . number_format($total, 2) . '</h2>';

echo '<p>Budget: PHP ' . number_format($budget, 2) . '</p>';

if ($budget >= $total) {
    echo '<p class="success">Your budget is sufficient!</p>';
    echo '<p>Remaining Balance: PHP '
        . number_format($budget - $total, 2)
        . '</p>';
} else {
    echo '<p class="error">Insufficient budget!</p>';
    echo '<p>Additional Amount Needed: PHP '
        . number_format($total - $budget, 2)
        . '</p>';
}

// Display preparation progress.
echo '<h3>Order Preparation Progress</h3>';

$counter = 1;

while ($counter <= $quantity) {
    echo '<p>Preparing item '
        . $counter . ' of ' . $quantity
        . '</p>';

    $counter++;
}

echo '<p><a href="index.php">Place Another Order</a></p>';

include 'footer.php';

?>
