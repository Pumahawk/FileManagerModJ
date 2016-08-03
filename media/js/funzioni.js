
function mod_filemanager_azioni()
{
	$(".mod_filemanager .checkall").click(function(event)
	{
	   var c = event.delegateTarget;
		if(this.checked) 
		{
			$(c).parents(".mod_filemanager").find(".checkbox").prop("checked", true);
		}
		else
		{       
			$(c).parents(".mod_filemanager").find(".checkbox").prop("checked", false);
		}
	});
	$(".mod_filemanager .checkbox").click(function(event)
	{
	   var c = event.delegateTarget;
		if(this.checked) 
		{
			//$(c).parents(".mod_filemanager").find(".checkall").prop("checked", true);
		}
		else
		{       
			$(c).parents(".mod_filemanager").find(".checkall").prop("checked", false);
		}
	});
	$(".mod_filemanager [type=button], .mod_filemanager img.button").click(function(event)
	{
		var bottone = event.delegateTarget;
		var azione = $(bottone).attr("data-azione");
		if(azione == "apricartella")
		{
			var patch = $(bottone).attr("data-patch");
			$.post(window.location, "azione=apricartella&patch="+patch, function(data){
				var mod_filemanager = $(data).find(".mod_filemanager").html();
				$(bottone).parents(".mod_filemanager").html(mod_filemanager);
				mod_filemanager_azioni();
			});
		}
		else if(azione == "eliminacartella")
		{
			if(confirm("Eliminare definitivamente la cartella?"))
			{
				var patch = $(bottone).attr("data-patch");
				var patchcartella = $(bottone).attr("data-patchcartella");
				$.post(window.location, "azione=eliminacartella&patchcartella="+patchcartella+"&patch="+patch, function(data){
					var mod_filemanager = $(data).find(".mod_filemanager").html();
					$(bottone).parents(".mod_filemanager").html(mod_filemanager);
					mod_filemanager_azioni();
				});
			}
		}
		else if(azione == "eliminafile")
		{
			if(confirm("Eliminare definitivamente il file?"))
			{
				var patch = $(bottone).attr("data-patch");
				var patchfile = $(bottone).attr("data-patchfile");
				$.post(window.location, "azione=eliminafile&patchfile="+patchfile+"&patch="+patch, function(data){
					var mod_filemanager = $(data).find(".mod_filemanager").html();
					$(bottone).parents(".mod_filemanager").html(mod_filemanager);
					mod_filemanager_azioni();
				});
			}
		}
		else if(azione == "eliminafiles")
		{
			$('.azionifile .azioneform').attr("value", "eliminafiles");
			$(document).ready(function() {
				$('.azionifile').ajaxForm(function(data) {
					var mod_filemanager = $(data).find(".mod_filemanager").html();
					$(bottone).parents(".mod_filemanager").html(mod_filemanager);
					mod_filemanager_azioni();
				}); 
			});
			if(confirm("Eliminare definitivamente i file?"))
			{
				$(".azionifile").submit();
			}
		}
		else if(azione == "nuovacartella")
		{
				var patch = $(bottone).attr("data-patch");
				var nome = prompt("Nome cartella: ");
				if(nome)
					$.post(window.location, "azione=nuovacartella&nomecartella="+nome+"&patch="+patch, function(data){
						var mod_filemanager = $(data).find(".mod_filemanager").html();
						$(bottone).parents(".mod_filemanager").html(mod_filemanager);
						mod_filemanager_azioni();
					});
		}
		else if(azione == "copiaurl")
		{
			var url = $(bottone).attr("data-patchfile");
			$(".url").show();
		}
		else if(azione == "caricafile")
		{
			$(document).ready(function() { 
			
				$(bottone).parent().find("input, span").hide();
				$(bottone).parent().css("text-align", "center");
				//$(bottone).parent().find(".loading").show();
				$(bottone).parent().find("span.progress, .loading").show();
				
				var option = {
					uploadProgress: function(event, position, total, percent)
					{
						$(bottone).parent().find(".progress").html(percent+"%");
					},
					success: function(data)
					{
						var mod_filemanager = $(data).find(".mod_filemanager").html();
						$(bottone).parents(".mod_filemanager").html(mod_filemanager);
						mod_filemanager_azioni();
						//$(bottone).parent().find(".loading").hidde();
					}
				};
				
				/*$('#uploadfile').ajaxForm(function(data) {
					var mod_filemanager = $(data).find(".mod_filemanager").html();
					$(bottone).parents(".mod_filemanager").html(mod_filemanager);
					mod_filemanager_azioni();
					//$(bottone).parent().find(".loading").hidde();
				});*/
				$('#uploadfile').ajaxForm(option);
			});
			$('#uploadfile').submit();
		}
	});
}
mod_filemanager_azioni();