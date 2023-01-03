<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Repository\FlowerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CartController extends AbstractController
{
    /**
     * Display the cart
     *
     * @param Cart $cart
     * @param FlowerRepository $flowerRepository
     * @return Response
     */
    #[Route('/cart', name: 'app_cart')]
    public function index(Cart $cart, FlowerRepository $flowerRepository): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getFull($flowerRepository),
        ]);
    }

    /**
     * Add flower_id in the cart
     *
     * @param Cart $cart
     * @param $id
     * @return Response
     */
    #[Route('/cart/add/{id}', name: 'app_add_to_cart')]
    public function add(Cart $cart, $id): Response
    {
        $cart->add($id);
        //dd($cart->get());

        return $this->redirectToRoute('app_cart');
    }


    #[Route('/cart/decrease/{id}', name: 'app_decrease_to_cart')]
    public function decrease(Cart $cart, $id): Response
    {
        $cart->decrease($id);
        //dd($cart->get());

        return $this->redirectToRoute('app_cart');
    }

    /**
     * Remove the cart
     *
     * @param Cart $cart
     * @return Response
     */
    #[Route('/cart/remove', name: 'app_remove_cart')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();

        return $this->redirectToRoute('app_shop');
    }


    #[Route('/cart/delete/{id}', name: 'app_delete_to_cart')]
    public function delete(Cart $cart, $id): Response
    {
        $cart->delete($id);

        return $this->redirectToRoute('app_cart');
    }
}