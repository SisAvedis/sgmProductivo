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

<!-- Build your select: -->
<div class="multiselect-container dropdown-menu show">
    <div class="multiselect-item multiselect-filter">
        <div class="input-group input-group-sm p-1">
            <div class="input-group-prepend">
                <i class="input-group-text fas fa-search"></i>
            </div>
            <input class="form-control multiselect-search" type="text" placeholder="Search">
            <div class="input-group-append">
                <button class="multiselect-clear-filter input-group-text" type="button">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    <a class="multiselect-option dropdown-item multiselect-item multiselect-all">
        <span class="form-check d-inline-flex" title="Select all">
            <input class="form-check-input" type="checkbox" value="multiselect-all">
            <label class="form-check-label font-weight-bold">Select all</label>
        </span>
    </a>
    <div class="multiselect-reset text-center p-2">
        <a class="btn btn-sm btn-block btn-outline-secondary">Reset</a>
    </div>
    <div class="multiselect-item dropdown-divider mt-0"></div>
    <a class="multiselect-item multiselect-group dropdown-item">
        <input type="checkbox" value="undefined">
        Fruits
        <span class="caret-container dropdown-toggle pl-1"></span>
    </a>
    <a class="multiselect-option dropdown-item">
        <span class="form-check d-inline-flex" title="Apple">
            <input class="form-check-input" type="checkbox" value="Apple">
            <label class="form-check-label">Apple</label>
        </span></a>
    <a class="multiselect-option dropdown-item">
        <span class="form-check d-inline-flex" title="Banana">
            <input class="form-check-input" type="checkbox" value="Banana">
            <label class="form-check-label">Banana</label>
        </span>
    </a>
    <a class="multiselect-item multiselect-group dropdown-item">
        <input type="checkbox" value="undefined"> 
        Vegetables
        <span class="caret-container dropdown-toggle pl-1"></span>
    </a>
    <a class="multiselect-option dropdown-item">
        <span class="form-check d-inline-flex" title="Potato">
            <input class="form-check-input" type="checkbox" value="Potato">
            <label class="form-check-label">Potato</label>
        </span>
    </a>
    <a class="multiselect-option dropdown-item">
        <span class="form-check d-inline-flex" title="Parsnip">
            <input class="form-check-input" type="checkbox" value="Parsnip">
            <label class="form-check-label">Parsnip</label>
        </span>
    </a>
</div>


<script type="text/javascript">
	$(document).ready(function() {
        $('#example-getting-started').multiselect({
			includeSelectAllOption: true,
			enableFiltering: true,

			buttonText: function(options, select) {
				if (options.length == 0) {
					return 'Select Groups';
				}
				else {
					var selected = '';
					options.each(function() {
						selected += $(this).text() + ', ';
					});
					return selected.substr(0, selected.length -2);
				}	
			},
		});
    });
</script>