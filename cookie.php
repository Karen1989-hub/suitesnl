<?php
$result_cookies1 = isset($_COOKIE['collections']) ?  unserialize($_COOKIE['collections']) : [];
?>

<div id="wrapper">
<?php if(isset($result_cookies1) && !empty($result_cookies1)): ?>
    <h1 style="text-align:center;">result of collection cookies (cookie.php) </h1>
    <?php foreach($result_cookies1 as $result_cookies2): ?>
        <table>
            <tr>
                <th>naam</th>
                <th>url</th>
                <th>arrival</th>
                <th>departure</th>
            </tr>
            <tr>
                <td><?php echo isset($result_cookies2['name']) ? $result_cookies2['name'] : '';  ?></td>
                <td><?php echo isset($result_cookies2['url']) ? $result_cookies2['url'] : ''; ?></td>
                <td><?php echo isset($result_cookies2['arrival']) ? $result_cookies2['arrival'] : ''; ?></td>
                <td><?php echo isset($result_cookies2['departure']) ? $result_cookies2['departure'] : ''; ?></td>
            </tr>
        </table>
<?php endforeach; ?>
    <?php else: echo "<p style='text-align:center;'>NO DATA</>"; ?>
<?php endif;?>
</div>

