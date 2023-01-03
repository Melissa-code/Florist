<?php

namespace App\Classes;

use App\Repository\FlowerRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    private RequestStack $requestStack;


    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getFull(FlowerRepository $flowerRepository): ?array
    {
        $completeCart = [];

        if($this->get()) {
            foreach($this->get() as $id => $quantity) {

                $flower_object = $flowerRepository->find($id);
                // if the flower id doesn't exist, delete the flower id from the cart
                if(!$flower_object) {
                    $this->delete($id);
                    continue; // don't return this
                }

                $completeCart[] = [
                    "flower" =>  $flower_object,
                    "quantity" => $quantity
                ];
            }
        }
        return $completeCart;
    }

    /**
     * Add quantity or one flower
     *
     * @param $id
     * @return mixed
     */
    public function add($id)
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if(!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        return $session->set('cart', $cart);
    }

    /**
     * Decrease quantity or remove a flower
     *
     * @param $id
     * @return mixed
     */
    public function decrease($id)
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if($cart[$id] > 1) {
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        }

        return $session->set('cart', $cart);
    }

    /**
     * Get
     *
     * @return mixed
     */
    public function get(): mixed
    {
        $session = $this->requestStack->getSession();

        return $session->get('cart');
    }

    /**
     * Remove
     *
     * @return mixed
     */
    public function remove(): mixed
    {
        $session = $this->requestStack->getSession();

        return $session->remove('cart');
    }

    public function delete($id)
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);
        unset($cart[$id]);

        return $session->set('cart', $cart);
    }
}