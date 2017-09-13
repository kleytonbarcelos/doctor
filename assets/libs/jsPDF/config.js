// ##################################

// PLUGINS REQUERIDOS

// Fancybox 3.0
// Jquery Print

// ##################################


var doc = new jsPDF();
var pdf = new jsPDF('p', 'pt', 'letter');
function jspdf(element, action)
{
	pdf = new jsPDF('p', 'pt', 'letter');

	$(element).find('img').each(function(index, el)
	{
		maxWidth = 490;
		maxHeight = 700;
		ratio = 0;
		width = $(el).width();
		height = $(el).height();
		if(width > maxWidth)
		{
			ratio = maxWidth / width;
			$(el).css("width", maxWidth);
			$(el).css("height", height * ratio);
			height = height * ratio;
			width = width * ratio;
		}
		if(height > maxHeight)
		{
			ratio = maxHeight / height;
			$(el).css("height", maxHeight);
			$(el).css("width", width * ratio);
			width = width * ratio;
			height = height * ratio;
		}
	});
	// source can be HTML-formatted string, or a reference
	// to an actual DOM element from which the text will be scraped.
	source = $(element)[0];

	// we support special element handlers. Register them with jQuery-style
	// ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
	// There is no support for any other type of selectors
	// (class, of compound) at this time.
	specialElementHandlers =
	{
		// element with id of "bypass" - jQuery style selector
		'#bypassme': function(element, renderer)
		{
			// true = "handled elsewhere, bypass text extraction"
			return true
		}
	}

	margins =
	{
		top: 30,
		bottom: 60,
		left: 60,
		width: 500
	};
	// all coords and widths are in jsPDF instance's declared units
	// 'inches' in this case
	pdf.fromHTML(
		source // HTML string or DOM elem ref.
		, margins.left // x coord
		, margins.top // y coord
		,{
			'width': margins.width // max width of content on PDF
			, 'elementHandlers': specialElementHandlers
		},
		function (dispose)
		{
			// dispose: object with X, Y of the last line add to the PDF
			//          this allow the insertion of new lines after html
			//pdf.save(randomString(30)+'.pdf');
			if(action=='window')
			{
				window.open(pdf.output('datauristring'));
			}
			else if(action=='modal')
			{
				$.fancybox.open(
				{
					src  : pdf.output('bloburl'),
				});
			}
			else if(action=='modaltools')
			{
				$.fancybox.open(
				{
					src  : pdf.output('bloburl'),
				});
				$('.fancybox-buttons').prepend(''+
					'<button class="fancybox-button" onclick="jspdf_print_download();"><img src="'+base_url+'assets/img/iconepdfdownload.png" width="18"></button>'+
					'<button class="fancybox-button" onclick="$.print(\''+element+'\')"><img src="'+base_url+'assets/img/iconeimpressora.png" width="18"></button>'+
				'');
			}
			else
			{
				pdf.save(randomString(30)+'.pdf');
			}
		},
		margins
	)
}
function jspdf_print_download()
{
	pdf.save(randomString(30)+'.pdf');
}
function jspdf_canvas(element)
{
	function getCanvas(element)
	{
		var a4 = [595.28, 841.89];

		$(element).width((a4[0] * 1.33333) - 80).css('max-width', 'none');
		return html2canvas($(element),
		{
			imageTimeout: 2000,
			removeContainer: false
		});
	}
	getCanvas(element).then(function(canvas)
	{
		var imgWidth = 180;
		var pageHeight = 250;
		var imgHeight = canvas.height * imgWidth / canvas.width;
		var heightLeft = imgHeight;
		var doc = new jsPDF('p', 'mm');
		var position = 10;

		var img = canvas.toDataURL('image/png');

		doc.addImage(img, 'PNG', 10, position, imgWidth, imgHeight);
		heightLeft -= pageHeight;

		while (heightLeft >= 0)
		{
			position = heightLeft - imgHeight;
			doc.addPage();
			doc.addImage(img, 'PNG', 0, position, imgWidth, imgHeight);
			heightLeft -= pageHeight;
		}

		doc.save(randomString(30)+'.pdf');
		$(element).width($(element).width());
	});
}
//########################################################
function randomString(len, an)
{
	an = an&&an.toLowerCase();
	var str="", i=0, min=an=="a"?10:0, max=an=="n"?10:62;
	for(;i++<len;)
	{
		var r = Math.random()*(max-min)+min <<0;
		str += String.fromCharCode(r+=r>9?r<36?55:61:48);
	}
	return str.toLowerCase();
}
$(function()
{
	$('[data-fancybox]').fancybox(
	{
		onInit : function( instance )
		{
			instance.$refs.downloadButton = $('<button class="fancybox-button"></button>').appendTo( instance.$refs.buttons );
		},
		beforeMove: function( instance, current )
		{
			instance.$refs.downloadButton.attr('href', current.src);
		}
	});
});