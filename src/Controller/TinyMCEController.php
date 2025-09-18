<?php

namespace App\Controller;

use App\Service\AdminService;
use App\Service\FileHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class TinyMCEController extends AbstractController
{

    #[Route('/tinymce-upload', methods: ['POST'], name: 'tinymce_upload')]
    public function tinymce_upload(Request $request, FileHandler $fileHandler, AdminService $adminService): JsonResponse
    {
        if (!$adminService->isAdmin()){
            return new JsonResponse(['error' => 'Unauthorized'], 403);
        }

        $file = $request->files->get('file');

        if (!$file) {
            return new JsonResponse(['error' => 'No file uploaded'], 400);
        }

        // Optionnel : vérifier le type MIME
        if (!\str_starts_with($file->getMimeType(), 'image/')) {
            return new JsonResponse(['error' => 'Invalid file type'], 400);
        }

        try {
            $filename = $fileHandler->upload($file);
            $url = $fileHandler->url($filename);

            return new JsonResponse(['location' => $url]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Upload failed: ' . $e->getMessage()], 500);
        }
    }


}