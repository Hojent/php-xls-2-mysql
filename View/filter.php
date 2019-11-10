<?php include ('head.php');?>

<div id="container">
 <div class="panel-info" id="form">
     <form method="post" id="ajax-form">
            <label for="cost">Показать товары, у которых</label>
            <select name="curCost" id="cost"> <!-- curCost [1,2] -->
                <option value = 1>Розничная цена</option>
                <option value = 2>Оптовая цена</option>
            </select>
            <label for="min"> в пределах от </label>
            <input type="number" name="curMin" id='min' value="0" ><!-- curMin -->
            <label for="max"> до </label>
            <input type="number" name="curMax" id='max' value="500000"> <!-- curMax -->
            <label for="znak"> и на складе </label>
            <select name="curZnak" id="znak"> <!-- curZnak [1,2]-->
                <option value = 3>Больше</option>
                <option value = 4>Меньше<option>
            </select>
            <label for="sklad"> чем </label>
            <input type="number" name="curSklad" id="sklad" value=0> <!-- curSklad -->
            <input type="button" id="btn" value="Показать">
     </form>
   </div>
    <div class="panel-content" id="filtered">Выберите параметры для поиска </div>
</div><!-- container -->
   <?php include ('foot.php');
//</body> </html>