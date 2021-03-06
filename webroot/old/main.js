//not using this for anything, keeping for handy-ness
function getParameterByName( name )
{
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( window.location.href );
  if( results == null )
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}

$( document ).on( "pageinit", "#main", function() {

	$("#autocomplete").click(function() {
	//as a reminder, variables without 'var' declaration are global
		console.log(event.target.id);
		delete treasure_id;
		treasure_id=event.target.id;
		$("#treasure").trigger("create");
		$("#treasure").trigger("refresh");
	});
	
	$( "#autocomplete" ).on( "filterablebeforefilter", function ( e, data ) {
	//console.log(data);
		var $ul = $( this ),
			$input = $( data.input ),
			value = $input.val(),
			html = "",
			theurl,
			numresults=$("#num-results").val();
		$ul.html( "" );
		//uses the toggle to send proper URL for query 'd:1' means only items on display
		if ($("#flip-select").val()=="On"){
			theurl="http://oc.bbhclan.org/treasures/index/d:1.json"
		}
		else { theurl="http://oc.bbhclan.org/treasures/index.json" }
		if ( value && value.length > 2 ) {
			$ul.html( "<li><div class='ui-loader'><span class='ui-icon ui-icon-loading'></span></div></li>" );
			$ul.listview( "refresh" );
			$.ajax({
			//notice the awesomeness of the n paramter working for us - so this returns 5 results - API supports up to 100
				url: theurl,
				
				//a handy thing to remember exists, but not necessary here
				crossDomain: true,
				data: {
				//more API magic - you can use any valid query term here
				//i need to build more query parameters
					synopsis: $input.val(),
					//creditline: "dyck",
					n: numresults
				},
				success: function(data){
					//to do other successful things...
				}
			})
			/* Process the response
			rugged, but shows exactly how retrieved data is dealt with
			will try to move to separate function so can be refreshed with other events
			still need to replace # and spaces _ in images
			*/
			.then( function ( response ) {
				$.each( response.treasures, function ( i, val ) {
					html += '<li><a href="#treasure" id="'+val.Treasure.id+'"><img src="http://collections.centerofthewest.org/zoomify/1/' + val.Treasure.img + '/TileGroup0/0-0-0.jpg">' +
					'<span style="font-size:10pt;">'+val.Treasure.synopsis+'</span>' + "</a></li>";
				});
				$ul.html( html );
				$ul.listview( "refresh" );
				$ul.trigger( "updatelayout");
			});
		}
	});
	
	/*$("#flip-checkbox").on("change", function(){
        if (this.checked) {
            var inp = $( "#autocomplete" ).filterable( "option", "input" );
            $(inp).val("boston").trigger("change");
        }
    }); */
	
	//see, you were missing ON change!
	$("#flip-select").on("change", function() {
		var refill = $("#filterBasic-input").attr("data-lastval");
		var inp = $( "#autocomplete" ).filterable( "option", "input" );
        //it doesn't like changing directly to itself, so empty and then change
		$(inp).val("").trigger("change");
		$(inp).val(refill).trigger("change");	
	});
	
	$("#num-results").change(function() {
		//console.log($( this ).val());
		//you might be able to lverage basic autocomplet eonce you add an n attribute
		//in fact you'll need to because its too jerky, or add a delay
		var refill = $("#filterBasic-input").attr("data-lastval");
		var inp = $( "#autocomplete" ).filterable( "option", "input" );
        //it doesn't like changing directly to itself, so empty and then change
		$(inp).val("").trigger("change");
		$(inp).val(refill).trigger("change");	
		
	});

});