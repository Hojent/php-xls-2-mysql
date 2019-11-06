<?php include ('head.php');
//<body>
?>
<div class="container">
<div class="panel-heading panel-content">
    <a href="index.php?op=new">Add new task</a>
</div>
<div class="panel-body">
        <table border="0" cellpadding="0" cellspacing="0" class="tasks">
            <thead>
                <tr>
                    <th><a href="?orderby=name">Name</a></th>
                    <th><a href="?orderby=email">Email</a></th>
                    <th>Text</th>
                    <th><a href="?orderby=done">Status</a></th>
                    <?php if ($_SESSION['USERNAME'] == 'admin') {
                        echo '<th>Action</th>';
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php print htmlentities($task['name'], ENT_QUOTES);
                            if ($task['edit']) {
                                echo '<br><span class="green-bg small">(edited by Administrator)</span>';
                            }
                            ?>
                        </td>
                        <td><?php print htmlentities($task['email'], ENT_QUOTES); ?></td>
                        <td><?php print htmlentities ($task['task']); ?>
                        </td>
                        <td><?php
                                if ($task['done'] == 0) {
                                    echo '<span class=" green-bg container-fluid"><b>Done</b></span>';
                                } else {
                                    echo 'In progress';
                                }
                            ?>
                        </td>
                        <?php if ($_SESSION['USERNAME'] == 'admin') {
                           echo "<td><a href='index.php?op=edit&id=".$task['id']."'>edit</a></td>";
                        }
                        ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
</div>
</div>
    <br>
    <div class="container">
        <?php
            $pagLink = "<ul class='pagination'>";
            for ($i = 1; $i <= $total; $i++) {
                $pagLink .= "<li class='page-item'><a class='page-link' href='index.php?page=".$i."'>".$i."</a></li>";
            }
            echo $pagLink . "</ul>";
        ?>
    </div>

    <br>
    <div class="container">
    <div class="panel border-top">
    <div class="panel-heading panel-content">
<?php
    if ( isset($_SESSION['USERNAME']) ) {
    echo 'Access allowed!'."\n";
    echo 'Hello, '. $_SESSION['USERNAME'].PHP_EOL;?>
    <a href="/Views/logout.php">Logout</a>

<?php } else {
    echo 'Access denied'.PHP_EOL;
    ?>
    <a href="/Views/login-form.php">Login</a>
    <?php } ?>
    </div>
    </div>
    </div>
<?php include ('foot.php');
//</body> </html>