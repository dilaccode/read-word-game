<div class="w3-container">
  <h2>System Stats</h2>
  <table class="w3-table-all w3-large">
    <!-- fileds -->
    <tr class="">
      <th>Data</th>
      <th>Count</th>
    </tr>
    <!-- data -->
    <tr>
      <td>Words</td>
      <td><?php echo $TotalWords ?></td>
    </tr>
  </table>

  <!-- Word Length Count -->
  <h2>Word Length Count</h2>
  <table class="w3-table-all w3-large">
    <!-- fileds -->
    <tr class="">
      <th>Word Length</th>
      <th>Count</th>
    </tr>
    <!-- data -->
    <?php foreach($ListWordsLengthCount as $WordLengthCount):?>
      <tr>
        <td><?php echo $WordLengthCount->WordLength; ?></td>
        <td><?php echo number_format($WordLengthCount->Count); ?></td>
      </tr>
    <?php endforeach;?>
  </table>
</div>
