	function position_button_close()
	{
		setTimeout(function()
		{
			$('.aside-toggle-right').show();
			position = $('.aside').position();
			$('.aside-toggle-right').css({'top':'50%', 'left':(position.left-20)+'px'});
		}, 700);
	}
	$(function()
	{
		$(window).resize(function(event)
		{
			position_button_close();
		});
		$('.aside-toggle-right').on('click', function(event)
		{
			event.preventDefault();
			$('#modalHorizontal').asidebar('toggle');
		});
	});
	(function($)
	{
		$.fn.asidebar = function(settings)
		{
			$('.aside-toggle-right').hide();

			if( typeof String(settings) === 'string' )
			{			
				settings = 
				{
					status:settings
				};
			}
			var defaults =
			{
				status : '',
			};
			var settings = $.extend( {}, defaults, settings );
			var $element = this instanceof jQuery ? this : $(this);


			this.open = function()
			{
				position_button_close();
				// fade in backdrop
				if( $element.data('bg') )
				{
					if ($(".aside-backdrop").length === 0)
					{
						$("body").append("<div class='aside-backdrop'></div>");
					}
					$(".aside-backdrop").addClass("in");
				}
				// slide in asidebar
				$element.addClass("in");
				if( $element.data('bg-close') ) 
				{
					$(".aside-backdrop").on('click', function()
					{
						$element.close();
					});
				}
			}
			this.close = function()
			{
				position_button_close();
				// fade in backdrop
				if ($(".aside-backdrop.in").length > 0)
				{
					$(".aside-backdrop").removeClass("in");
				}
				// slide in asidebar
				$element.removeClass("in");
			}
			this.toggle = function()
			{
				position_button_close();
				if($element.attr("class").split(' ').indexOf('in') > -1)
				{
					$element.asidebar("close");
				}
				else
				{
					$element.asidebar("open");
				}
			}
			
			this.find('.btn_close').on('click', function()
			{
				$element.asidebar('close');
			});

			switch (settings.status)
			{
				case 'open':
						this.open();
					break;
				case 'close':
						this.close();
					break;
				case 'toggle':
						this.toggle();
					break;
			}
			return this;
		};
	}(jQuery));