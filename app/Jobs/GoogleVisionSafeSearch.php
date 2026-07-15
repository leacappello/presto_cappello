<?php

namespace App\Jobs;

use App\Models\Image;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Feature\Type;
use Google\Cloud\Vision\V1\Image as VisionImage;
use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\BatchAnnotateImagesRequest;
use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class GoogleVisionSafeSearch implements ShouldQueue
{
    use Queueable;

    private $article_image_id;

    public function __construct($article_image_id)
    {
        $this->article_image_id = $article_image_id;
    }

    public function handle(): void
    {
        $imageModel = Image::find($this->article_image_id);

        if (!$imageModel) {
            return;
        }

        $imageContent = file_get_contents(
            storage_path('app/public/' . $imageModel->path)
        );

        putenv(
            'GOOGLE_APPLICATION_CREDENTIALS='
            . base_path('google_credential.json')
        );

        $googleVisionClient = new ImageAnnotatorClient();

        $googleImage = new VisionImage([
            'content' => $imageContent,
        ]);

        $googleFeature = new Feature();
        $googleFeature->setType(Type::SAFE_SEARCH_DETECTION);

        $request = new AnnotateImageRequest();
        $request->setImage($googleImage);
        $request->setFeatures([$googleFeature]);

        $batchRequest = new BatchAnnotateImagesRequest();
        $batchRequest->setRequests([$request]);

        $responseBatch = $googleVisionClient->batchAnnotateImages(
            $batchRequest
        );

        $responses = $responseBatch->getResponses();

        $googleVisionClient->close();

        if (count($responses) === 0) {
            return;
        }

        $safeSearchAnnotation = $responses[0]
            ->getSafeSearchAnnotation();

        if (!$safeSearchAnnotation) {
            return;
        }

        $likelihoodNames = [
            0 => 'text-secondary bi bi-circle-fill',
            1 => 'text-success bi bi-check-circle-fill',
            2 => 'text-success bi bi-check-circle-fill',
            3 => 'text-warning bi bi-exclamation-circle-fill',
            4 => 'text-warning bi bi-exclamation-circle-fill',
            5 => 'text-danger bi bi-dash-circle-fill',
        ];

        $imageModel->adult = $likelihoodNames[
            $safeSearchAnnotation->getAdult()
        ] ?? $likelihoodNames[0];

        $imageModel->spoof = $likelihoodNames[
            $safeSearchAnnotation->getSpoof()
        ] ?? $likelihoodNames[0];

        $imageModel->medical = $likelihoodNames[
            $safeSearchAnnotation->getMedical()
        ] ?? $likelihoodNames[0];

        $imageModel->violence = $likelihoodNames[
            $safeSearchAnnotation->getViolence()
        ] ?? $likelihoodNames[0];

        $imageModel->racy = $likelihoodNames[
            $safeSearchAnnotation->getRacy()
        ] ?? $likelihoodNames[0];

        $imageModel->save();
    }
}