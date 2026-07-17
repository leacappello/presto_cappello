<?php

namespace App\Jobs;

use App\Models\Image;
use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\BatchAnnotateImagesRequest;
use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Feature\Type;
use Google\Cloud\Vision\V1\Image as VisionImage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Image as SpatieImage;

class RemoveFaces implements ShouldQueue
{
    use Queueable;

    private int $articleImageId;

    public function __construct(int $articleImageId)
    {
        $this->articleImageId = $articleImageId;
    }

    public function handle(): void
    {
        $imageModel = Image::find($this->articleImageId);

        if (!$imageModel) {
            return;
        }

        $sourcePath = storage_path(
            'app/public/' . $imageModel->path
        );

        $censorPath = resource_path('img/face.png');

        if (
            !file_exists($sourcePath)
            || !file_exists($censorPath)
        ) {
            return;
        }

        $imageContent = file_get_contents($sourcePath);

        if ($imageContent === false) {
            return;
        }

        putenv(
            'GOOGLE_APPLICATION_CREDENTIALS='
            . base_path('google_credential.json')
        );

        $googleVisionClient = new ImageAnnotatorClient();

        try {
            $googleImage = new VisionImage([
                'content' => $imageContent,
            ]);

            $googleFeature = new Feature();
            $googleFeature->setType(Type::FACE_DETECTION);

            $request = new AnnotateImageRequest();
            $request->setImage($googleImage);
            $request->setFeatures([$googleFeature]);

            $batchRequest = new BatchAnnotateImagesRequest();
            $batchRequest->setRequests([$request]);

            $responseBatch =
                $googleVisionClient->batchAnnotateImages(
                    $batchRequest
                );

            $responses = $responseBatch->getResponses();

            if (count($responses) === 0) {
                return;
            }

            $faces = $responses[0]->getFaceAnnotations();

            if (count($faces) === 0) {
                return;
            }

            $image = SpatieImage::load($sourcePath);

            foreach ($faces as $face) {
                $vertices = $face
                    ->getBoundingPoly()
                    ->getVertices();

                $bounds = [];

                foreach ($vertices as $vertex) {
                    $bounds[] = [
                        $vertex->getX(),
                        $vertex->getY(),
                    ];
                }

                if (count($bounds) < 3) {
                    continue;
                }

                $x = max(0, $bounds[0][0]);
                $y = max(0, $bounds[0][1]);

                $width = max(
                    1,
                    $bounds[2][0] - $bounds[0][0]
                );

                $height = max(
                    1,
                    $bounds[2][1] - $bounds[0][1]
                );

              $image->watermark(
                 $censorPath,
                 AlignPosition::TopLeft,
                 paddingX: $x,
                 paddingY: $y,
                 width: $width,
                 height: $height,
                 fit: Fit::Stretch
                );
            }

            $image->save($sourcePath);
        } finally {
            $googleVisionClient->close();
        }
    }
}