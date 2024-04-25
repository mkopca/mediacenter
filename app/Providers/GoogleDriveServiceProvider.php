<?php

namespace App\Providers;

use Google_Client;
use Google_Service_Drive;
use League\Flysystem\Filesystem;
use App\Http\Livewire\GoogleDriveUI;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;

class GoogleDriveServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Storage::extend('google', function ($app, $config) {
            $client = new Google_Client();
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->refreshToken($config['refreshToken']);
            $service = new Google_Service_Drive($client);

            $options = [];
            if (isset($config['teamDriveId'])) {
                $options['teamDriveId'] = $config['teamDriveId'];
            }

            $options['additionalFetchField'] = 'thumbnailLink,contentHints,webContentLink,webViewLink,iconLink';

            $adapter = new GoogleDriveAdapter($service, $config['folderId'], $options);

            if (isset($config['teamDriveId']) && ! empty($config['teamDriveId'])) {
                // Reset the pathPrefix and root back to your custom parent folder
                $adapter->setPathPrefix($config['folderId']);
                $adapter->root = $config['folderId'];
            }

            // if we want to implement Flysystem caching
            // $cacheStore = new \League\Flysystem\Cached\Storage\Memory();
            // $adapter = new \League\Flysystem\Cached\CachedAdapter($adapter, $cacheStore);
            // return new Filesystem($adapter);

            return new Filesystem($adapter);
        });
    }
}
