<?php
declare(strict_types=1);

// Product inventory array.
$product = [
    'Dog Collar' => [
        'price' => 400,
        'stock' => 50
    ],

    'Pet Bandana' => [
        'price' => 250,
        'stock' => 35
    ],

    'Paw Toy' => [
        'price' => 200,
        'stock' => 20
    ],

    'Pet Leash' => [
        'price' => 350,
        'stock' => 40
    ],

    'Pet Bowl' => [
        'price' => 300,
        'stock' => 25
    ]
];

// Global tax rate.
$tax_rate = 0;

// Checks whether a product needs to be reordered.
function get_order_message(int $stock): string {
    return ($stock < 10) ? 'Yes' : 'No';
}

// Calculates the total value of available stock.
function get_total_value(float $price, int $quantity): float {
    return $price * $quantity;
}

// Calculates the tax due for the available stock.
function get_tax_due(
    float $price,
    int $quantity,
    int $tax_rate = 0
): float {
    return ($price * $quantity) * ($tax_rate / 100);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pawlished | Stock Control</title>

    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <?php include 'includes/header.php'; ?>

    <main class="stock-main">

        <section class="stock-heading">
            <span class="eyebrow">Inventory Management</span>

            <h2>Stock Control</h2>

            <p>
                Monitor the available inventory, reorder requirements,
                total stock value, and estimated tax for Pawlished products.
            </p>
        </section>

        <section class="stock-card">

            <div class="stock-table-wrapper">

                <table class="stock-table">

                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Stock</th>
                            <th>Re-order</th>
                            <th>Total Value</th>
                            <th>Tax Due</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        foreach ($product as $product_name => $data) {

                            $price = $data['price'];
                            $stock = $data['stock'];

                            $order_message = get_order_message($stock);

                            $total_value = get_total_value(
                                $price,
                                $stock
                            );

                            $tax_due = get_tax_due(
                                $price,
                                $stock,
                                $tax_rate
                            );

                            echo '<tr>';

                            echo '<td class="product-name">'
                                . htmlspecialchars($product_name, ENT_QUOTES, 'UTF-8')
                                . '</td>';

                            echo '<td>' . $stock . '</td>';

                            echo '<td>';

                            if ($order_message === 'Yes') {
                                echo '<span class="stock-warning">Yes</span>';
                            } else {
                                echo '<span class="stock-available">No</span>';
                            }

                            echo '</td>';

                            echo '<td>PHP '
                                . number_format($total_value, 2)
                                . '</td>';

                            echo '<td>PHP '
                                . number_format($tax_due, 2)
                                . '</td>';

                            echo '</tr>';
                        }
                        ?>

                    </tbody>

                </table>

            </div>

            <div class="stock-note">
                <p>
                    <strong>Reorder Reminder:</strong>
                    Products with fewer than 10 pieces in stock
                    are marked for reordering.
                </p>

                <p>
                    <strong>Tax Rate:</strong>
                    <?php echo $tax_rate; ?>%
                </p>
            </div>

        </section>

        <a href="index.php" class="button stock-back">
            Back to Shop
        </a>

    </main>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
