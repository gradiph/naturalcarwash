function ajaxLoad(filename, content) {
	content = typeof content !== 'undefined' ? content : 'content';
	$('.loading').show();
	$.ajax({
		type: "GET",
		url: filename,
		contentType: false,
		success: function (data) {
			$("#" + content).html(data);
            $('.loading').hide();
		},
		error: function (xhr, status, error) {
			alert(error);
            $('.loading').hide();
            console.log(xhr.responseText);
		}
	});
}

function auto_number(event, value) {
	// skip for arrow keys
	if(event.which >= 37 && event.which <= 40) return;

	// format number
	return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function indo_currency(value) {
	return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

$("nav a").click(function(e) {
	if(!$(this).hasClass('dropdown-toggle')) {
		$(".loading").show();
	}
});
