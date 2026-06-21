<?php

namespace App\DataFixtures\Asset;

use App\DataFixtures\Domain\DomainProfileProvider;
use App\DataFixtures\SlugifyTrait;
use App\Entity\Asset\Asset;
use App\Entity\Asset\AssetAttachment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AssetAttachmentFixtures extends Fixture implements DependentFixtureInterface
{
    use SlugifyTrait;

    private const MAX_PER_ASSET = 3;
    private const BATCH_SIZE = 500;
    private const UPLOAD_PATH = 'uploads/asset';
    // Stored like real uploads: VichUploader fills `type` with the mime type
    // (see AssetAttachmentController + config/packages/vich_uploader.yaml).
    private const FILE_TYPE = 'image/jpeg';
    private const FONT = '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf';
    private const WIDTH = 800;
    private const HEIGHT = 500;

    /** Background colours (R, G, B) cycled across the generated placeholder images. */
    private const COLORS = [
        [13, 110, 253],
        [25, 135, 84],
        [13, 202, 240],
        [102, 16, 242],
        [253, 126, 20],
        [214, 51, 132],
    ];

    public function __construct(
        private readonly DomainProfileProvider $domains,
        private readonly string $publicDir,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $domain = $this->domains->get();
        $subjects = $domain->attachmentSubjects();
        $badge = \mb_strtoupper(\mb_substr($domain->label(), 0, 4));

        // Generate one real image per subject and reuse it across attachments.
        $images = $this->generateImages($subjects, $badge);

        $assets = $manager->getRepository(Asset::class)->findAll();

        $counter = 0;
        foreach ($assets as $asset) {
            $count = \rand(0, self::MAX_PER_ASSET);
            for ($i = 1; $i <= $count; ++$i) {
                $subject = $subjects[\array_rand($subjects)];
                $image = $images[$subject];
                ++$counter;

                $attachment = new AssetAttachment();
                $attachment->setName(\sprintf('%s - %s', $subject, $asset->getName()));
                $attachment->setType(self::FILE_TYPE);
                $attachment->setSize($image['size']);
                $attachment->setPath(self::UPLOAD_PATH);
                $attachment->setFilename($image['filename']);
                $attachment->setActive(true);
                $attachment->setAsset($asset);
                $manager->persist($attachment);

                if (($counter % self::BATCH_SIZE) === 0) {
                    $manager->flush();
                }
            }
        }

        $manager->flush();
    }

    /**
     * Writes a labelled JPEG image for each subject under public/uploads/asset
     * and returns the filename + byte size keyed by subject.
     *
     * @param string[] $subjects
     *
     * @return array<string, array{filename: string, size: int}>
     */
    private function generateImages(array $subjects, string $badge): array
    {
        $dir = \rtrim($this->publicDir, '/') . '/' . self::UPLOAD_PATH;
        if (!\is_dir($dir) && !@\mkdir($dir, 0775, true) && !\is_dir($dir)) {
            throw new \RuntimeException(\sprintf('Unable to create attachment directory "%s".', $dir));
        }

        $images = [];
        foreach (\array_values($subjects) as $index => $subject) {
            $filename = $this->slugify($subject) . '.jpg';
            $jpeg = $this->buildImage($subject, $badge, self::COLORS[$index % \count(self::COLORS)]);
            \file_put_contents($dir . '/' . $filename, $jpeg);

            $images[$subject] = [
                'filename' => $filename,
                'size' => \strlen($jpeg),
            ];
        }

        return $images;
    }

    /**
     * @param array{0: int, 1: int, 2: int} $rgb
     */
    private function buildImage(string $label, string $badge, array $rgb): string
    {
        $image = \imagecreatetruecolor(self::WIDTH, self::HEIGHT);
        $background = \imagecolorallocate($image, $rgb[0], $rgb[1], $rgb[2]);
        \imagefilledrectangle($image, 0, 0, self::WIDTH, self::HEIGHT, $background);

        $white = \imagecolorallocate($image, 255, 255, 255);
        $badgeColor = \imagecolorallocatealpha($image, 255, 255, 255, 95);
        \imagefilledellipse($image, (int) (self::WIDTH / 2), 150, 200, 200, $badgeColor);

        $this->centerText($image, 44, 165, $badge, $white);

        $lines = $this->wrap($label, 24);
        $startY = 320;
        foreach ($lines as $offset => $line) {
            $this->centerText($image, 30, $startY + ($offset * 48), $line, $white);
        }

        \ob_start();
        \imagejpeg($image, null, 85);
        $jpeg = (string) \ob_get_clean();
        \imagedestroy($image);

        return $jpeg;
    }

    /**
     * @param \GdImage $image
     */
    private function centerText($image, int $size, int $y, string $text, int $color): void
    {
        $box = \imagettfbbox($size, 0, self::FONT, $text);
        $textWidth = $box[2] - $box[0];
        $x = (int) ((self::WIDTH - $textWidth) / 2);

        \imagettftext($image, $size, 0, $x, $y, $color, self::FONT, $text);
    }

    /**
     * @return string[]
     */
    private function wrap(string $text, int $maxChars): array
    {
        $lines = [];
        $current = '';
        foreach (\explode(' ', $text) as $word) {
            $candidate = '' === $current ? $word : $current . ' ' . $word;
            if (\mb_strlen($candidate) > $maxChars && '' !== $current) {
                $lines[] = $current;
                $current = $word;
            } else {
                $current = $candidate;
            }
        }

        if ('' !== $current) {
            $lines[] = $current;
        }

        return $lines;
    }

    public function getDependencies(): array
    {
        return [
            AssetFixtures::class,
        ];
    }
}
