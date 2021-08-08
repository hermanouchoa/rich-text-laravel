<?php

namespace Tonysm\RichTextLaravel\Attachables;

use Tonysm\RichTextLaravel\GlobalId;

/**
 * @mixin AtachableContract
 */
trait Attachable
{
    public function richTextContentType(): string
    {
        if (property_exists($this, 'richTextContentType')) {
            return $this->richTextContentType;
        }

        return 'application/octet-stream';
    }

    public function richTextPreviewable(): bool
    {
        return false;
    }

    public function richTextFilename(): ?string
    {
        return null;
    }

    public function richTextFilesize()
    {
        return null;
    }

    public function richTextMetadata(?string $key)
    {
        return null;
    }

    public function toRichTextAttributes(array $attributes = []): array
    {
        return collect($attributes)
            ->replace([
                'sgid' => $this->richTextSgid(),
                'content_type' => $this->richTextContentType(),
                'previewable' => $this->richTextPreviewable(),
                'filename' => $this->richTextFilename(),
                'filesize' => $this->richTextFilesize(),
                'width' => $this->richTextMetadata('width'),
                'height' => $this->richTextMetadata('height'),
            ])
            ->filter()
            ->unique()
            ->all();
    }

    public function richTextSgid(): string
    {
        return (new GlobalId($this))->toString();
    }
}