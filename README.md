# ContentBundle

User to implement basic site content for site.

Provides these objects:

- Page
- Text block
- Gallery
- Image


# Page
Possible to extends Pages with implementing of `\MKebza\Content\Service\Page\PageTypeInterface`. This allows to add extra fields to the pages.
If `mkebza/sitemap-bundle` is installed will add entries of active pages to sitemap.

Adds twig function `content_page()` which returns block by `key`

# Text block
Used to create text blocks in certain positions in page. Possible to extends by implementing `\MKebza\Content\Service\TextBlock\TextBlockTypeInterface`.

Adds twig function `content_block()` which returns block by `key`

# Gallery

Simple holder for galleries of images


# Image

General object implemeting image storage. Connected with [Liip Imagine bundle](https://github.com/liip/LiipImagineBundle) and 
[VichUplaoder](https://github.com/dustin10/VichUploaderBundle)

## EntityImage

Allows of easy setting of image to entity. Use `\MKebza\Content\ORM\EntityImage` in your entity.

## EntityImageMany

Use `MKebza\Content\ORM\EntityImageMany` in your entity, implement abstract method pointing to your entity and you can add ManyImages to one entity.

Your admin needs to implement `\MKebza\Content\Service\Image\AdminImageInterface` for it to work.