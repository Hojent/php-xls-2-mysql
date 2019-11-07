<?php include ('head.php')?>
<div class="container">
    <h4><?php echo $title; ?></h4>
        <form method="POST" action="" class="container-fluid">
            <div class="form-group">
                <label for="file">File Name:</label>
                <input type="file" class="form-control" name="file" value=""/>
            </div>
                <input type="hidden" name="form-submitted" value="1" />
                <input type="submit" class="btn btn-send" value="Submit" />
            </form>
</div>
<?php include ('foot.php');