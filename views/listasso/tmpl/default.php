<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('script', 'com_listasso/jquery.js', false, true);
JHtml::_('script', 'com_listasso/jquery-ui.min.js', false, true);
JHtml::stylesheet('com_listasso/jquery-ui.min.css', false, true, false);

?>
<div class="">
<h1>Liste des associations du canton</h1>
<div class="find">
	<h4>Rechercher</h4>
	<div class="row-fluid">
		<div class="span6">
		<label for="villes">Une ville</label>
			<select id="villes" name="villes" onchange="request(this);">
				<option value="none">Une ville</option>
				<?php foreach($this->villes AS $row) : ?><option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option><?php endforeach; ?>
			</select>	
		</div>
		<div class="span6">
			<label for="sports">Une activité</label>
			<input type="text" name="sport" id="sport" autocomplete="off">
		</div>
	</div>
</div>
<div class="row-fluid listasso">
<?php
foreach($this->villes AS $row)
{
?>
	<div class="ville span11" data-ville="<?php echo $row->id; ?>">
		<h2><?php echo $row->name; ?>  <?php if($this->user->id) { ?>  <a href="#" class="btn">  <span class="icon-pencil"></span></a> <a href="#form_club" role="button" class="btn" data-toggle="modal"><span class="icon-plus"></span></a><?php } ?></h2>
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
			<ul>
				<li><button class="edit-item no-btn" onclick="load(this);" data-id="<?php echo $club->id; ?>"><span class="icon-pencil"></span></button></li>
				<li><button class="delete-item no-btn"><span class="icon-remove-2"></span></button></li>
				<li><button class="no-btn" ><span class="icon-plus"></span></button></li>
			</ul>
		</div>
		<?php } ?>
	</div>
	<?php
	endif;
	endforeach;
	if(($i % 2) != 0)
		echo '<div class="span6" style="display: none;"></div>';
	?>
<?php
}
?>
</div>
<?php
if($this->user->id) :
?>
<div id="loader">
	<img class="icon-load" src="templates/toscm/img/loader.gif">
	<span class="icon-checkmark"></span>
</div>
<div id="fond_loader" class="modal-backdrop fade in"></div>

<div id="dialog-delete" class="dialog" title="Supprimer un item ?">
	<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>Voulez-vous vraiment supprimer cette association ?</p>
</div>

<div id="dialog-add" class="dialog" title="Ajouter une association">
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
</div>

<div id="errorBox" class="alert alert-error">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<p>Erreur: <span class="error"></span><br></p>
	<p>
		<a href="#" class="btn" data-dismiss="alert">Fermer</a>
		<a href="#" class="btn" onclick="location.reload()">Actualiser</a>
		<a href="/connexion" class="btn btn-primary">Connexion</a>
	</p>
</div>
<script src="templates/toscm/js/oXHR.js"></script>
<script type="text/javascript">
<!--

	var allFields = {
			id: $("#a_id"),
			name: $("#a_name"),
			type: $("#a_type"),
			contact: $("#a_contact"),
			website: $("#a_website")
		},
		tips = $( ".validateTips" );
		  
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
		  

	$( "#dialog-delete" ).dialog({
		autoOpen: false,
		height: 190,
		modal: true,
		buttons: [
				{
					text: 'Oui',
					click: function() {
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
	
	 $( ".delete-item" ).click(function() {
		$( "#dialog-delete" ).dialog( "open" );
	});
	
	
	$( "#dialog-add" ).dialog({
      autoOpen: false,
      height: 400,
      width: 450,
      modal: true,
      buttons: {
        "Enregistrer": function() {
          if ( allFields.name.val() != "" && allFields.type.val() != "" && allFields.contact.val() != "" ) {
            saveItem(allFields, $( this ));
          }
          else {
          	$('validateTips').fadeIn();
          }
        },
        "Annuler": function() {
          $( this ).dialog( "close" );
        }
      },
    });
 
    $( ".edit-item" ).click(function() {
        $( "#dialog-add" ).dialog( "open" );
      });

function load(asso) {
	var id = asso.getAttribute("data-id");
	
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

function saveItem(allFields, modal) {
	asso = {
		id: allFields.id.val(),
		name: allFields.name.val(),
		type: allFields.type.val(),
		contact: allFields.contact.val(),
		website: allFields.website.val()
	}

	//$('#form_asso').modal('hide');
    $('#loader').show();
	$('#fond_loader').show();

	$.ajax({
		type: 'POST',
		url: 'index.php?option=com_listasso&task=updateClub',
		data: {data: asso}, 
	}).done(function( msg ) {
		if(msg == 1){
			$('#loader .icon-load').delay(2000).fadeOut();
			$('#loader .icon-checkmark').delay(2000).fadeIn();
			$('#loader').delay(3500).fadeOut();
			$('#fond_loader').delay(3500).slideUp();
			$('#loader .icon-load').delay(3500).fadeIn();
			$('#loader .icon-checkmark').delay(3500).fadeOut();
			setTimeout(updClub(asso), 3500);
			modal.dialog( "close" );
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

function updClub(asso) {
(function($){
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
})($);
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
<script type="text/javascript" src="templates/toscm/js/typeahead.min.js"></script>
<script>
<!-- 
 
function request(oSelect) {
	var value = oSelect.options[oSelect.selectedIndex].value;
	var clubs = document.querySelectorAll('.club');
	var villes = document.querySelectorAll('.ville');
	
	for(var i = 0, c = clubs.length ; i < c ; i++) {
		if(clubs[i].getAttribute("data-ville") != value) {
			clubs[i].style.display = "none";
			clubs[i].setAttribute("class", "club");
		}
		else if(clubs[i].getAttribute("data-ville") == value) {
			clubs[i].style.display = "block";
			clubs[i].setAttribute("class", "span6 club");
		}
		if(value == 'none') {
			clubs[i].style.display = "block";
			clubs[i].setAttribute("class", "span6 club");
		}
	}

	for(var i = 0, c = villes.length ; i < c ; i++) {
		if(villes[i].getAttribute("data-ville") != value) {
			villes[i].style.display = "none";
			villes[i].setAttribute("class", "ville");
		}
		else if(villes[i].getAttribute("data-ville") == value) {
			villes[i].style.display = "block";
			villes[i].setAttribute("class", "span11 ville");
		}
		if(value == 'none') {
			villes[i].style.display = "block";
			villes[i].setAttribute("class", "span11 ville");
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
				$('.listasso > .span6').show();
			} else {
				$('.listasso > .span6').show().not(':contains(' + input_content  + ')').hide();
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
