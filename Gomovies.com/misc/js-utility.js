// JavaScript Document
function plugin_initialize(){
			/*acting=$("#acting").val();
			music=$("#music").val();
			sdb=$("#sdb").val();
			story=$("#story").val();
			overall=$("#overall").val();*/			
			undo();
			
			$('#acting').on('rating.change', function(event, value, caption) {acting=value; });//console.log(acting);
			 $('#acting').on('rating.clear', function(event) {acting=0; });
 	    	$('#music').on('rating.change', function(event, value, caption) {music=value;   });//console.log(music);
			 $('#music').on('rating.clear', function(event) {music=0; });
			$('#sdb').on('rating.change', function(event, value, caption) {sdb=value;   });//console.log(sdb);
			$('#sdb').on('rating.clear', function(event) {sdb=0; });
			$('#story').on('rating.change', function(event, value, caption) {story=value;   });//console.log(story);
			$('#story').on('rating.clear', function(event) {story=0; });
			$('#overall').on('rating.change', function(event, value, caption) {overall=value;   });//console.log(overall);
			$('#overall').on('rating.clear', function(event) {overall=0; });
	
}

function undo(){
	$('#acting').rating('update', 0);
			$('#music').rating('update', 0);
			$('#sdb').rating('update', 0);
			$('#story').rating('update', 0);
			$('#overall').rating('update', 0);
}