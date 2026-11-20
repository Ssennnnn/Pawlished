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

if ($valid) {

    // Identify the selected product.
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
        $errorMessage = 'Insufficient stock. Available stock: '
            . $stock . ' pieces.';
    } else {

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
    }

} else {
    $errorMessage = 'Invalid order. Please check your input.';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawlished | Order Receipt</title>

    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="receipt-page">

    <div class="receipt-paper">

        <?php include 'includes/header.php'; ?>

        <main class="receipt-content">

            <?php if (isset($errorMessage)): ?>

                <h2>Order Error</h2>

                <p class="error">
                    <?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?>
                </p>

                <a href="index.php" class="button">Return to Order Form</a>

            <?php else: ?>

                <div class="receipt-heading">
                    <h2>Order Receipt</h2>
                    <p>Thank you for shopping with Pawlished!</p>
                </div>

                <div class="receipt-details">
                    <p>
                        <strong>Customer:</strong>
                        <?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>
                    </p>

                    <p>
                        <strong>Customer Type:</strong>
                        <?php echo htmlspecialchars(ucfirst($type), ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                </div>

                <h3>Items Ordered</h3>

                <div class="receipt-items">

                    <div class="receipt-item receipt-item-header">
                        <span>Item</span>
                        <span>Price</span>
                    </div>

                    <?php
                    for ($i = 1; $i <= $quantity; $i++) {
                        echo '<div class="receipt-item">';
                        echo '<span>' . $i . '. '
                            . htmlspecialchars($productName, ENT_QUOTES, 'UTF-8')
                            . '</span>';
                        echo '<span>PHP ' . number_format($price, 2) . '</span>';
                        echo '</div>';
                    }
                    ?>

                </div>

                <div class="receipt-summary">

                    <p>
                        <span>Subtotal</span>
                        <span>PHP <?php echo number_format($subtotal, 2); ?></span>
                    </p>

                    <p>
                        <span>Discount</span>
                        <span>PHP <?php echo number_format($discount, 2); ?></span>
                    </p>

                    <p>
                        <span>Tax (20%)</span>
                        <span>PHP <?php echo number_format($tax, 2); ?></span>
                    </p>

                </div>

                <div class="receipt-total">
                    <span>Final Bill</span>
                    <span>PHP <?php echo number_format($total, 2); ?></span>
                </div>

                <div class="receipt-budget">

                    <p>
                        <span>Budget</span>
                        <span>PHP <?php echo number_format($budget, 2); ?></span>
                    </p>

                    <?php if ($budget >= $total): ?>

                        <p class="success">
                            Budget is sufficient!
                        </p>

                        <p>
                            <span>Remaining Balance</span>
                            <span>PHP <?php echo number_format($budget - $total, 2); ?></span>
                        </p>

                    <?php else: ?>

                        <p class="error">
                            Insufficient budget!
                        </p>

                        <p>
                            <span>Additional Amount Needed</span>
                            <span>PHP <?php echo number_format($total - $budget, 2); ?></span>
                        </p>

                    <?php endif; ?>

                </div>

                <h3>Order Preparation Progress</h3>

                <div class="receipt-progress">

                    <?php
                    $counter = 1;

                    while ($counter <= $quantity) {
                        echo '<p>Preparing item '
                            . $counter . ' of ' . $quantity
                            . '</p>';

                        $counter++;
                    }
                    ?>

                </div>

                <div class="receipt-actions">
                    <a href="index.php" class="button">Place Another Order</a>
                </div>

            <?php endif; ?>

        </main>

        <?php include 'includes/footer.php'; ?>

    </div>

</body>
</html>
