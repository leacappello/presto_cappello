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

class GoogleVisionLabelImage implements ShouldQueue
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

        $imagePath = storage_path(
            'app/public/' . $imageModel->path
        );

        if (!file_exists($imagePath)) {
            return;
        }

        $imageContent = file_get_contents($imagePath);

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
            $googleFeature->setType(Type::LABEL_DETECTION);

            $request = new AnnotateImageRequest();
            $request->setImage($googleImage);
            $request->setFeatures([$googleFeature]);

            $batchRequest = new BatchAnnotateImagesRequest();
            $batchRequest->setRequests([$request]);

            $responseBatch = $googleVisionClient->batchAnnotateImages(
                $batchRequest
            );

            $responses = $responseBatch->getResponses();

            if (count($responses) === 0) {
                return;
            }

            $labels = $responses[0]->getLabelAnnotations();

            $result = [];

            foreach ($labels as $label) {
                $description = $label->getDescription();

                if ($description !== '') {
                    $result[] = $description;
                }
            }

            $imageModel->labels = array_values(
                array_unique($result)
            );

            $imageModel->save();
        } finally {
            $googleVisionClient->close();
        }
    }
}