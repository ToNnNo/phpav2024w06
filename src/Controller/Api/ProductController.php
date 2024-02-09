<?php

namespace App\Controller\Api;

use App\Entity\Product;
use Core\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ProductController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct()
    {
        $this->serializer = new Serializer(
            [new DateTimeNormalizer(), new ObjectNormalizer()],
            [new JsonEncode()]
        );
    }

    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $this->serializer->serialize($repository->findAll(), 'json');

        return new JsonResponse($products, json: true);
    }

    public function detail(int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->find($id);

        if(!$product) {
            return new JsonResponse(["message" => sprintf("Product ID #%s not found", $id)], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse( $this->serializer->serialize($product, 'json'), json: true );
    }

    public function create(Request $request): Response
    {
        $data = $request->getPayload();
        $product = (new Product())
            ->setName($data->get('name'))
            ->setDescription($data->get('description'))
            ->setPrice($data->get('price', 0));

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($product);
        $em->flush();

        return JsonResponse::fromJsonString(
            $this->serializer->serialize($product, 'json'),
            Response::HTTP_CREATED
        );
    }

}




















