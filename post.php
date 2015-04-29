<?php

include_once 'user.php';
include_once 'utils.php';
include_once 'error.php';
include_once 'mail.php';
include_once 'log.php';
include_once 'register.php';

if (!empty($_POST)) {
	switch (Utils::get('action')) {
		case 'changeLogin' :
			try {
				User::checkPassword(User::getUsername(), Utils::post('password'));
				User::validUsername(Utils::post('username'));
				User::updateUsername(Utils::post('username'));
				Utils::setSession('username', Utils::post('username'));
				Error::set('Username changed successfully.');
			} catch (Exception $e) {
				Error::exception($e);
			} finally {
				Utils::goBack();
			}
			break;


		case 'changePassword' :
			try {
				User::checkPassword(User::getUsername(), Utils::post('password'));
				User::checkNewPassword();
				User::updatePassword(Utils::post('newpassword'));
				Error::set('Password changed successfully.');
			} catch (Exception $e) {
				Error::exception($e);
			} finally {
				Utils::goBack();
			}
			break;

		case 'changeEmail' :
			try {
				User::checkPassword(User::getUsername(), Utils::post('password'));
				User::checkNewEmail();
				User::updateEmail(Utils::post('email'));
				Utils::setSession('email', Utils::post('email'));
				Error::set('Email changed successfully, please click on the reactivation link sent to the new email.');
			} catch (Exception $e) {
				Error::exception($e);
			} finally {
				Utils::goBack();
			}
			break;

		case 'changeAvatar' :
			try {
				User::checkPassword(User::getUsername(), Utils::post('password'));
				User::checkAvatar();
				// XXX handle avatar names
				User::updateAvatar();
				Error::set('Avatar changed sucessfully.');
			} catch (Exception $e) {
				Error::exception($e);
			} finally {
				Utils::goBack();
			}
			break;

		case 'message' : 
			try {
				$mail = new Mail;
				$mail->sendMailFromPost();
				header("Location: index.php?page=contactDone");
			} catch (Exception $e) {
				Error::exception($e);
			}
			break;


		case 'login' :
			$log = new Log;
    		header("Location: index.php");
    		break;


    	case 'register' :
    		$newUser = new Register;
			if (Error::none()) {
				header("Location: index.php?page=registerDone");
			} else {
				Utils::goBack();
			}
			break;


		default : 
			print 'unknown action.';
	}
}

?>