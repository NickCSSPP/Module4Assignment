<?php
  
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Nike Shoes</title>
        <link rel="stylesheet" type="text/css" href="main.css">
    </head>
<body>
    <main>
        <h1>Nike Shoes Store</h1>
            <?php if (!empty($error_message)) { ?>
                <p> class="error"><?php echo $error_message; ?></p>
            <?php } //end if ?>
            <form action="display_results.php" method="post">
                <div id="data">
                    <label>Cost of Shoes:</label>
                    <select name="cost">
                        <?php for ($v = 50; $v <=150; $v += 20) : ?>
                            <option value="<?php echo $v; ?>" >
                                $<?php echo $v; ?>
                        </option>
                    <?php endfor; ?>
                    </select><br>
                </div>
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity">
                <br>

                <label for="member">Are you a member?</label>
                <input type="checkbox" name="member" id="member" value="true">
                <br>

                <label for="waterproof">Waterproof?</label>
                <input type="checkbox" name="waterproof" id="waterproof" value="true">
                <br>

                <label for="username">Username:</label>
                <input type="text" name="username" id="username">
                <br>

                <label for="phone">Phone number:</label>
                <input type="tel" name="phone" id="phone">
                <br>

                <label for="email">Email address:</label>
                <input type="email" name="email" id="email">
                <br>
                
                <input type="submit" value="Calculate Cost">
            </form>
     </main>
</body>
</html>