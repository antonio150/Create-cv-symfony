<?php

// src/Controller/ProductController.php
namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/new", name="app_product_new")
     */

    public function new(Request $request, SluggerInterface $slugger): Response
    {
        $product = new Product();
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        $filesystem = new Filesystem();



        $brochureFile = $request->files->get('file');
        // $brochureFile = $parametersAsArray["path"];
        // $pathname = $parametersAsArray["photo"];
        // // dd($brochureFile);


        if ($brochureFile) {
            $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();


            try {
                $brochureFile->move(
                    $this->getParameter('brochures_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            // $path = $this->getParameter('brochures_directory');
            $product->setBrochureFilename($newFilename);
        }

        // echo ($brochureFile . '/' . $pathname);
        // $filesystem->copy($brochureFile . '/' . $pathname, $this->getParameter('brochures_directory') . '/' . $pathname);

        return $this->json([
            'message' => 'Liste des Training',
            // 'data' => ,
            'status' => 'success'
        ]);
    }
}