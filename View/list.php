<?php include ('head.php');?>
<div id="container">
<div class="panel-body" >
        <table border="0" cellpadding="0" cellspacing="0" class="table-inbox">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Наименование товара</th>
                    <th>Стоимость, руб</th>
                    <th>Стоимость опт, руб</th>
                    <th>Наличие на складе 1, шт</th>
                    <th>Наличие на складе 2, шт</th>
                    <th>Страна производства </th>
                    <th>Примечание</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $task): ?>
                <?php
                if ($task['rozn'] == $rozn_max) {
                    $roznClass = 'red-bg';
                } elseif ($task['opt'] == $opt_min) {
                    $optClass = 'green-bg';
                } else {
                    $roznClass = '';
                    $optClass = '';
                }
                ?>
                    <tr class="some-div" >
                        <td><?php echo $task['id']; ?></td>
                        <td><?php print htmlentities($task['title'], ENT_QUOTES);
                            ?>
                        </td>
                        <td class="<?php echo $roznClass; ?>" roz-val = "<?php print htmlentities($task['rozn'], ENT_QUOTES); ?> " >
                            <?php print htmlentities($task['rozn'], ENT_QUOTES); ?>
                        </td>
                        <td class="<?php echo $optClass; ?>" opt-val = "<?php print htmlentities ($task['opt']); ?>">
                            <?php print htmlentities ($task['opt']); ?>
                        </td>
                        <td sklad1-val="<?php print htmlentities ($task['sklad1']); ?>"><?php print htmlentities ($task['sklad1']); ?></td>
                        <td sklad2-val="<?php print htmlentities ($task['sklad2']); ?>"><?php print htmlentities ($task['sklad2']); ?></td>
                        <td><?php print htmlentities ($task['country']); ?></td>
                        <td><?
                            if (($task['sklad1'] < 20 ) OR ($task['sklad2'] < 20)) {
                                echo ('Осталось мало. Срочно докупите!');
                                } ?></td>

                    </tr>
                <?php endforeach; ?>
            <tr>
                <td></td>
                <td></td>
                <td class="yellow-bg"><?php echo $rozn_aver;?></td>
                <td class="teal-bg"><?php echo $opt_aver;?></td>
                <td class="yellow-bg"><?php echo $sklad1Sum;?></td>
                <td class="teal-bg"><?php echo $sklad2Sum;?></td>
                <td></td>
                <td></td>
            </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Всего товаров</td>
                    <td class="blue-bg" colspan="2"><?php echo $sklad1Sum + $sklad2Sum; ?></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
          </table>
	</div>
</div> <!-- container -->
<?php include ('foot.php');
//</body> </html>