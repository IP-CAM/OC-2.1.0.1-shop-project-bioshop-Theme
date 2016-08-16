/* 
 * Filter for page category, what call after change checbox 
 * Written by Lugano
 * 
 */

$('document').ready(function() {
    
       

	$('.head-filter').each(function() {
            
                $(this).on("click", function(){
                    
                var id = this.id.substr(13);
                 
		$("#content-for-filter-" + id).slideToggle();
		$("#filter-group-" + id + " p").toggleClass('arrow-bottom');
            });
	});
        
       $('.content-filter').on('change', function() {
	       filter = [];

	       $('input[name^=\'filter\']:checked').each(function(element) {
		     filter.push(this.value);
	       });

	       location = action + '&filter=' + filter.join(',');
       });


});

