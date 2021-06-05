<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\AlertError;

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

	public function detailUser($email)
	{
		$data = [
			'title' => 'Forgot Password',
			'user' => $this->userModel->getUser($email)
		];

		return view('pages/detail', $data);
	}

	public function viewForgotPassword()
	{
		$data = [
			'title' => 'Forgot Password',
		];

		return view('pages/forgot_password', $data);
	}

	public function olahForgotPassword()
	{
		echo "olah";
	}
}
