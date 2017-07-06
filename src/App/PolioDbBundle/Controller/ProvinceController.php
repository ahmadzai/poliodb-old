<?php

namespace App\PolioDbBundle\Controller;

use App\PolioDbBundle\Entity\Province;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Province controller.
 *
 * @Route("province")
 */
class ProvinceController extends Controller
{
    /**
     * Lists all province entities.
     *
     * @Route("/", name="province_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $provinces = $em->getRepository('AppPolioDbBundle:Province')->findAll();

        return $this->render('province/index.html.twig', array(
            'provinces' => $provinces,
        ));
    }

    /**
     * Creates a new province entity.
     *
     * @Route("/new", name="province_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN_DATA_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $province = new Province();
        $form = $this->createForm('App\PolioDbBundle\Form\ProvinceType', $province);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($province);
            $em->flush($province);

            return $this->redirectToRoute('province_show', array('id' => $province->getProvinceCode()));
        }

        return $this->render('province/new.html.twig', array(
            'province' => $province,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a province entity.
     *
     * @Route("/{id}", name="province_show")
     * @Method("GET")
     */
    public function showAction(Province $province)
    {
        $deleteForm = $this->createDeleteForm($province);

        return $this->render('province/show.html.twig', array(
            'province' => $province,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing province entity.
     *
     * @Route("/{id}/edit", name="province_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN_DATA_ADMIN')")
     */
    public function editAction(Request $request, Province $province)
    {
        $deleteForm = $this->createDeleteForm($province);
        $editForm = $this->createForm('App\PolioDbBundle\Form\ProvinceType', $province);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('province_edit', array('id' => $province->getProvinceCode()));
        }

        return $this->render('province/edit.html.twig', array(
            'province' => $province,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a province entity.
     *
     * @Route("/{id}", name="province_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN_DATA_ADMIN')")
     */
    public function deleteAction(Request $request, Province $province)
    {
        $form = $this->createDeleteForm($province);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($province);
            $em->flush($province);
        }

        return $this->redirectToRoute('province_index');
    }

    /**
     * Creates a form to delete a province entity.
     *
     * @param Province $province The province entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Province $province)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('province_delete', array('id' => $province->getProvinceCode())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
