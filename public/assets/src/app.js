/*jshint esversion: 6 */

$(document).ready(function(){

    $.delete = function(url, data, callback, type){
 
        if ( $.isFunction(data) ){
            type = type || callback,
                callback = data,
                data = {};
        }
        
        return $.ajax({
            url: url,
            type: 'DELETE',
            success: callback,
            data: data,
            contentType: type
        });
    };

	$(document).on("submit", "form", function(e){
		e.preventDefault();

		let form = this;
		let url  = $(form).attr("action");

		switch (url){
			case "":
				url = window.location.href;
				break;
			default:
				url = url;
				break;
        }
        
		let data = new FormData(form);

		$.ajax({
            type: $(this).attr("method"),
            url: url,
            data: data,
            cache: !1,
            contentType: !1,
            processData: !1,
            timeout: 45000,
            beforeSend: function () {

            },
            success: function (data) {
                $("#receiver").html(data);
            },
            error: function (data, timeout, a) {
            }
        });
	});

    $(document).on("click", ".get", function(e){
        e.preventDefault();

        $.get($(this).attr("href"), function(data){
            $("#receiver").html(data);
        });
    });

    $(document).on("click", ".delete", function(e){
        e.preventDefault();

        $.delete($(this).attr("href"), function(data){
            $("#receiver").html(data);
        });
    });

});