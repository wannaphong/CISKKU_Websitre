<?php
namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class SigninController extends Controller {

  public function signinPage (RequestInterface $request, ResponseInterface $response) {
    $this->view->render($response, 'pages/Signin.twig', [
      'current' => 'signin'
    ]);
  }

  public function checkSingin (RequestInterface $request, ResponseInterface $response) {
    $google_user_id = $request->getParam('google_user_id');
    $full_name = $request->getParam('full_name');
    $email = $request->getParam('email');
    $exists =  $this->db->table('cisw_profile_tbl')->where('google_user_id', '=', $google_user_id)->exists();
    if(!$exists) {
      $query = $this->db->table('cisw_profile_tbl')->insert([
        'google_user_id' => $google_user_id,
        'full_name' => $full_name,
        'email' => $email
      ]);
      $query = $this->db->table('cisw_comment_tbl')->insert([
        'user_id' => $google_user_id,
      ]);
    }
    $_SESSION["uid"] = $google_user_id;
  }

  public function signout (RequestInterface $request, ResponseInterface $response) {
    unset($_SESSION["uid"]);
  }
}