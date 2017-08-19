<?php

namespace PCLab\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use InvalidArgumentException;
use PCLab\Models\Component;

class UpdateAmazonComponents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const MAX_ASINS_PER_REQUEST = 10;

    const ENDPOINT = 'webservices.amazon.com';

    const URI = '/onca/xml';

    private $asins;

    /**
     * Create a new job instance.
     *
     * @param string[] $asins
     */
    public function __construct($asins)
    {
        if (count($asins) > self::MAX_ASINS_PER_REQUEST) {
            throw new InvalidArgumentException(
                'Maximum of ' . self::MAX_ASINS_PER_REQUEST . ' items allowed in one AWS ItemLookup request'
            );
        }

        $this->asins = $asins;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $params = [
            'Service'        => 'AWSECommerceService',
            'AWSAccessKeyId' => env('AWS_ACCESS_KEY_ID'),
            'AssociateTag'   => env('AMAZON_ASSOCIATE_TAG'),
            'Operation'      => 'ItemLookup',
            'ResponseGroup'  => 'OfferListings',
            'ItemId'         => join(',', $this->asins),
            'IdType'         => 'ASIN',
            'Timestamp'      => gmdate('Y-m-d\TH:i:s\Z'),
        ];

        $xml = simplexml_load_file($this->getAwsRequestUrl($params));

        foreach ($xml->Items->Item as $item) {
            $this->updateComponent($item);
        }
    }

    private function getAwsRequestUrl(array $params): string
    {
        ksort($params);

        foreach ($params as $key => $val) {
            $pairs[] = rawurlencode($key) . '=' . rawurlencode($val);
        }

        $canonQueryStr = join('&', $pairs ?? []);
        $strToSign = "GET\n" . self::ENDPOINT . "\n" . self::URI . "\n$canonQueryStr";
        $signature = base64_encode(hash_hmac('sha256', $strToSign, env('AWS_SECRET_ACCESS_KEY'), true));

        return 'http://' . self::ENDPOINT . self::URI . "?$canonQueryStr&Signature=" . rawurlencode($signature);
    }

    /**
     * Updates the persisted component associated with the given item.
     *
     * @param $item
     */
    function updateComponent($item): void
    {
        $price = $this->getItemPrice($item);

        Component::where('asin', $item->ASIN)->update([
            'is_available' => $price > 0,
            'price'        => $price,
        ]);
    }

    /**
     * Gets the price of an item. A price of 0 indicates that the item is not available for purchase.
     *
     * @param $item
     *
     * @return int
     */
    private function getItemPrice($item): int
    {
        $listing = collect($item->Offers->Offer)
            ->map(function ($offer) {
                return $offer->OfferListing;
            })
            ->filter(function ($listing) {
                return strval($listing->AvailabilityAttributes->AvailabilityType) === 'now'
                    && intval($listing->AvailabilityAttributes->MaximumHours) === 0
                    && intval($listing->IsEligibleForPrime) === 1;
            })
            ->first();

        $price = $listing ? intval($listing->Price->Amount) : 0;

        return $price === 0 ? 1 : $price;
    }
}
