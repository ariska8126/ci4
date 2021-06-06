<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use App\Models\UserModel;
use CodeIgniter\Exceptions\AlertError;
use Exception as GlobalException;

class ForgotPassword extends BaseController
{
	protected $userModel;

	function __construct()
	{
		$this->userModel = new UserModel();
	}


	public function index()
	{
		echo "forgot password controller";
	}

	public function funcForgotPassword()
	{

		$data = [
			'title' => 'Forgot Password',
		];
		if ($this->request->getMethod() == 'post') {
			$rules = [
				'email' => [
					'label' => 'Email',
					'rules' => 'required|valid_email',
					'errors' => [
						'required' => '{field} field required',
						'valid_email' => 'Valid {field} required'
					]
				],
			];

			if ($this->validate($rules)) {
				$email  = $this->request->getVar('email', FILTER_SANITIZE_EMAIL);
				$userdata = $this->userModel->verifyEmail($email);

				if (!empty($userdata)) {

					if ($this->userModel->updateAt($userdata['email'])) {
						$to = $email;
						$subject = "reset password";
						$token = $userdata['email'];
						$message = 'hi';

						$email = \config\Services::email();
						$email->setTo($to);
						$email->setFrom('ariskadm57@gmail.com', 'Go');
						$email->setSubject($subject);
						$email->setMessage($message);
						if ($email->send()) {
							echo "email send";
						} else {
							$data = $email->printDebugger(['headers']);
							print_r(($data));
						}
					} else {
						return redirect()->to(current_url());
					}
				} else {

					echo "email doesn't exist";
				}
			} else {
				$data['validation'] = $this->validator;
			}
		}

		return view('pages/forgot_password', $data);
	}

	public function viewchangepassword($username)
	{
		// echo $username;

		$data = [
			'title' => 'Change Password',
			'username' => $username
		];

		if (!empty($username)) {
			$userdata = $this->userModel->getUserByUname($username);
			if (!empty($userdata)) {
				if ($this->cekExpired($userdata['updated_at'])) {
					return view('pages/changepassword', $data);
				} else {
					echo "code expired";
				}
			} else {
				echo "user not found";
			}
		} else {

			echo "incorect request";
		}
	}

	public function cekExpired($tanggal)
	{

		$timediff = strtotime(date('Y-m-d h:i:s')) - strtotime($tanggal);
		if ($timediff < 9000) {
			return true;
		} else {
			return false;
		}
	}

	public function changepassword($username)
	{
		$password = $this->request->getVar('password');
		if ($this->userModel->updatePassword($username, $password)) {
			echo "succes";
		} else {
			echo "failed";
		}
	}

	public function viewForgotPassword()
	{
		$data = [
			'title' => 'Forgot Password'
		];

		return view('pages/forgot_password', $data);
	}

	public function olahForgotPassword()
	{
		$email = $this->request->getVar('email');
		echo $email;

		$userdata = $this->userModel->verifyEmail($email);

		if (!empty($userdata)) {
			print_r("email found");

			// var_dump($userdata);

			if ($this->userModel->updateAt($userdata['email'])) {

				$to = $email;
				$subject = "reset password";
				$token = $userdata['username'];
				$message = '<a href="' . base_url('ForgotPassword/viewchangepassword') . '/' . $token . '">Click</a>';


				$email = \config\Services::email();
				$email->setTo($to);
				$email->setFrom('rsrvcvd@gmail.com', 'Forgot Password');
				$email->setSubject($subject);
				$email->setMessage($message);

				echo "update";

				if ($email->send()) {
					echo "email send";
				} else {
					$data = $email->printDebugger(['headers']);
					print_r(($data));
				}
			} else {
				echo "update false";
			}
		} else {
			echo "email doesn't exist";
		}
	}
}
