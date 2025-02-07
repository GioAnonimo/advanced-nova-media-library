<?php

namespace Ebess\AdvancedNovaMediaLibrary\Http\Controllers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Auth;
use App\Policies\MediaPolicy;
use Carbon\Carbon;

class DownloadMediaController extends Controller
{
    public function show($mediaId)
    {
        $model = config('media-library.media_model') ?: Media;
        $media = $model::where('id', $mediaId)->first();
        $mediaPolicy = config('nova-media-library.media-policy', \App\Policies\MediaPolicy::class);

        if (!isset($media)) return response('Errore nella richiesta', 400);

        if ((new $mediaPolicy)->download(Auth::user(), $media)) {
            return redirect($media->getTemporaryUrl(Carbon::now()->addMinutes(15)));
        } else return response('Non autorizzato', 401);
    }
}