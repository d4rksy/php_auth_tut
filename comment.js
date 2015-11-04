/**
 * @Author Juho 'd4rksy' Nikula
 * @Created 04/11/2015
 */

$(document).ready(function(e) {
	$.ajax({
		type: "GET",
		url: "comment.php",
		dataType: "json",
		success: function(data) {
			$.each(data, function(key, value) {
				html =  "<div class='panel panel-default'>";
				html += "<div class='panel-body'>";
				html += value.comment;
				html += "</div>";
				html += "</div>";
				$(#commentContainer).html(html);
			});
		}
	});
});