<?php

namespace Ebess\AdvancedNovaMediaLibrary\Fields;

/**
 * @mixin Media
 */
trait HandlesConversionsTrait
{
    public function conversionOnIndexView(string $conversionOnIndexView): self
    {
        return $this->withMeta(compact('conversionOnIndexView'));
    }

    public function conversionOnDetailView(string $conversionOnDetailView): self
    {
        return $this->withMeta(compact('conversionOnDetailView'));
    }

    public function conversionOnForm(string $conversionOnForm): self
    {
        return $this->withMeta(compact('conversionOnForm'));
    }

    public function conversionOnPreview(string $conversionOnPreview): self
    {
        return $this->withMeta(compact('conversionOnPreview'));
    }

    public function getConversionUrls(\Spatie\MediaLibrary\MediaCollections\Models\Media $media): array
    {
        $preview_collection = config('nova-media-library.preview-collection-name') ?? "thumb";
        $preview_url = '//' . ($media->hasGeneratedConversion($preview_collection) ? $media->getUrl($preview_collection) : $media->getUrl());
        $original_url = '//' . $media->getUrl();

        return [
            // original needed several purposes like cropping
            '__original__' => $original_url,
            'indexView' => $preview_url,
            'detailView' => $original_url,
            'form' => $original_url,
            'preview' => $preview_url,
        ];
    }

    public function getTemporaryConversionUrls(\Spatie\MediaLibrary\MediaCollections\Models\Media $media): array
    {
        return [
            // original needed several purposes like cropping
            '__original__' => $media->getTemporaryUrl($this->secureUntil),
            'indexView' => $media->getTemporaryUrl($this->secureUntil, $this->meta['conversionOnIndexView'] ?? ''),
            'detailView' => $media->getTemporaryUrl($this->secureUntil, $this->meta['conversionOnDetailView'] ?? ''),
            'form' => $media->getTemporaryUrl($this->secureUntil, $this->meta['conversionOnForm'] ?? ''),
            'preview' => $media->getTemporaryUrl($this->secureUntil, $this->meta['conversionOnPreview'] ?? ''),
        ];
    }
}
