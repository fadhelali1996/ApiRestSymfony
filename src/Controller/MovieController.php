<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Entity\Movie;
use App\Form\MovieType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\BaseAbstractFOSRestController;

/** 
 * Movie controller.
 *  @Route("/api",name="api_")
 */
class MovieController extends AbstractFOSRestController {
    /**
     * Lists all Movies.
     * @Rest\Get("/movies")
     * @return Response
     */
    public function getMovie(){
        $repository=$this->getDoctrine()->getRepository(Movie::class);
        $movies=$repository->findall();
        return $this->handleView($this->view($movies));
    }
    /**
     * CreateMovie.
     * @Rest\Post("/movie")
     * @return Response
     */
    public function postMovie(Request $request){
        $movie=new Movie();
        $form=$this->createForm(MovieType::class,$movie);
        $data=json_decode($request->getContent(),true);$form->submit($data);
        if($form->isSubmitted()&&$form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($movie);$em->flush();
            return $this->handleView($this->view(['status'=>'ok','data'=>$movie],Response::HTTP_CREATED));
        }
            return $this->handleView($this->view($form->getErrors()));}}





                