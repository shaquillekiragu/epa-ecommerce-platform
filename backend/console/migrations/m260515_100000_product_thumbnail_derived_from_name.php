<?php

use yii\db\Migration;
use yii\db\Query;

/**
 * Sets every product.thumbnail to a real stock photo URL chosen from curated Unsplash images.
 *
 * The name (and SKU fallback) is used only to pick a *category* (tech, fashion, home, food,
 * etc.); within that category a stable image is selected from a small, safe pool using
 * crc32(name|id) so the same product always gets the same URL. This avoids random tag-based
 * services that return unrelated or odd photos.
 *
 * Images are served from images.unsplash.com; Unsplash license terms apply. Requires network
 * when the storefront loads thumbnails.
 *
 * safeDown does not restore previous thumbnail URLs.
 */
class m260515_100000_product_thumbnail_derived_from_name extends Migration
{
    /**
     * Curated Unsplash photo ids (path segment after "photo-"). Neutral / catalogue-friendly shots.
     *
     * @var array<string, list<string>>
     */
    private const POOLS = [
        'tech' => [
            '1511707171634-5f897ff02aa9',
            '1498049794561-7780e7231661',
            '1531297484001-80022131f5a1',
            '1527443227654-9aa09e512cb5',
            '1517336714731-489689fd1ca8',
        ],
        'fashion' => [
            '1445205170230-053b83016050',
            '1434389677669-e08b4cac3105',
            '1469334031218-e382a71b716b',
            '1441986300917-64674bd600d4',
        ],
        'home' => [
            '1484101403633-562f891dc89a',
            '1555041469-a586c61ea9bc',
            '1586023492125-27b2c045efd7',
            '1502672260266-1c085ef2d78f',
        ],
        'food' => [
            '1542838132-92c53300491e',
            '1504674900247-0877df9cc836',
            '1490818387573-e1c2f3d5df3f',
            '1565299624946-b28f40a0ae38',
        ],
        'beauty' => [
            '1596462502278-27bfdc403348',
            '1522335789203-aabd1fc54bc9',
            '1612817288484-6f91600614a8',
        ],
        'sports' => [
            '1571902943202-507ec2618e8f',
            '1517649763962-0c62306601b7',
            '1461896836934-ffe607ba8211',
        ],
        'kids' => [
            '1558060370-d644479cb0f0',
            '1515488764276-beab7607c1e6',
        ],
        'office' => [
            '1497366216548-37526070297c',
            '1524758631624-e2822e304c36',
        ],
        'garden' => [
            '1416879595882-3373a0480b5b',
            '1464226183144-d4e9a6d5601b',
        ],
        'pet' => [
            '1548199973-03cce0bbc87a',
            '1583337130417-3341a80e821e',
        ],
        'books' => [
            '151282079080242-2d5a9127f5fb',
            '1507842217343-903b59362912',
        ],
        'music' => [
            '1511379938547-c1f69419868d',
            '1493225457124-a3f16173cc8a',
        ],
        'automotive' => [
            '1489824905604-28e9d2a5f5b6',
            '1492144534655-ae79c964c9d7',
        ],
        'general' => [
            '1505740420928-5e560c06d30e',
            '1526170375885-4d8ecf77b99f',
            '1560472354-b33ff0c44a43',
            '1472851294608-062f824d29cc',
            '1523275335684-37898b6baf30',
        ],
    ];

    public function safeUp(): void
    {
        $rows = (new Query())
            ->select(['id', 'name', 'sku_code'])
            ->from('{{%product}}')
            ->orderBy(['id' => SORT_ASC])
            ->all($this->db);

        foreach ($rows as $row) {
            $id = (int) ($row['id'] ?? 0);
            if ($id <= 0) {
                continue;
            }

            $name = trim((string) ($row['name'] ?? ''));
            if ($name === '') {
                $name = trim((string) ($row['sku_code'] ?? ''));
            }
            if ($name === '') {
                $name = 'product';
            }

            $category = $this->inferCategory($name);
            $thumbnail = $this->pickThumbnailUrl($category, $id, $name);

            $this->update('{{%product}}', ['thumbnail' => $thumbnail], ['id' => $id]);
        }
    }

    private function inferCategory(string $name): string
    {
        $n = mb_strtolower($name, 'UTF-8');

        $rules = [
            'tech' => '/laptop|phone|tablet|monitor|keyboard|mouse|usb|cable|charger|ssd|ram|gpu|cpu|headphone|earbud|speaker|camera|drone|smartwatch|gadget|electronics|tech|hdmi|bluetooth|wifi|router|console|gaming\\s*pc/i',
            'fashion' => '/shirt|dress|jacket|coat|jeans|trouser|skirt|suit|sock|shoe|trainer|sandal|boot|bag|wallet|belt|scarf|hat|cap|watch\\s*strap|jewellery|jewelry|apparel|fashion|textile|linen|cotton|wool|knitwear/i',
            'home' => '/sofa|couch|chair|table|desk|lamp|rug|curtain|bed|mattress|pillow|cabinet|shelf|mirror|frame|vase|cookware|kitchenware|home|furniture|decor|dining|living\\s*room/i',
            'food' => '/coffee|tea|chocolate|snack|cereal|pasta|rice|spice|sauce|wine|beer|juice|organic|grocery|food|kitchen|bakery|fruit|vegetable|meat|fish|cheese|butter/i',
            'beauty' => '/cream|serum|lotion|shampoo|conditioner|makeup|lipstick|mascara|perfume|cologne|skincare|beauty|cosmetic|soap|brush|nail/i',
            'sports' => '/yoga|gym|fitness|dumbbell|kettlebell|bike|bicycle|run|football|rugby|tennis|golf|swim|sport|outdoor|hiking|camping|tent|mat/i',
            'kids' => '/toy|lego|doll|puzzle|stroller|baby|infant|toddler|kids?|child|nursery|crib/i',
            'office' => '/notebook|pen|pencil|stapler|binder|folder|desk\\s*organizer|paper|printer|toner|ink|whiteboard|calendar|office/i',
            'garden' => '/garden|plant|pot|seed|lawn|mower|hose|greenhouse|outdoor\\s*living|compost|fertilizer/i',
            'pet' => '/dog|cat|pet|puppy|kitten|aquarium|fish\\s*tank|bird|cage|leash|collar|treat/i',
            'books' => '/book|novel|magazine|journal|e-?reader|kindle/i',
            'music' => '/guitar|piano|keyboard\\s*instrument|violin|drum|microphone|amp|mixer|audio\\s*interface|record|vinyl/i',
            'automotive' => '/car|auto|vehicle|tyre|tire|motor|oil|filter|brake|wiper|dashcam|jump\\s*starter/i',
        ];

        foreach ($rules as $category => $pattern) {
            if (preg_match($pattern, $n) === 1) {
                return $category;
            }
        }

        return 'general';
    }

    private function pickThumbnailUrl(string $category, int $id, string $name): string
    {
        $pool = self::POOLS[$category] ?? self::POOLS['general'];
        if ($pool === []) {
            $pool = self::POOLS['general'];
        }

        $hash = crc32($name . '|' . $id);
        $idx = ($hash & 0x7fffffff) % count($pool);
        $photoId = $pool[$idx];

        return 'https://images.unsplash.com/photo-' . $photoId . '?auto=format&fit=crop&w=512&q=80';
    }

    public function safeDown(): bool
    {
        return true;
    }
}
