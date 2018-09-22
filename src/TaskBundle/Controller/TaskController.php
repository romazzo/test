<?php
/**
 * Created by PhpStorm.
 * User: Одмен
 * Date: 22.09.18
 * Time: 13:10
 */

namespace TaskBundle\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TaskBundle\Form\TaskDeleteForm;
use TaskBundle\Form\TaskForm;

class TaskController extends Controller{

    public function editAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('TaskBundle:Task');
        $task = $repo->find($id);
        if(!$task){
            return $this->redirectToRoute('page_list');
        }

        $form = $this->createForm(new TaskForm, $task);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($task);
            $em->flush();
            return $this->redirectToRoute('page_list', ['id' => $task->getId()]);
        }
        return $this->render('TaskBundle:Page:edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function removeAction($id, Request $request){
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('TaskBundle:Task');
        $task = $repo->find($id);
        if(!$task){
            return $this->redirectToRoute('page_list');
        }

        $form = $this->createForm(new TaskDeleteForm, null, array( 'delete_id' => $task->getId() ) );

        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->remove($task);
            $em->flush();
            return $this->redirectToRoute('page_list');
        }
        return $this->render('TaskBundle:Page:delete.html.twig', [
            'form' => $form->createView()
        ]);
    }

} 