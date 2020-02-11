<?php

session_start();
include("../class/classMyDBC.php");
include("../class/classBloqueHora.php");
include("../class/classUser.php");
include("../src/fn.php");
//require_once('../src/class.phpmailer.php');

if (extract($_POST)):
	$db = new myDBC();
	$bh = new BloqueHora();

	$u = new User();
	$user = $u->get($_SESSION['prm_userid']);

	try {
		$db->autoCommit(FALSE);
		$idate = setDateBD($idateas);
		$uniq_id = substr(base64_encode(mt_rand()), 0, 16);

		$ins = $bh->set($iperid, $_SESSION['prm_userid'], $ievent, $isubesp, $ibox, null, null, $idate, $h_ini, $h_fin, $iobscupos,null, false, $uniq_id, $db);

		if (!$ins['estado']):
			throw new Exception('Error al guardar los datos de la ocupación. ' . $ins['msg']);
		endif;

		foreach ($itipocupos as $kc => $kv):
			$ins_cupos = $bh->setCupos($ins['msg'], $kv, $icupos[$kc], $db);

			if (!$ins_cupos['estado']):
				throw new Exception('Error al guardar los datos de los cupos de ocupación. ' . $ins_cupos['msg']);
			endif;
		endforeach;

		$db->Commit();
		$db->autoCommit(TRUE);
		/*
		$mail = new PHPMailer();

		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPDebug = 1;                     // enables SMTP debug information (for testing)
		// 1 = errors and messages
		// 2 = messages only
		$mail->SMTPAuth = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
		$mail->Host = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port = 465;                   // set the SMTP port for the GMAIL server
		$mail->Username = "ti.hggb@gmail.com";  // GMAIL username
		$mail->Password = "svr1503_root";            // GMAIL password

		$mail->SetFrom('soportedesarrollo@ssconcepcion.cl', 'Plataforma CDEX');

		$mail->Subject = utf8_decode("Comentario en la solicitud n° ".$id." en la plataforma CDEX");
		$mail->AltBody = "Para visualizar el mensaje, por favor utilice un visor de correos compatible con HTML!"; // optional, comment out and test
		$mail->MsgHTML(utf8_decode("Estimado(a): <br> <br>El usuario ". $user->us_nombres." ". $user->us_ap." ". $user->us_am." ha comentado en la solicitud n° ". $id." : ".$detalle.", "
			. "para responder o revisar debe iniciar sesión en CDEX. <br /><br />"
			. " <u>Solicitud n° ". $id." </u><br/>"
			. "<li>Servicio: ". $sol->sol_unidad_solicitante.";</li> "
			. " <li>Médico: ".$sol->sol_responsable.";</li>"
			. " <li>Folio/ Ficha del paciente: ". $sol->sol_folio_atencion.";</li> "
			. " <li>RUT del paciente: ". $sol->sol_pac_rut.";</li> "
			. " <li>Nombres del paciente: ".$sol->sol_pac_nombres." ".$sol->sol_pac_ap." ".$sol->sol_pac_am.";</li>"
			. " <li>Sistema previsional: ".$sol->sol_pac_prevision.";</li>"
			. " <li>Contacto Paciente: ".$sol->sol_pac_telefono.";</li>"
			. " <li>Origen Derivación: ".$sol->sol_origen.";</li>"
			. " <li>Código/Servicio solicitado : ".$sol->sol_prestacion_aran."".$sol->sol_servicio.";</li>"
			. " <li>Categoría: ".$sol->sol_catdesc."; </li><br/>"
			. " <br/>Ademas puede acceder a ella desde http://www.hospitalregional.cl/cdex/"
			. " Por favor recuerde que para visualizar el documento debe haber iniciado sesión previamente."
			. "<br><br>Saludos cordiales<br>Soporte Plataforma CDEX"));

		$mail->AddAddress("soportedesarrollo@ssconcepcion.cl", "Soporte Desarrollo");
		$mail->AddAddress("practica1-hggb@ssconcepcion.cl", utf8_decode("Médico HGGB"));
		$mail->AddAddress("agarrido@ssconcepcion.cl", utf8_decode("Médico HGGB"));
		$mail->AddAddress("agarrido@ssconcepcion.cl", utf8_decode("Médico HGGB"));

		if(!empty($sol->sol_mail_responsable)):
			$mail->AddAddress($sol->sol_mail_responsable, utf8_decode($sol->sol_responsable));
		endif;

		if (!$mail->Send()):
			throw new Exception('Error al enviar correo de notificación de comentario. ' . $mail->ErrorInfo);
		endif;*/

		$response = array('type' => true, 'msg' => true);
		echo json_encode($response);
	} catch (Exception $e) {
		$db->Rollback();
		$db->autoCommit(TRUE);
		$response = array('type' => false, 'msg' => $e->getMessage());
		echo json_encode($response);
	}
endif;
