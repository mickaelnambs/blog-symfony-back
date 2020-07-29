<?php

namespace App\Controller;

use App\Entity\Image;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UploadImageController.
 * 
 * @author Mickael Nambinintsoa <mickael.nambinintsoa07081999@gmail.com>
 */
class UploadImageController
{
    /**
     * @param Request $request
     * 
     * @return image
     */
    public function __invoke(Request $request)
    {
        $uploadedFile = $request->files->get('file');

        if ($uploadedFile) {
            $image = new Image();
            $image->setFile($uploadedFile);

            return $image;
        }
        throw new BadRequestHttpException("File's required");
    }
}
