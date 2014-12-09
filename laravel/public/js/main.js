// JavaScript Document
$(document).ready(function(){
	$(".profile-name > li").removeClass("activate-dropdown");
    $(".delete-button").click(
        function confirmDelete(){
            return confirm("Are you sure you want to delete?")
        }
    );
})