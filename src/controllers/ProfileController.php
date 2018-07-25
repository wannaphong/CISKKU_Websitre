<?php
namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ProfileController extends Controller {

  public function Profile (RequestInterface $request, ResponseInterface $response, $args) {
    $id = $args['id'];
    $query =  $this->db->table('profile_tbl')->where('google_user_id', '=', $id)->get();
    $profile = json_decode($query, true);
    if ($id === $_SESSION["uid"]) {
      $com =  $this->db->table('comment_tbl')->where('user_id', '=', $id)->get();
      $comment = json_decode($com, true);
      $this->view->render($response, 'pages/MyProfile.twig', [
        'current' => 'profile',
        'signin' => $_SESSION["uid"],
        'id' => $profile[0]['google_user_id'],
        'fullName' => $profile[0]['full_name'],
        'email' => $profile[0]['email'],
        'generation' => $profile[0]['generation'],
        'profilePic' => $profile[0]['profile_pic'],
        'highSchool' => $profile[0]['high_school'],
        'province' => $profile[0]['province'],
        'workPosition' => $profile[0]['work_position'],
        'companyName' => $profile[0]['company_name'],
        'facebook' => $profile[0]['facebook_id'],
        'comment' => $comment[0]['comment_text']
      ]);
    } else {
      echo "Good";
    }
  }

  public function updateProfile (RequestInterface $request, ResponseInterface $response, $args) {
    $fullName = $request->getParams()['fullName'];
    $generation = $request->getParams()['generation'];
    $highSchool = $request->getParams()['highSchool'];
    $province = $request->getParams()['province'];
    $workPosition = $request->getParams()['workPosition'];
    $companyName = $request->getParams()['companyName'];
    $facebook = $request->getParams()['facebook'];
    $query = $this->db->table('profile_tbl')->where('google_user_id', '=', $args)->update([
      'full_name' => $fullName,
      'generation' => $generation,
      'high_school' => $highSchool,
      'province' => $province,
      'work_position' => $workPosition,
      'company_name' => $companyName,
      'facebook_id' => $facebook
    ]);
    return $response->withRedirect($this->router->pathFor('profile', ['id' => $args]));
  }

  public function uploadPicture (RequestInterface $request, ResponseInterface $response) {
    $uploadedFiles = $request->getUploadedFiles();
    $uploadedFile = $uploadedFiles[$_SESSION['uid'] . '__picture'];
    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
      $filename = moveUploadedFile('./uploads', $uploadedFile);
      $oldPic =  $this->db->table('profile_tbl')->where('google_user_id', '=', $_SESSION['uid'])->pluck('profile_pic');
      if ($oldPic[0] && $oldPic[0] != "") {
        unlink('./uploads/' . $oldPic[0]);
      }
      $query = $this->db->table('profile_tbl')->where('google_user_id', '=', $_SESSION['uid'])->update([
        'profile_pic' => $filename
      ]);
    }
    return $response->withRedirect($this->router->pathFor('profile', ['id' => $_SESSION['uid']]));
  }

  public function updateComment (RequestInterface $request, ResponseInterface $response) {
    $comment = $request->getParams()['comments'];
    $query = $this->db->table('comment_tbl')->where('user_id', '=', $_SESSION['uid'])->update([
      'comment_text' => $comment,
      'created_date' => date('Y-m-d')
    ]);
    return $response->withRedirect($this->router->pathFor('profile', ['id' => $_SESSION['uid']]));
  }
}