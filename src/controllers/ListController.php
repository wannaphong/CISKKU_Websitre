<?php
namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ListController extends Controller {

  public function teacherList (RequestInterface $request, ResponseInterface $response) {
    $query =  $this->db->table('profile_tbl')
                        ->where('email', 'like', '%@kku.ac.th')
                        ->get();
    $teachers = json_decode($query, true);
    $this->view->render($response, 'pages/TeacherList.twig', [
      'teachersList' => $teachers,
      'signin' => (isset($_SESSION["uid"]) ? $_SESSION["uid"] : false)
    ]);
  }

  public function studentList (RequestInterface $request, ResponseInterface $response) {
    $query =  $this->db->table('profile_tbl')
                        ->distinct()
                        ->where('email', 'not like', '%@kku.ac.th')
                        ->orderBy('generation', 'asc')
                        ->get(['generation']);
    $generation = json_decode($query, true);
    $this->view->render($response, 'pages/YearList.twig', [
      'generationList' => $generation,
      'signin' => (isset($_SESSION["uid"]) ? $_SESSION["uid"] : false)
    ]);
  }

  public function student (RequestInterface $request, ResponseInterface $response, $args) {
    $query =  $this->db->table('profile_tbl')
                        ->where('generation', '=', $args['year'])
                        ->get();
    $student = json_decode($query, true);
    $this->view->render($response, 'pages/Student.twig', [
      'year' => $args['year'],
      'studentList' => $student,
      'signin' => (isset($_SESSION["uid"]) ? $_SESSION["uid"] : false)
    ]);
  }
}