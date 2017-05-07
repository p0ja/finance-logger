<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Payment;
use AppBundle\Form\PaymentFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("is_granted('ROLE_MANAGE_PAYMENTS')")
 * @Route("/admin")
 */
class PaymentsAdminController extends Controller
{
    /**
     * @Route("/payments", name="admin_payments_list")
     */
    public function indexAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('GET OUT!');
        }
        $payments = $this->getDoctrine()
            ->getRepository('AppBundle:Payment')
            ->findAll();

        return $this->render('admin/payments/list.html.twig', array(
            'payments' => $payments
        ));
    }

    /**
     * @Route("/payments/new", name="admin_payments_new")
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(PaymentFormType::class);
        // only handles data on POST
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $payments = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($payments);
            $em->flush();
            $this->addFlash(
                'success',
                sprintf('Payment created by you: %s!', $this->getUser()->getEmail())
            );

            return $this->redirectToRoute('admin_payments_list');
        }

        return $this->render('admin/payments/new.html.twig', [
            'paymentsForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/payments/{id}/edit", name="admin_payments_edit")
     */
    public function editAction(Request $request, Payment $payments)
    {
        $form = $this->createForm(PaymentFormType::class, $payments);
        // only handles data on POST
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $payments = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($payments);
            $em->flush();
            $this->addFlash('success', 'Payments updated!');
            return $this->redirectToRoute('admin_payments_list');
        }

        return $this->render('admin/payments/edit.html.twig', [
            'paymentsForm' => $form->createView()
        ]);
    }
}