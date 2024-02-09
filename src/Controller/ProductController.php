<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\Token;
use Core\Controller\AbstractController;
use Core\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{
    private Token $token;

    public function __construct()
    {
        $this->token = new Token();
    }

    public function index(): Response
    {
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository(Product::class);
        $products = $repository->findLast();

        return $this->render("product/index", [
            'products' => $products,
            'token' => $this->token->create('remove')
        ]);
    }

    public function add(Request $request): Response
    {
        $product = new Product();
        $product
            ->setName($request->request->get('name'))
            ->setDescription($request->request->get('description'))
            ->setPrice($request->request->get('price', 0))
        ;

        if($request->getMethod() == "POST") {
            if($this->token->isValid('add-product', $request->request->get('token'))) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($product);
                $em->flush();

                $request->getSession()->getFlashBag()->add('success', "Le produit a bien été enregistré");

                // post-redirect-get
                return new RedirectResponse("/products/add");
            }

            $request->getSession()->getFlashBag()->add("danger", "Le token n'est pas valide");
        }

        return $this->render("product/add", [
            'product' => $product,
            'token' => $this->token->create('add-product')
        ]);
    }

    public function edit(int $id, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        /** @var Product $product */
        $product = $repository->find($id);

        if(!$product) {
            throw new NotFoundException();
        }

        if($request->getMethod() == "POST") {
            if($this->token->isValid('edit-product', $request->request->get('token'))) {
                $product
                    ->setName($request->request->get('name'))
                    ->setDescription($request->request->get('description'))
                    ->setPrice($request->request->get('price', 0))
                ;

                $em = $this->getDoctrine()->getEntityManager();
                $em->flush();

                $request->getSession()->getFlashBag()->add('success', "Le produit a bien été modifier");

                // post-redirect-get
                return new RedirectResponse("/products/".$product->getId()."/edit");
            }

            $request->getSession()->getFlashBag()->add("danger", "Le token n'est pas valide");
        }

        return $this->render("product/edit", [
            'product' => $product,
            'token' => $this->token->create('edit-product')
        ]);
    }

    public function remove(int $id, Request $request): Response
    {
        $token = $request->query->get('token');
        if( $this->token->isValid('remove', $token) ) {
            $repository = $this->getDoctrine()->getRepository(Product::class);
            $em = $this->getDoctrine()->getEntityManager();
            $product = $repository->find($id);

            $em->remove($product);
            $em->flush();
        }

        return new RedirectResponse("/products");
    }

}
