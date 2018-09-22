<?php


namespace ProjectBundle\Controller;

use ProjectBundle\Entity\Projects;
use ProjectBundle\Forms\ProjectDeleteForm;
use ProjectBundle\Forms\ProjectForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use TaskBundle\Entity\Task;
use TaskBundle\Form\TaskForm;


class ProjectController extends Controller{

    public function listAction(Request $request){
        $pageRepo = $this->getDoctrine()->getRepository('ProjectBundle:Projects');
        /** @var Projects $pages  */
        $pages = $pageRepo->findAll();

        $taskForm = $this->createForm( new TaskForm());
        $taskForm->handleRequest($request);
        if($taskForm->isSubmitted()){

            $task = $taskForm->getData();
            //var_dump($task);
        }

        return $this->render('ProjectBundle:Page:list.html.twig', [
            'pages' => $pages,
            'task_form' => $taskForm->createView()
        ]);
    }

    public function viewAction($id, Request $request){
        //$taskObject = new Task();
        $pageRepo = $this->getDoctrine()->getRepository('ProjectBundle:Projects');

        $page = $pageRepo->find($id);
        if(!$page){
            throw $this->createNotFoundException('The page does not exist');
        }


        return $this->render('ProjectBundle:Page:list.html.twig', [
            'page' => $page
        ]);
    }

    public function addAction(Request $request){
        $project = new Projects;
        $form = $this->createForm(new ProjectForm, $project);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();
            return $this->redirectToRoute('page_list');
        }
        return $this->render('ProjectBundle:Page:add.html.twig', [
                'form' => $form->createView()
            ]);
    }

    public function editAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ProjectBundle:Projects');
        $project = $repo->find($id);
        if(!$project){
            return $this->redirectToRoute('page_list');
        }

        $form = $this->createForm(new ProjectForm, $project);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            //$em = $this->getDoctrine()->getManager();
            $em->persist($project);
            $em->flush();
            return $this->redirectToRoute('page_list', ['id' => $project->getId()]);
        }
        return $this->render('ProjectBundle:Page:add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function removeAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ProjectBundle:Projects');
        $project = $repo->find($id);
        if(!$project){
            return $this->redirectToRoute('page_list');
        }

        $form = $this->createForm(new ProjectDeleteForm, null, array( 'delete_id' => $project->getId() ) );

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->remove($project);
            $em->flush();
            return $this->redirectToRoute('page_list');
        }
        return $this->render('ProjectBundle:Page:delete.html.twig', [
            'form' => $form->createView()
        ]);
    }

}