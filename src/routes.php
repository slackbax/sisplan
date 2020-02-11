<?php

extract($_GET);
$_admin = false;

if (isset($_SESSION['prm_useradmin']) && $_SESSION['prm_useradmin']):
	$_admin = true;
endif;

if (!isset($section) || $section == 'home'):
	include 'main/main-index.php';
elseif ($section == 'program' and $_login):
	// programacion
	if (!isset($sbs)):
		include 'program/program-index.php';
	elseif ($sbs == 'listpeople'):
		include 'program/list-people.php';
	elseif ($sbs == 'createprogram'):
		include 'program/create-program.php';
	elseif ($sbs == 'manageprogram'):
		include 'program/manage-program.php';
	elseif ($sbs == 'editprogram'):
		include 'program/edit-program.php';
	elseif ($sbs == 'approveprogram'):
		include 'program/approve-program.php';
	// diagnostico
	elseif ($sbs == 'creatediagno'):
		include 'program/create-diagnosis.php';
	// personal
	elseif ($sbs == 'createpersonal'):
		include 'program/create-people.php';
	// other
	else:
		include 'src/error.php';
	endif;
elseif ($section == 'planif' and $_login):
	// planificacion
	if (!isset($sbs)):
		include 'planification/planification-index.php';
	elseif ($sbs == 'listpeopleplanif'):
		include 'planification/list-people.php';
	elseif ($sbs == 'createplanification'):
		include 'planification/create-planification.php';
	// other
	else:
		include 'src/error.php';
	endif;
elseif ($section == 'agenda' and $_login):
	// agenda
	if (!isset($sbs)):
		include 'agenda/agenda-index.php';
	elseif ($sbs == 'createagenda' and $_admin):
		include 'agenda/list-people.php';
	elseif ($sbs == 'setagenda'):
		include 'agenda/create-agenda.php';
	elseif ($sbs == 'createblock'):
		include 'agenda/create-block.php';
	elseif ($sbs == 'manageagendas'):
		include 'agenda/manage-agenda.php';
	elseif ($sbs == 'modifyagenda' and $_admin):
		include 'agenda/modify-agenda.php';
	elseif ($sbs == 'agendasperson'):
		include 'agenda/agenda-person.php';
	elseif ($sbs == 'viewagenda'):
		include 'agenda/view-agenda.php';
	elseif ($sbs == 'viewagendapeople'):
		include 'agenda/view-agenda-people.php';
	elseif ($sbs == 'manageblocks'):
		include 'agenda/manage-blocks.php';
	// other
	else:
		include 'src/error.php';
	endif;
elseif ($section == 'box' and $_login):
	// boxes
	if (!isset($sbs)):
		include 'box/box-index.php';
	elseif ($sbs == 'createoccupation'):
		include 'box/create-occupation.php';
	elseif ($sbs == 'manageoccupation'):
		include 'box/manage-occupation.php';
	elseif ($sbs == 'occupationbox'):
		include 'box/occupation-box.php';
	elseif ($sbs == 'occupationfloor'):
		include 'box/occupation-floor.php';
	// other
	else:
		include 'src/error.php';
	endif;
elseif ($section == 'reports' and $_login):
	// programado por especialidad
	if ($sbs == 'viewprogramesp'):
		include 'reports/view-program-by-special.php';
	// programacion
	elseif ($sbs == 'viewprogram'):
		include 'reports/view-program.php';
	// planificacion
	elseif ($sbs == 'viewplanif'):
		include 'reports/view-planification.php';
	// rendimiento
	elseif ($sbs == 'viewperform'):
		include 'reports/view-perform.php';
	// medicos no programados
	elseif ($sbs == 'viewmedics'):
		include 'reports/view-medics.php';
	// medicos justificados
	elseif ($sbs == 'viewjustify'):
		include 'reports/view-justify.php';
	// reprogramaciones
	elseif ($sbs == 'viewreprogram'):
		include 'reports/view-reprogram.php';
	// other
	else:
		include 'src/error.php';
	endif;
elseif ($section == 'contact' and $_login):
	if ($sbs == 'sentmessages'):
		include 'contactability/manage-sent.php';
	elseif ($sbs == 'receivedmessages'):
		include 'contactability/manage-received.php';
	else:
		include 'src/error.php';
	endif;
elseif ($section == 'adminusers' and $_login):
	// dashboard
	if (!isset($sbs)):
		include 'admin/admin-index.php';
	// ver perfil
	elseif ($sbs == 'editprofile'):
		include 'admin/users/edit-profile.php';
	// carmbiar pass
	elseif ($sbs == 'changepass'):
		include 'admin/users/change-password.php';
	// other
	else:
		include 'src/error.php';
	endif;
// users
elseif ($section == 'users' and $_admin):
	if ($sbs == 'createuser'):
		include 'admin/users/create-user.php';
	elseif ($sbs == 'manageusers'):
		include 'admin/users/manage-users.php';
	elseif ($sbs == 'edituser'):
		include 'admin/users/edit-user.php';
	else:
		include 'src/error.php';
	endif;
// groups
elseif ($section == 'groups' and $_admin):
	if ($sbs == 'creategroup'):
		include 'admin/groups/create-group.php';
	elseif ($sbs == 'managegroups'):
		include 'admin/groups/manage-groups.php';
	elseif ($sbs == 'editgroup'):
		include 'admin/groups/edit-group.php';
	else:
		include 'src/error.php';
	endif;
elseif ($section == 'admin' and $_admin):
	// dashboard
	if (!isset($sbs)):
		include 'admin/admin-index.php';
	// people
	elseif ($sbs == 'createpeople'):
		include 'admin/people/create-people.php';
	elseif ($sbs == 'managepeople'):
		include 'admin/people/manage-people.php';
	elseif ($sbs == 'editpeople'):
		include 'admin/people/edit-people.php';
	// people
	elseif ($sbs == 'createcontract'):
		include 'admin/contracts/create-contract.php';
	// files
	elseif ($sbs == 'createfile'):
		include 'admin/files/create-file.php';
	elseif ($sbs == 'createfilenm'):
		include 'admin/files/create-file-nm.php';
	// other
	else:
		include 'src/error.php';
	endif;
elseif ($section == 'forgotpass'):
	include 'admin/users/retrieve-password.php';
else:
	include 'src/error.php';
endif;