<?php
namespace App\Services;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartServices{

    private $session;
    private $repoProduct;

    public function __construct(SessionInterface $session, ProductRepository $repoProduct)
    {
        $this->session = $session;
        $this->repoProduct = $repoProduct;
    }

    public function addToCart($id)
    {
        $cart = $this->getCart();

        if (isset($cart[$id])) {
            // Produit déjà présent dans le panier
            $cart[$id]++;
        } else {
            // Le produit n'est pas dans le panier
            $cart[$id] = 1;
        }
        $this->updateCart($cart);
    }

    public function deleteFromCart($id)
    {
        $cart = $this->getCart();

        if (isset($cart[$id])) {
            // Produit déjà dans le panier
            if ($cart[$id] > 1) { // Produit existe plus d'une fois
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
            $this->updateCart($cart);
        }
    }

    public function deleteAllToCart($id)
    {
        $cart = $this->getCart();

        if (isset($cart[$id])) {
            // Produit déjà dans le panier
            unset($cart[$id]);
            $this->updateCart($cart);
        }
    }

    public function deleteCart()
    {
        $this->updateCart([]);
    }

    public function updateCart($cart)
    {
        $this->session->set('cart', $cart);
    }

    public function getCart()
    {
        return $this->session->get('cart', []);
    }

    public function getFullCart()
    {
        $cart = $this->getCart();

        $fullCart = [];

        foreach ($cart as $id => $quantity) {
            $product = $this->repoProduct->find($id);
            if ($product) {
                // Produit récupéré avec succès
                $fullCart[] = [
                    "quantity" => $quantity,
                    "product" => $product
                ];
            } else {
                // id incorrect
                $this->deleteFromCart($id);
            }
        }
        return $fullCart;
    }
}