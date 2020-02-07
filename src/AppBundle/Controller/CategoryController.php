<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Category controller.
 *
 * @Route("category")
 */
class CategoryController extends Controller
{
    //Listar Categorías
    /**
     * @Route("/", name="category_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Category')->findAll();

        return $this->render('category/index.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Nueva Categoría
     *
     * @Route("/new", name="category_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        //Instancia de categoría
        $category = new Category();
        $form = $this->createForm('AppBundle\Form\CategoryType', $category);
        $form->handleRequest($request);

        //Valida si existe un post y si pasó las validaciones de la entidad
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                //Pasa datos al objeto
                $category = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $category->setActive(true);
                $em->persist($category);
                //Guarda categoría
                $em->flush();

                //Retorna mensaje de éxito
                $this->addFlash("success", "La Categoría " . $category->getName() . " ha sido creada existosamente");
                return $this->redirectToRoute('category_index');
            } catch(Exception $e){
                dump('Error de guardado');
                die();
            }
        }

        return $this->render('category/new.html.twig', array(
            'category' => $category,
            'form' => $form->createView(),
        ));
    }

    //Activar / Desactivar Categoría
    /**
     * @Route("/active/{id}", name="category_active")
     * @Method("GET")
     */
    public function activeAction(Category $category){
        try {
            $em = $this->getDoctrine()->getManager();
            $category = $em->getRepository('AppBundle:Category')->find($category->getId());
            //$category->
            ($category->getActive() == true) ? $category->setActive(false) : $category->setActive(true);
            $em->flush();
            ($category->getActive() == true) ? $this->addFlash("success", "La Categoría " . $category->getName() . " ha sido activada") : $this->addFlash("success", "La Categoría " . $category->getName() . " ha sido desactivada");
            return $this->redirectToRoute('category_index');
        } catch (Exception $e) {
            dump('Error de guardado');
            die();
        }
        
    }

    /**
     * Editar categorías
     *
     * @Route("/{id}/edit", name="category_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);
        $editForm = $this->createForm('AppBundle\Form\CategoryType', $category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            try {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash("success", "La Categoría " . $category->getName() . " ha sido editada existosamente");
                return $this->redirectToRoute('category_index');
            } catch (Exception $e){
                dump('Error de guardado');
                die();
            }
        }

        return $this->render('category/edit.html.twig', array(
            'category' => $category,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * 
     * Borrar categoría
     * @Route("/{id}/destroy", name="category_destroy")
     * @Method("GET")
     */
    public function destroyAction($id){
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AppBundle:Category')->find($id);
        if($category != null){
            $repository = $this->getDoctrine()->getRepository(Product::class);
            $products = $repository->createQueryBuilder('product')
                ->where('product.categoryId = :id')
                ->setParameter('id', $category->getId())
                ->getQuery()->execute();
            if(count($products) == 0){
                $em->remove($category);
                $em->flush();
                $this->addFlash("success", "La Categoría " . $category->getName() . " ha sido eliminada existosamente");
                return $this->redirectToRoute('category_index');
            } else {
                $this->addFlash("error", "La Categoría " . $category->getName() . " tiene productos asociados, y no es posible borrarla");
                return $this->redirectToRoute('category_index');
            }
        }
    }
}
