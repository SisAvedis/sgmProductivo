<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-multiselect.css">
<link rel="stylesheet" href="css/jquery-ui.css">
<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script> <!-- Cuidado. Antes jquery js que bootstrap js-->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
</head>

<script type="text/javascript">
    $(document).ready(function() {
        $('#category').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            buttonContainer: '<div class="btn-group w-100" />'
        });
    
		//var sProd = jq('select[name=producto] option').filter(':selected').text();
		//var sPrid = jq('select[name=producto] option').filter(':selected').val();
	
	
	});
</script>

<?php
	$clientes = '';
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$clienteOption = isset($_POST['example-post']) ? $_POST['example-post'] : false;;
		$categoryIds = $_POST['category'];
		foreach ($categoryIds as $categoryId) {
			$clientes = $clientes.' | '.$categoryId;
			$error = true;
		}
		echo "<pre>";
		echo 'Volviendo -> '.$clientes."</br>";
		echo "</pre>";
	}else{
		echo '';
	}
?>

<form class="form-horizontal" method="POST" action="scrap.php">
    <div class="form-group">
        <label for="example-post">Multiselect</label>
            <select id="category" name="category[]" multiple="multiple">
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
                <option value="4">Option 4</option>
                <option value="5">Option 5</option>
                <option value="6">Option 6</option>
            </select>
        </div>
    <!--
	<div class="form-group">
        <label>Text Input</label>
            <input type="text" name="text" class="form-control" placeholder="Text Input" />
    </div>
	-->
    <div class="form-group">
        <!--
		<div class="form-check">
            <input id="checkbox" type="checkbox" name="checkbox" class="form-check-input">
            <label class="form-check-label" for="checkbox">Checkbox</label>
        </div>
		-->
    </div>
    <div class="form-group">
        <!--
		<div class="form-check">
            <input id="radio1" type="radio" name="radio" class="form-check-input">
            <label class="form-check-label" for="radio1">Radio 1</label>
        </div>
        <div class="form-check">
            <input id="radio2" type="radio" name="radio" class="form-check-input">
            <label class="form-check-label" for="radio2">Radio 2</label>
        </div>
		-->
     </div>
            <button type="submit" class="btn btn-default">Submit</button>
</form>