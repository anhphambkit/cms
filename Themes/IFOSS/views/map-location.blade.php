@extends("layouts.master")
@section('styles')
    <style type="text/css">
        body{ background-color: #f5f5f5;}
        #chartdiv {
		  width: 100%;
		  height: 70vh;
		}
    </style>
    <style type="text/css">
    	.map-marker {
    /* adjusting for the marker dimensions
    so that it is centered on coordinates */
    margin-left: -8px;
    margin-top: -8px;
}
.map-marker.map-clickable {
    cursor: pointer;
}
.pulse {
    width: 10px;
    height: 10px;
    border: 5px solid #f7f14c;
    -webkit-border-radius: 30px;
    -moz-border-radius: 30px;
    border-radius: 30px;
    background-color: #716f42;
    z-index: 10;
    position: absolute;
  }
.map-marker .dot {
    border: 10px solid #fff601;
    background: transparent;
    -webkit-border-radius: 60px;
    -moz-border-radius: 60px;
    border-radius: 60px;
    height: 50px;
    width: 50px;
    -webkit-animation: pulse 3s ease-out;
    -moz-animation: pulse 3s ease-out;
    animation: pulse 3s ease-out;
    -webkit-animation-iteration-count: infinite;
    -moz-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
    position: absolute;
    top: -20px;
    left: -20px;
    z-index: 1;
    opacity: 0;
  }
  @-moz-keyframes pulse {
   0% {
      -moz-transform: scale(0);
      opacity: 0.0;
   }
   25% {
      -moz-transform: scale(0);
      opacity: 0.1;
   }
   50% {
      -moz-transform: scale(0.1);
      opacity: 0.3;
   }
   75% {
      -moz-transform: scale(0.5);
      opacity: 0.5;
   }
   100% {
      -moz-transform: scale(1);
      opacity: 0.0;
   }
  }
  @-webkit-keyframes "pulse" {
   0% {
      -webkit-transform: scale(0);
      opacity: 0.0;
   }
   25% {
      -webkit-transform: scale(0);
      opacity: 0.1;
   }
   50% {
      -webkit-transform: scale(0.1);
      opacity: 0.3;
   }
   75% {
      -webkit-transform: scale(0.5);
      opacity: 0.5;
   }
   100% {
      -webkit-transform: scale(1);
      opacity: 0.0;
   }
  }
</style>
    
@endsection

@section('content')
	<div class="container">
    	<div id="chartdiv">
    	</div>
    </div>
    <div class="modal-content d-none" id="lht">
		<div class="modal-body px-s1">
			<div class="text-uppercase text-custom mb-3">return reason</div>
			<div class="mb-3">
				<?php $checkboxList = array('No longer needed', 'Item defective', 'Wrong item was sent'); 
				foreach ($checkboxList as $key => $value) { ?>
					<div class="form-group">
						<div class="radio radio-custom pl-2">
							<input id="radio-<?php echo $key; ?>" type="radio" name="radio-list"/>
							<label for="radio-<?php echo $key; ?>"><?php echo $value; ?></label>
						</div>
					</div>
				<?php } ?>
			</div>
			<button type="button" class="btn btn-outline-custom btn-s1 btn-block justify-content-center mb-3">Submit</button>
		</div>
	</div>
@endsection

@section('master-footer')
	<script src="https://www.amcharts.com/lib/4/core.js"></script>
	<script src="https://www.amcharts.com/lib/4/maps.js"></script>
	<script src="https://www.amcharts.com/lib/4/geodata/worldLow.js"></script>
	<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
	<script>
		am4core.ready(function() {
		// Themes begin
		am4core.useTheme(am4themes_animated);
		// Themes end

		// Create map instance
		var chart = am4core.create("chartdiv", am4maps.MapChart);
		chart.geodata = am4geodata_worldLow;
		chart.projection = new am4maps.projections.Miller();
		chart.maxZoomLevel = 1;
		chart.seriesContainer.draggable = false;
		chart.seriesContainer.resizable = false;
		// Create map polygon series
		var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());

		// Make map load polygon (like country names) data from GeoJSON
		polygonSeries.useGeodata = true;

		var polygonTemplate = polygonSeries.mapPolygons.template;
		polygonTemplate.tooltipText = "{name}";
		polygonTemplate.fill = chart.colors.getIndex(0).lighten(0.5);

		// Create map polygon series
		var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
		polygonSeries.useGeodata = true;
		polygonSeries.mapPolygons.template.fill = chart.colors.getIndex(0).lighten(0.5);
		polygonSeries.mapPolygons.template.nonScalingStroke = true;
		polygonSeries.exclude = ["AQ"];

		// Add line bullets
		var cities = chart.series.push(new am4maps.MapImageSeries());
		cities.mapImages.template.nonScaling = true;
		var imageSeriesTemplate = cities.mapImages.template;

		var city = cities.mapImages.template.createChild(am4core.Circle);
		city.radius      = 6;
		city.strokeWidth = 2;
		city.fill        = am4core.color("#B27799");
		city.stroke      = am4core.color("#FFFFFF");
		imageSeriesTemplate.propertyFields.latitude = "latitude";
		imageSeriesTemplate.propertyFields.longitude = "longitude";

		function addCity(coords, html) {
		    var city = cities.mapImages.create();
		    city.latitude = coords.latitude;
		    city.longitude = coords.longitude;
		    city.tooltipHTML = html;
		    city.fill = am4core.color("#f5f5f5");
		    console.log(city)
		    return city;
		}

		var html = $('#lht').html();
		var paris   = addCity({ "latitude": 48.8567, "longitude": 2.3510 }, html);
		var toronto = addCity({ "latitude": 43.8163, "longitude": -79.4287 }, html);
		var la      = addCity({ "latitude": 34.3, "longitude": -118.15 }, html);
		var havana  = addCity({ "latitude": 23, "longitude": -82 }, html);

		// Add lines
		var lineSeries = chart.series.push(new am4maps.MapArcSeries());
		lineSeries.mapLines.template.line.strokeWidth = 2;
		lineSeries.mapLines.template.line.strokeOpacity = 0.5;
		lineSeries.mapLines.template.line.stroke = am4core.color("#B27799");
		lineSeries.mapLines.template.line.nonScalingStroke = true;
		lineSeries.mapLines.template.line.strokeDasharray = "1,1";
		lineSeries.zIndex = 10;

		var shadowLineSeries = chart.series.push(new am4maps.MapLineSeries());
		shadowLineSeries.mapLines.template.line.strokeOpacity = 0;
		shadowLineSeries.mapLines.template.line.nonScalingStroke = true;
		shadowLineSeries.mapLines.template.shortestDistance = false;
		shadowLineSeries.zIndex = 5;

		function addLine(from, to) {
		    var line = lineSeries.mapLines.create();
		    line.imagesToConnect = [from, to];
		    line.line.controlPointDistance = -0.3;
		    var shadowLine = shadowLineSeries.mapLines.create();
		    shadowLine.imagesToConnect = [from, to];

		    return line;
		}

		addLine(paris, toronto);
		addLine(toronto, la);
		addLine(la, havana);

		var planePath = "m2,106h28l24,30h72l-44,-133h35l80,132h98c21,0 21,34 0,34l-98,0 -80,134h-35l43,-133h-71l-24,30h-28l15,-47";
		// Add plane
		var plane = lineSeries.mapLines.getIndex(0).lineObjects.create();
		plane.position = 0;
		plane.width = 48;
		plane.height = 48;

		plane.adapter.add("scale", (scale, target) => {
		    return 0.5 * (1 - (Math.abs(0.5 - target.position)));
		})

		var planeImage = plane.createChild(am4core.Sprite);
		planeImage.scale            = 0.08;
		planeImage.horizontalCenter = "middle";
		planeImage.verticalCenter   = "middle";
		planeImage.path             = planePath;
		planeImage.fill             = chart.colors.getIndex(2).brighten(-0.2);
		planeImage.strokeOpacity    = 0;

		var shadowPlane = shadowLineSeries.mapLines.getIndex(0).lineObjects.create();
		shadowPlane.position = 0;
		shadowPlane.width    = 48;
		shadowPlane.height   = 48;

		var shadowPlaneImage = shadowPlane.createChild(am4core.Sprite);
		shadowPlaneImage.scale            = 0.05;
		shadowPlaneImage.horizontalCenter = "middle";
		shadowPlaneImage.verticalCenter   = "middle";
		shadowPlaneImage.path             = planePath;
		shadowPlaneImage.fill             = am4core.color("#000");
		shadowPlaneImage.strokeOpacity    = 0;

		shadowPlane.adapter.add("scale", (scale, target) => {
		    target.opacity = (0.6 - (Math.abs(0.5 - target.position)));
		    return 0.5 - 0.3 * (1 - (Math.abs(0.5 - target.position)));
		})

		// Plane animation
		var currentLine = 0;
		var direction = 1;
		function flyPlane() {

		    // Get current line to attach plane to
		    plane.mapLine = lineSeries.mapLines.getIndex(currentLine);
		    plane.parent = lineSeries;
		    shadowPlane.mapLine = shadowLineSeries.mapLines.getIndex(currentLine);
		    shadowPlane.parent = shadowLineSeries;
		    shadowPlaneImage.rotation = planeImage.rotation;

		    // Set up animation
		    var from, to;
		    var numLines = lineSeries.mapLines.length;
		    if (direction == 1) {
		        from = 0
		        to = 1;
		        if (planeImage.rotation != 0) {
		            planeImage.animate({ to: 0, property: "rotation" }, 1000).events.on("animationended", flyPlane);
		            return;
		        }
		    }
		    else {
		        from = 1;
		        to = 0;
		        if (planeImage.rotation != 180) {
		            planeImage.animate({ to: 180, property: "rotation" }, 1000).events.on("animationended", flyPlane);
		            return;
		        }
		    }

		    // Start the animation
		    var animation = plane.animate({
		        from: from,
		        to: to,
		        property: "position"
		    }, 5000, am4core.ease.sinInOut);
		    animation.events.on("animationended", flyPlane)

		    shadowPlane.animate({
		        from: from,
		        to: to,
		        property: "position"
		    }, 5000, am4core.ease.sinInOut);

		    // Increment line, or reverse the direction
		    currentLine += direction;
		    if (currentLine < 0) {
		        currentLine = 0;
		        direction = 1;
		    }
		    else if ((currentLine + 1) > numLines) {
		        currentLine = numLines - 1;
		        direction = -1;
		    }

		}

		// Go!
		flyPlane();

		}); // end am4core.ready()
	</script>
@endsection