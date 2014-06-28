<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<head>
	<meta http-equiv="Content-Type" content="text/xhtml; charset=UTF-8">
	<link rel="shortcut icon" href="http://www.clker.com/cliparts/z/S/4/7/O/l/world-black-and-white-md.png" type="image/x-icon">
	<title>MIC - Mapa Interativo do Campus II UFG</title>
	
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
</head>
<body>
	<?php
		
		class MyStruct { // CRIA A ESTRUTURA DE DADOS
			public $nome; //NOME DO LOCAL
			public $tipo; //TIPO DO LOCAL
			public $local; //COORDENADAS DO LOCAL
		}
		
		$terreno = ($_GET['terreno'])? $_GET['terreno'] : 'ROADMAP'; $terreno = mb_strtoupper($terreno); //CONSTROI O TIPO DE TERRENO DO MAPA
		$markers = explode(';',$_GET['mark']); //ARRAY DE MARKS PRIMITIVOS
		$m = array(); //ARRAY DE MARKS
		
		for($i=0; $i<count($markers); $i++){
			$mark =  explode('_',$markers[$i]); //ARRAY DE UM MARK PRIMITIVO
			$m[$i] = new MyStruct(); //CRIA STRUCT DO MARK
			$nome = explode(':', $mark[0]); //SEPARA A VARIAVEL NOME
			$m[$i]->nome = $nome[1]; //INSERE O NOME NA STRUCT
			$tipo = explode(':', $mark[1]); //SEPARA A VARIAVEL TIPO
			$m[$i]->tipo = $tipo[1]; //INSERE O TIPO NA STRUCT
			$local = explode(':', $mark[2]); //SEPARA A VARIAVEL LOCAL
			$m[$i]->local =  $local[1]; //INSERE O LOCAL NA STRUCT
		}
		
		//INFORMACAO DE DEBUG
		#var_dump($markers); echo "<br>";
		#var_dump($mark); echo "<br>";
		#var_dump($m); echo "<br>";
		#var_dump($terreno); echo "<br>";
	?>
	
	<!--<img src='http://maps.googleapis.com/maps/api/staticmap?center=-16.604953,-49.263167&language=portugues&scale=2&zoom=16&size=1280x440&maptype=roadmap&markers=color:black%7Clabel:U%7C-16.606043,-49.261767&sensor=false' style='height:100%; max-width:80%; top:0; right:0px; position:absolute;'/>-->

	<div id="map-canvas" style="height:100%; width:100%; position:absolute; top:0; left:0;"></div>
	<script>
		
		function initialise() {
			
			var myLatlng = new google.maps.LatLng(-16.604953,-49.263167); // COORDENADA DO CENTRO
			var mapOptions = {
				zoom: 17, // The initial zoom level when your map loads (0-20)
				minZoom: 16, // Minimum zoom level allowed (0-20)
				maxZoom: 20, // Maximum soom level allowed (0-20)
				zoomControl:true, // Set to true if using zoomControlOptions below, or false to remove all zoom controls.
				zoomControlOptions: {
					style:google.maps.ZoomControlStyle.DEFAULT // Change to SMALL to force just the + and - buttons.
				},
				center: myLatlng, // Centre the Map to our coordinates variable
				mapTypeId: google.maps.MapTypeId.<?php echo $terreno; ?>, // Set the type of Map
				scrollwheel: false, // Disable Mouse Scroll zooming (Essential for responsive sites!)
				// All of the below are set to true by default, so simply remove if set to true:
				panControl:false, // Set to false to disable
				mapTypeControl:false, // Disable Map/Satellite switch
				scaleControl:false, // Set to false to hide scale
				streetViewControl:false, // Set to disable to hide street view
				overviewMapControl:false, // Set to false to remove overview control
				rotateControl:false // Set to false to disable rotate control
			}
			var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions); // CRIA O MAPA NA DIV INDICADA
			
			var i0 = new google.maps.MarkerImage("http://kartagoroda.com.ua/f/logo.png", null, null, null, new google.maps.Size(50,52)); // CRIA UM ICONE
			var i1 = new google.maps.MarkerImage("http://kartagoroda.com.ua/f/logo.png", null, null, null, new google.maps.Size(50,52)); // CRIA UM ICONE
			var i2 = new google.maps.MarkerImage("http://kartagoroda.com.ua/f/logo.png", null, null, null, new google.maps.Size(50,52)); // CRIA UM ICONE
			var i3 = new google.maps.MarkerImage("http://kartagoroda.com.ua/f/logo.png", null, null, null, new google.maps.Size(50,52)); // CRIA UM ICONE
			
			
			<?php
				for($i=0; $i<count($markers); $i++){
					echo "
					myLatlng = new google.maps.LatLng(".$m[$i]->local."); // COORDENADAS DO LOCAL
					var marker".$i." = new google.maps.Marker({ // CRIA UM LOCAL
						position: myLatlng, // POSICAO DO LOCAL
						icon: ".$m[$i]->tipo.", // ICONE DO LOCAL
						map: map, // INDICA O MAPA
						title: '".$m[$i]->nome."' // NOME DO LOCAL
					});
					
					var infowindow".$i." = new google.maps.InfoWindow({ // CRIA UMA JANELA DE DESCRICAO
						content:'<center><h3>".$m[$i]->nome."</h3></center>' // CONTEUDO DA JANELA EM HTML
					});
					
					google.maps.event.addListener(marker".$i.", 'click', function() { // ASSOCIA DESCRICAO A UM LOCAL
						infowindow".$i.".open(map, marker".$i."); // ABRE A JANELA AO CLICAR NO LOCAL
					});";
				}
				
			?>
			// 	google.maps.event.addListener(marker, 'click', function() { // Add a Click Listener to our marker 
			//		window.location='http://www.snowdonrailway.co.uk/shop_and_cafe.php'; // URL to Link Marker to (i.e Google Places Listing)
			// 	});
			
			google.maps.event.addDomListener(window, 'resize', function() { map.setCenter(myLatlng); }); // Keeps the Pin Central when resizing the browser on responsive sites
		}
		google.maps.event.addDomListener(window, 'load', initialise); // INICIALIZA O MAPA QUANDO A PAGINA CARREGA
	</script>
</body>
</html>
