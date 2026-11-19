<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawlished | Pet Accessories</title>

    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <main>

        <section id="home">
            <div class="hero-copy">
                <span class="eyebrow">Made for happy paws</span>
                <h2>Everyday comfort.<br>Extra personality.</h2>
                <p>
                    Discover stylish, comfortable accessories made to keep
                    your furry companion looking and feeling their best.
                </p>
                <a class="button" href="#cart">Shop the collection</a>
            </div>
        </section>

        <div class="shop-grid">
            <section id="products" class="card">
                <?php include 'menu.php'; ?>
            </section>

            <section id="cart" class="card">
                <span class="eyebrow">Easy checkout</span>
                <h2>Place Your Order</h2>

                <p class="section-intro">
                    Choose an accessory and treat your furry friend!
                </p>

                <form method="POST" action="process.php">

                <label for="customer_name">Customer Name:</label>
                <input
                    type="text"
                    id="customer_name"
                    name="customer_name"
                    required
                >

                <label for="customer_type">Customer Type:</label>
                <select
                    id="customer_type"
                    name="customer_type"
                    required
                >
                    <option value="regular">Regular Customer</option>
                    <option value="member">Pawlished Member</option>
                    <option value="groomer">Pet Groomer</option>
                </select>

                <label for="product">Select Product:</label>
                <select
                    id="product"
                    name="product"
                    required
                >
                    <option value="P1">P1 - Dog Collar</option>
                    <option value="P2">P2 - Pet Bandana</option>
                    <option value="P3">P3 - Paw Toy</option>
                    <option value="P4">P4 - Pet Leash</option>
                    <option value="P5">P5 - Pet Bowl</option>
                </select>

                <label for="quantity">Quantity:</label>
                <input
                    type="number"
                    id="quantity"
                    name="quantity"
                    min="1"
                    max="10"
                    required
                >

                <label for="budget">Budget (PHP):</label>
                <input
                    type="number"
                    id="budget"
                    name="budget"
                    min="0"
                    step="0.01"
                    required
                >

                <button type="submit">Process Order</button>

                </form>
            </section>
        </div>

    </main>

    <?php include 'includes/footer.php'; ?>

</body>
</html>