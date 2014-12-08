$(document).ready(function(){
	//menus and buttons that have a dropdown event
	function dropDown(element) {
				this.dropDownButtons = element;
				this.initEvents();
			}
			dropDown.prototype = {
				initEvents : function() {
					var obj = this;
					obj.dropDownButtons.on('click', function(event){
						$(this).toggleClass('active');
						event.stopPropagation();
					});	
				}
			}
			$(function() {
				var dropDownButtons = new dropDown( $('#dd') );
				$(document).click(function() {
					// all dropdowns
					$('.wrapper-dropdown').removeClass('active');
				});

			});
});