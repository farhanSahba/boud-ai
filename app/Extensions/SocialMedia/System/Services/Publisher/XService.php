<?php

namespace App\Extensions\SocialMedia\System\Services\Publisher;

use App\Extensions\SocialMedia\System\Helpers\X;
use App\Extensions\SocialMedia\System\Services\Publisher\Contracts\BasePublisherService;

class XService extends BasePublisherService
{
    public function handle()
    {
        $images = $this->post->images ?? [];
        $media = $this->post->image;

        $message = $this->post->content;

        $x = new X;
        $x->setToken($this->accessToken);

        $mediaFiles = count($images) > 0 ? $images : ($media ? [$media] : []);

        $response = match (count($mediaFiles) > 0) {
            true    => $x->publishMediaPost($mediaFiles, $message),
            default => $x->publishTweet($message),
        };

        if (! ($response instanceof \Illuminate\Http\Client\Response)) {
            $response = json_decode(json_encode($response), true);
        }

        return $response;
    }
}
