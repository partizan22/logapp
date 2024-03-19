<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css" crossorigin="anonymous">
	<link rel="stylesheet" href="/css/datatables.min.css" crossorigin="anonymous">
   
	
	<link rel="stylesheet" href="/js/jquery-ui.min.css">
	
	<link href="/css/styles.css" rel="stylesheet" />

	<script src="/js/language.js" crossorigin="anonymous"></script>
	<script src="/js/functions.js" crossorigin="anonymous"></script>
	
	<script src="/js/jquery-3.7.1.min.js"></script>
	<script src="/js/jquery-ui.min.js"></script>
	<script src="/js/jquery.Jcrop.min.js"></script>

	<script src="/js/bootstrap.min.js" crossorigin="anonymous"></script>
	<script src="/js/datatables.min.js" crossorigin="anonymous"></script>

	<?php if (!empty($include_js)) { foreach ($include_js as $js) { ?>
	<script src="<?= $js ?>?<?= time() ?>"></script>
	<?php }} ?>

    <title><?= $title ?></title>
    
    <style>        
      
    </style>
	
	<script>
		init(<?= json_encode($_GET) ?>);
		
		<?php foreach ($_js_data as $key => $val) { ?>
			var <?= $key ?> = <?= json_encode($val) ?>;
		<?php } ?>
			
	</script>
	
  </head>
  <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <div class="container px-4">
                <a class="navbar-brand" href="/">Головна</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto">
						<?php foreach ([
							'/book/' => 'Облік майна',
							'/document/' => 'Документи',
							//'/term/' => 'Довідник',
						] as $h=>$m) {  ?>
						<li class="nav-item <?= strpos($_SERVER['REQUEST_URI'], $h) === 0 ? 'active' : '' ?>"><a class="nav-link" href="<?= $h ?>"><?= $m ?></a></li>
						<?php } ?>
						
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header-->
        <header class="bg-primary bg-gradient text-white">
			<div class="container">
				<h1 class="page-title"><?= $title ?></h1>
			</div>

        </header>
     
	  <div style="height: 15px"></div>
	  
	  <?php echo $contents; ?>
        
		<footer class="py-5 bg-dark">
            <div class="container px-4"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        
        <!-- Core theme JS-->
        <script src="/js/scripts.js"></script>
		
  </body>
</html>