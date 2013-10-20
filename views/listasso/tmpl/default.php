<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('script', 'com_listasso/jquery.js', false, true);
JHtml::_('script', 'com_listasso/jquery-ui.min.js', false, true);
JHtml::_('script', 'com_listasso/modernizr.custom.js', false, true);
JHtml::_('script', 'com_listasso/bootstrap-tooltip.min.js', false, true);
JHtml::stylesheet('com_listasso/jquery-ui.min.css', false, true, false);
JHtml::stylesheet('com_listasso/typeahead.js-bootstrap.css', false, true, false);
JHtml::stylesheet('com_listasso/listasso.css', false, true, false);

?>
<div class="">
<h1>Liste des associations du canton</h1>
<div class="find well">
	<h4><span class="icon-search" style="vertical-align: middle"></span>  Rechercher une association</h4>
	<div class="row-fluid">
		<div class="span6">
		<label for="villes">Une ville</label>
			<select id="villes" name="villes" onchange="request(this);">
				<option value="none">-- Toutes les villes --</option>
				<?php foreach($this->villes AS $row) : ?><option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option><?php endforeach; ?>
			</select>	
		</div>
		<div class="span6">
			<label for="sport">Une activité</label>
			<input class="typeahead" type="text" name="sport" id="sport" autocomplete="off">
		</div>
	</div>
</div>
<?php if($this->user->id): ?>
<div class="options well">
	<h4><span class="icon-cogs" style="vertical-align: middle"></span>  Paramètre de la liste</h4>
	<div class="row-fluid">
		<div class="span6">
			<ul class="nav nav-list">
				<li class="nav-header">Les villes</li>
				<li><a class="add-city"><span class="icon-office"></span> Ajouter une ville</a></li>
				<li><a href="#" data-toggle="tooltip" title="Pour modifier une ville, cliquez sur le nom de la ville à modifier"><span class="icon-remove"></span> Modifier / supprimer une ville</a></li>
			</ul>
		</div>
		<div class="span6">
			<ul class="nav nav-list">
				<li class="nav-header">Les associations</li>
				<li><a class="add-asso"><span class=" icon-users"></span> Ajouter une association</a></li>
				<li><a href="#" data-toggle="tooltip" title="Survolez une association afin de faire apparaitre les options"><span class="icon-remove"></span> Modifier / supprimer une association</a></li>
			</ul>
		</div>
	</div>
</div>
<?php endif; ?>
<div class="row-fluid listasso">
<?php
foreach($this->villes AS $row)
{
?>
<div class="city"  data-ville="<?php echo $row->id; ?>">
	<div class="ville span11 edit-city" data-ville="<?php echo $row->id; ?>">
		<div><h2><span class="ed-city"><?php echo $row->name; ?></span><?php if($this->user->id) { ?> <small><span class="icon-pencil"></span> <span class="icon-remove delete-city"></span></small><?php } ?></h2></div>
		<div  style="display: none"><form ><input type="text" id="city-edit<?php echo $row->id; ?>" value="<?php echo $row->name; ?>" autocomplete="off"></form></div>
		<hr>
	</div>
	<div class="span1" style="display: none;"></div>
	
	<?php
	$i = 0;
	foreach($this->assos AS $club) :
	if($row->id == $club->ville) :
		$i++;
	?>
	<div class="span6 club" data-ville="<?php echo $club->ville; ?>" data-id="<?php echo $club->id; ?>">
		<div class="club-content">
			<?php if(empty($club->website)) : ?><h5 class="name-club"><span class="name"><?php echo $club->name; ?></span><br><small><?php echo $club->type; ?></small></h5>
			<?php else : ?> <h5 class="name-club"><a href="<?php echo $club->website; ?>"><span class="icon-link"></span>  <span class="name"><?php echo $club->name; ?></span></a><br><small><?php echo $club->type; ?></small></h5>
			<?php endif; ?>
			<p class="president"><span class="icon-user"></span> Contact: <span class="a_president"><?php echo $club->contact; ?></span><br></p>
		</div>
		<?php if($this->user->id) { ?>
		<div class="caption">
			<div class="row-fluid">
				<div class="tools row-fluid">
					<div class="span12 edit"><span data-icon="?" aria-hidden="true"></span></div>
					<div class="span12 delete"><span data-icon="?" aria-hidden="true"></span></div>
				</div>
			</div>
				<!--<ul>
					<li><button class="edit-item no-btn" onclick="load(this);" data-id="<?php echo $club->id; ?>"><span class="icon-pencil"></span></button></li>
					<li><button class="delete-item no-btn" data-id="<?php echo $club->id; ?>"><span class="icon-remove"></span></button></li>
					<li><button class="add-item no-btn" ><span class="icon-plus"></span></button></li>
				</ul>-->
		</div>
		<?php } ?>
	</div>
	<?php
	endif;
	endforeach;
	if(($i % 2) != 0)
		echo '<div class="span6 club" style="display: none;"></div>';
	?>
	</div>
<?php
}
?>
</div>
<?php
if($this->user->id) :
?>

<div id="dialog-delete" class="dialog" title="Supprimer un item ?">
	<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>Voulez-vous vraiment supprimer cette association ?</p>
</div>

<div id="dialog-add-city" class="dialog" title="Ajouter une ville">
	<div class="validateTips alert alert-error" style="display: none;">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Attention!</strong> Veuillez remplir tous les champs
	</div>
  <form method="post">
		<p>
			<div class="input-prepend">
				<span class="add-on"><span class="icon-tag"></span></span>
				<input class="prependedInput" type="text" name="a_city" id="a_city" placeholder="Nom de la ville">
			</div>
		</p>
	</form>
	<div class="progressbar" style="display: none;">
		<div class="progres"></div>
		<p><!--<span data-icon="" aria-hidden="true"></span>--><span class="msg"></span></p>
	</div>
</div>

<div id="dialog-add" class="dialog" title="Ajouter/modifier une association">
	<div class="validateTips alert alert-error" style="display: none;">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Attention!</strong> Veuillez remplir tous les champs
	</div>
  <form method="post">
		<p>
			<input type="hidden" name="a_id" id="a_id" value="" />
			<div class="input-prepend">
				<span class="add-on"><span class="icon-tag"></span></span>
				<input class="prependedInput" type="text" name="a_name" id="a_name" placeholder="Nom de l'association">
			</div>
			<div class="input-prepend">
				<span class="add-on"><span class="icon-file"></span></span>
				<input class="prependedInput" type="text" name="a_type" id="a_type" placeholder="Type d'activitée(s)">
			</div>
			<div class="input-prepend">
				<span class="add-on"><span class="icon-user"></span></span>
				<input class="prependedInput" type="text" name="a_contact" id="a_contact" placeholder="Président">
			</div>
			<div class="input-prepend">
				<span class="add-on"><span class="icon-earth"></span></span>
				<input class="prependedInput" type="text" name="a_website" id="a_website" placeholder="Site internet">
			</div>
		</p>
	</form>
	<div class="progressbar" style="display: none;">
		<div class="progres"></div>
		<p><!--<span data-icon="" aria-hidden="true"></span>--><span class="msg"></span></p>
	</div>
</div>

<div id="errorBox" class="alert alert-error">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<p>Erreur: <span class="error"></span><br></p>
	<p>
		<a href="#" class="btn" data-dismiss="alert">Fermer</a>
		<a href="/connexion" class="btn btn-primary">Connexion</a>
	</p>
</div>
<div id="successBox" class="alert alert-error">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<p class="msg"></p>
	<p>
		<a href="#" class="btn" data-dismiss="alert">Ok</a>
	</p>
</div>
<script src="templates/toscm/js/oXHR.js"></script>
<script type="text/javascript">
<!--

	var fields = {
			id: $("#a_id"),
			name: $("#a_name"),
			type: $("#a_type"),
			contact: $("#a_contact"),
			website: $("#a_website"), 
			city: $("#a_city"), 
		},
		tips = $( ".validateTips" ), 
		city;
		  
	function checkLength( o, n, min, max ) {
      if ( o.val().length > max || o.val().length < min ) {
        o.addClass( "ui-state-error" );
        updateTips( "Length of " + n + " must be between " +
          min + " and " + max + "." );
        return false;
      } else {
        return true;
      }
    }

    $('.options').tooltip({
      selector: "a[data-toggle=tooltip]"
    })

    $(' [href^=#]').click(function (e) {
      e.preventDefault()
    })

    $( ".add-city" ).click(function() {
        $( "#dialog-add-city" ).dialog( "open" );
    });

    $( ".edit-city .ed-city, .edit-city .icon-pencil" ).click(function() {
		var id = $(this).parents('.edit-city').data('ville');
		$('.edit-city[data-ville="'+id+'"] div').toggle();
		$('.edit-city[data-ville="'+id+'"] input').focus();
	});

	$( ".edit-city input" ).blur(function() {
		var id = $(this).parents('.edit-city').data('ville');
		$('.edit-city[data-ville="'+id+'"] div').toggle();
		editCity(id, $('.edit-city #city-edit'+id).val());
		
	});

	$( ".edit-city form" ).submit(function() {
		var id = $(this).parents('.edit-city').data('ville');
		$('.edit-city[data-ville="'+id+'"] div').toggle();
		if(editCity(id, $('.edit-city .city-edit'+id).val())) {
			$('.edit-city[data-ville="'+id+'"] h2 .ed-city').text($('.edit-city .city-edit'+id).val());
			alert($('.edit-city .city-edit'+id).val());
		}
		else {
			alert('Une erreur est survenue. Vérifiez que vous êtes connecté puis reessayez');
			setTimeout(function() { location.reload();}, 5000);
		}
	});


    $( ".add-asso" ).click(function() {
        $( "#dialog-add" ).dialog( "open" );
    });

    $( ".edit" ).click(function() {
        fields.id = $(this).parents('.club').data('id');
        load(fields.id);
        $( "#dialog-add" ).dialog( "open" );
    });

    $( ".delete" ).click(function() {
		$( "#dialog-delete" ).dialog( "open" );
		fields.id = $(this).parents('.club').data('id');
	});


	$( "#dialog-delete" ).dialog({
		autoOpen: false,
		height: 190,
		modal: true,
		buttons: [
				{
					text: 'Oui',
					click: function() {
						deleteItem();
						$( this ).dialog( "close" );
					}
				},
				{
					text: "Annuler",
					click: function() {
						$( this ).dialog( "close" );
					}
				}
			]
	});
	
	$( "#dialog-add" ).dialog({
      autoOpen: false,
      height: 400,
      width: 450,
      modal: true,
      buttons: {
        "Enregistrer": function() {
          if ( fields.name.val() != "" && fields.type.val() != "" && fields.contact.val() != "" ) {
            saveItem(fields, $( this ));
            setTimeout(function() {
            	fields.name.val("");
            	fields.type.val("");
            	fields.contact.val("");
            	fields.website.val("");
            }, 4000);
          }
          else {
          	$('.validateTips').fadeIn();
          }
        },
        "Annuler": function() {
          $( this ).dialog( "close" );
          fields.name.val("");
          fields.type.val("");
          fields.contact.val("");
          fields.website.val("");
        }
      },
    });

    $( "#dialog-add-city" ).dialog({
      autoOpen: false,
      height: 250,
      width: 450,
      modal: true,
      buttons: {
        "Enregistrer": function() {
           if ( fields.city.val() != "" ) {
            createCity(fields.city.val());
            setTimeout(function() {
            	fields.city.val("");
            }, 4000);
          }
          else {
          	$('.validateTips').fadeIn();
          }
        },
        "Annuler": function() {
          $( this ).dialog( "close" );
        }
      },
    });
 
    

function load(id) {
	document.querySelector('#a_id').value = "";
	document.querySelector('#a_name').value = "";
	document.querySelector('#a_type').value = "";
	document.querySelector('#a_contact').value = "";
	document.querySelector('#a_website').value = "";
	
	document.querySelector('#a_id').value = id;
	document.querySelector('#a_name').value = document.querySelector(".club[data-id='"+id+"'] .name-club .name").innerHTML;
	document.querySelector('#a_type').value = document.querySelector(".club[data-id='"+id+"'] .name-club small").innerHTML;
	document.querySelector('#a_contact').value = document.querySelector(".club[data-id='"+id+"'] .a_president").innerHTML;
	if(document.querySelector(".club[data-id='"+id+"'] .name-club a") != null)
		document.querySelector('#a_website').value = document.querySelector(".club[data-id='"+id+"'] .name-club a").getAttribute('href');
}

function deleteItem() {
	$.ajax({
		type: 'POST',
		url: 'index.php?option=com_listasso&task=deleteClub',
		data: {id: fields.id}, 
	}).done(function( msg ) {
		if(msg == 1){
			$('#successBox').slideDown();
			$('#successBox .msg').html("L'association a bien été supprimée");
			$(".club[data-id='"+fields.id+"']").remove();
		}
		else {
			$('#loader').hide();
			$('#errorBox .error').html(msg);
			$('#errorBox').slideDown();
			//modal.dialog( "close" );
			//$('#fond_loader').hide();
		}
	});

}

function saveItem(allFields, modal) {
	//Attention le tableau asso ne contient pas les valeur mais juste les elements (sauf id)
	asso = { 
		id: allFields.id,
		name: allFields.name.val(),
		type: allFields.type.val(),
		contact: allFields.contact.val(),
		website: allFields.website.val()
	}
	//$('#form_asso').modal('hide');
	$('.progressbar').show();
	$('.msg').text('Récuperation des données');
    $('.progres').width(100);
    setTimeout(function() { $('.progres').width(200); $('.msg').text('Enregistrement'); }, 1000);

	$.ajax({
		type: 'POST',
		url: 'index.php?option=com_listasso&task=updateClub',
		data: {data: asso}
	}).done(function( msg ) {
		if(msg == 1){
			setTimeout(function() { $('.progres').width(300); $('.msg').text("Mise à jour de l'affichage"); }, 1000);

			setTimeout(function() {
				$('.club[data-id='+asso.id+'] .club-content').fadeOut(250);
				
				document.querySelector(".club[data-id='"+asso.id+"'] .name-club .name").innerHTML = asso.name;
				document.querySelector(".club[data-id='"+asso.id+"'] .name-club small").innerHTML = asso.type;
				document.querySelector(".club[data-id='"+asso.id+"'] .a_president").innerHTML = asso.contact;
				if(asso.website == "")
					document.querySelector(".club[data-id='"+asso.id+"'] h5").innerHTML = '<span class="name">'+asso.name+'</span><br><small>'+asso.type+'</small></h5>';
				else
					document.querySelector(".club[data-id='"+asso.id+"'] h5").innerHTML = '<a href="'+asso.website+'"><span class="icon-link"></span>  <span class="name">'+asso.name+'</span></a><br><small>'+asso.type+'</small></h5>';
				$('.club[data-id='+asso.id+'] .club-content').delay(250).fadeIn(250);
			}, 1250);

			setTimeout(function() { $('.progres').width(400); $('.msg').text('Fin');}, 2000);
			setTimeout(function() { 
				modal.dialog( "close" );
				$('.progres').width(0);
				$('.progressbar').hide();
			}, 2500);
		}
		else {
			$('#loader').hide();
			$('#errorBox .error').html(msg);
			$('#errorBox').slideDown();
			//modal.dialog( "close" );
			//$('#fond_loader').hide();
		}
	});
}

function createCity(nameCity) {
	//$('#form_asso').modal('hide');
	$('.progressbar').show();
	$('.msg').text('Vérification');
    $('.progres').width(100);
    setTimeout(function() { $('.progres').width(200); $('.msg').text('Enregistrement'); }, 1000);

	$.ajax({
		type: 'POST',
		url: 'index.php?option=com_listasso&task=createCity',
		data: {name: nameCity}
	}).done(function( msg ) {
		if(msg == 1){
			setTimeout(function() { $('.progres').width(300); $('.msg').text("Actualisation"); }, 1000);
			setTimeout(function() { 
				location.reload();
			}, 1500);
		}
		else {
			$('#loader').hide();
			$('#errorBox .error').html(msg);
			$('#errorBox').slideDown();
			//modal.dialog( "close" );
			//$('#fond_loader').hide();
		}
	});
}

function editCity(idCity, nameCity) {
	$.ajax({
		type: 'POST',
		url: 'index.php?option=com_listasso&task=editCity',
		data: {id: idCity, name: nameCity}
	}).done(function( msg ) {
		if(msg == 1){
			$('.edit-city[data-ville="'+idCity+'"] h2 .ed-city').text($('.edit-city #city-edit'+idCity).val());
			$('.find option[value="'+idCity+'"]').text($('.edit-city #city-edit'+idCity).val());
		}
		else {
			alert('Une erreur est survenue. Vérifiez que vous êtes connecté puis reessayez.');
			location.reload();
		}
	});
}

function updClub(asso) {
	var id = asso.id;
	$('.club[data-id='+id+'] .club-content').fadeOut();
	
	setTimeout(function() {
		document.querySelector(".club[data-id='"+id+"'] .name-club .name").innerHTML = asso.name;
		document.querySelector(".club[data-id='"+id+"'] .name-club small").innerHTML = asso.type;
		document.querySelector(".club[data-id='"+id+"'] .a_president").innerHTML = asso.contact;
		if(asso.website == "")
			document.querySelector(".club[data-id='"+id+"'] h5").innerHTML = '<span class="name">'+asso.name+'</span><br><small>'+asso.type+'</small></h5>';
		else
			document.querySelector(".club[data-id='"+id+"'] h5").innerHTML = '<a href="'+asso.website+'"><span class="icon-link"></span>  <span class="name">'+asso.name+'</span></a><br><small>'+asso.type+'</small></h5>';
	}, 400);
	 
	$('.club[data-id='+id+'] .club-content').delay(500).fadeIn();
}

jQuery('#errorBox').bind('closed', function () {
	$('.dialog').dialog( "close" );
	$('#fond_loader').hide();
})

-->
</script>
<?php
endif;
?>
<script type="text/javascript" src="media/com_listasso/js/typeahead.min.js"></script>
<script>
<!-- 
 
function request(oSelect) {
	var value = oSelect.options[oSelect.selectedIndex].value;
	var villes = document.querySelectorAll('.city');
	
	for(var i = 0, c = villes.length ; i < c ; i++) {
		if(villes[i].getAttribute("data-ville") != value) {
			villes[i].style.display = "none";
		}
		else if(villes[i].getAttribute("data-ville") == value) {
			villes[i].style.display = "block";
		}
		if(value == 'none') {
			villes[i].style.display = "block";
		}
	}
}

	/* auto-complete */
    jQuery('#sport').typeahead({
		name: 'sports',
		prefetch: 'index.php?option=com_listasso&task=typeahead',
		limit: 10
	}).on('typeahead:selected', changeSport);;


	function changeSport($e, datum) {
		var input_content = $.trim($('#sport').val());
		if(input_content.lenght != 0) {
			if (!input_content) {
				$('.listasso .club').show();
			} else {
				$('.listasso .club').show().not(':contains(' + input_content  + ')').hide();
			}
		}
	}

	/* Fonction overide de :contains (pas sensible case) */
	$.expr[':'].contains = $.expr.createPseudo(function(arg) {
		return function( elem ) {
		return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
		};
	});
	
	$('#sport').keyup(changeSport);


//-->
</script>
</div>
