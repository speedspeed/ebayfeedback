<?php
require_once("config.php");
?>
<a href="/feedback_csv.php">Download CSV with feedbacks</a>

<?php if (!isset($_SESSION['fbid'])) :?>
<a href="fb_login.php">login to facebook to upload pic</a>
<?php endif; ?>

<br>
<br>
<h3>Get Feedback Picture</h3>
<form action="feedback.php" method="GET">
    <label>Feedbacks Number</label>
    <select name="number">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">8</option>
        <option value="10">10</option>
    </select>
    <br>
    <input type="submit" value="Get">
</form>