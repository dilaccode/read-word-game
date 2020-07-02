<h2>
    <?php
    echo "Read: " . $AmountRead . "/" . count($ListWords);
    echo " (" . round($AmountRead / count($ListWords) * 100, 1) . "%)";
    ?>
</h2>
<table class="w3-table-all w3-large">
    <!-- fileds -->
    <tr class="">
        <th>Index</th>
        <th>Word</th>
        <th>Read</th>
    </tr>
    <!-- data -->
    <?php $Index = 1; ?>
    <?php foreach ($ListWords as $WordObj): ?>
        <tr>
            <td><?php echo $Index++; ?></td>
            <td><?php echo $WordObj->Word; ?></td>
            <td><?php echo number_format($WordObj->LearnTime); ?></td>
        </tr>
    <?php endforeach; ?>
</table>