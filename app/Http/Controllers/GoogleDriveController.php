<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class GoogleDriveController extends Controller
{
    public function listFiles()
    {
        $this->client = new \Google_Client();
        $this->client->setClientId(config('app.sunt_google_drive_client_id'));
        $this->client->setClientSecret(config('app.sunt_google_drive_client_secret'));
        $this->client->refreshToken(config('app.sunt_google_drive_refresh_token'));

        $this->service = new \Google_Service_Drive($this->client);


        $files = $this->service->files->listFiles(array(
            'pageSize' => 1,
            'q' => sprintf('trashed = false and "%s" in parents', config('app.sunt_google_drive_folder_id'))
        ));

        foreach ($files as $file) {
            $response = $this->service->files->get($file['id'], array(
                'alt' => 'media'));
            $content = $response->getBody()->getContents();

            $response = Response::make($content, 200);
            $response->header("Content-Type", 'image/jpeg');
            return $response;
        }

        return view('drive', ['files' => $files]);
    }
}
