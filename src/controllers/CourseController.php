<?php
namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CourseController extends Controller {

  public function viewCourse (RequestInterface $request, ResponseInterface $response) {
    $dir    = './uploads/course_pdf/';
    $file = scandir($dir);
    if (isset($_SESSION["uid"])) {
      $query =  $this->db->table('profile_tbl')->where('google_user_id', '=', $_SESSION['uid'])->pluck('email');
      if (strpos($query[0], '@kku.ac.th')) {
        $this->view->render($response, 'pages/CourseView.twig', [
          'current' => 'course',
          'signin' => (isset($_SESSION["uid"]) ? $_SESSION["uid"] : false),
          'admin' => true,
          'file' => $file[2]
        ]);
      } else {
        $this->view->render($response, 'pages/CourseView.twig', [
          'current' => 'course',
          'signin' => (isset($_SESSION["uid"]) ? $_SESSION["uid"] : false),
          'file' => $file[2]
        ]);
      }

    } else {
      $this->view->render($response, 'pages/CourseView.twig', [
        'current' => 'course',
        'signin' => false,
        'file' => $file[2]
      ]);
    }
  }

  public function uploadCourse (RequestInterface $request, ResponseInterface $response) {
    try {
      $uploadedFiles = $request->getUploadedFiles();
      $uploadedFile = $uploadedFiles['newPDF'];
      if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
        $files = glob('./uploads/course_pdf/*');
        foreach ($files as $file) {
          if (is_file($file)) {
            unlink($file);
          }
        }
        $filename = moveUploadedFile('./uploads/course_pdf/', $uploadedFile);
      }
      return $response->withRedirect($this->router->pathFor('course.view'));
    } catch (Exception $e) {
      return $response->withRedirect($this->router->pathFor('course.view'));
    }
    
  }
}