/**
 * @Author Juho 'd4rksy' Nikula
 * @Created 04/11/2015
 */

$(document).ready(function() {
	$.ajax({
		type: "GET",
		url: "comment.php",
		dataType: "json",
		success: function(data) {
			/**
			 * Render results inside the #commentContainer div
			 * created on index.php
			 * @param  {json} data
			 */
			html = "";
			// Loop through data object
			$.each(data, function(key, value) {
				html +=  "<div class='panel panel-default'>";
				html += "<div class='panel-body'>";
				html += value.comment;
				html += "</div>";
				html += "<div class='panel-footer comment-footer'>";
				html += "by "+value.username;
				html += "</div>";
				html += "</div>";
			});
			$("#commentContainer").html(html);
		},
		error: function () {
            alert('error');
        }
	});
});