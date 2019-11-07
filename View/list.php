<?php include ('head.php');
//<body>
?>
<div class="container">
<div class="panel-heading panel-content">
    <a href="/">Load new file</a>
</div>
<div class="panel-body">
        <table border="0" cellpadding="0" cellspacing="0" class="tasks">
            <thead>
                <tr>
                    <th><a href="?orderby=title">Наименование товара</a></th>
                    <th><a href="?orderby=rozn">Стоимость, руб</a></th>
                    <th>Стоимость опт, руб</th>
                    <th>Наличие на складе 1, шт</th>
                    <th>Наличие на складе 2, шт</th>
                    <th>Страна производства </th>
                    <th>Примечание</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $task): ?>
                    <tr>
                        <td><?php print htmlentities($task['title'], ENT_QUOTES);
                            ?>
                        </td>
                        <td><?php print htmlentities($task['rozn'], ENT_QUOTES); ?></td>
                        <td><?php print htmlentities ($task['opt']); ?></td>
                        <td><?php print htmlentities ($task['sklad1']); ?></td>
                        <td><?php print htmlentities ($task['sklad2']); ?></td>
                        <td><?php print htmlentities ($task['country']); ?></td>
                        <td><?
                            if (($task['sklad1'] + $task['sklad2']) < 100 ) {
                                echo ('Спешите купить');
                                } ?></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
</div>
</div>
    <br>
    <div class="container">
        <div class="panel border-top">
            <div class="panel-heading panel-content">
        <?php
            $pagLink = "<ul class='pagination'>";
            for ($i = 1; $i <= $total; $i++) {
                $pagLink .= "<li class='page-item'><a class='page-link' href='index.php?page=".$i."'>".$i."</a></li>";
            }
            echo $pagLink . "</ul>";
        ?>
            </div>
        </div>
    </div>

<?php include ('foot.php');
//</body> </html>