<?php

namespace PCForge\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use InvalidArgumentException;

class UpdateAmazonPrices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const MINUTES_TO_UPDATE = 12 * 60 + 1;
    const ENDPOINT = 'webservices.amazon.com';
    const URI = '/onca/xml';

    private $componentAsins;

    /**
     * Create a new job instance.
     *
     * @param string[] $componentAsins
     */
    public function __construct($componentAsins)
    {
        if (count($componentAsins) > 10) {
            throw new InvalidArgumentException('Maximum of 10 items allowed in one AWS ItemLookup request');
        }

        $this->componentAsins = $componentAsins;
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
            'ItemId'         => join(',', $this->componentAsins),
            'IdType'         => 'ASIN',
            'Timestamp'      => gmdate('Y-m-d\TH:i:s\Z'),
        ];

        $xml = simplexml_load_file($this->getAwsRequestUrl($params));

        foreach ($xml->Items->Item as $item) {
            foreach ($item->Offers->Offer as $offer) {
                $listing = $offer->OfferListing;
                $asin = $item->ASIN;
                $cacheMinutes = self::MINUTES_TO_UPDATE + 1;
                $available = strval($listing->AvailabilityAttributes->AvailabilityType) === 'now'
                    && intval($listing->IsEligibleForPrime) === 1;
                $currentPrice = intval($listing->Price->Amount);

                cache(["a$asin-price" => $currentPrice], $cacheMinutes);
                cache(["a$asin-available" => $available], $cacheMinutes);

                break;
            }
        }
    }

    private function getAwsRequestUrl(array $params): string
    {
        ksort($params);

        $pairs = [];

        foreach ($params as $key => $val) {
            array_push($pairs, rawurlencode($key) . '=' . rawurlencode($val));
        }

        $canonQueryStr = join('&', $pairs);
        $strToSign = "GET\n" . self::ENDPOINT . "\n" . self::URI . "\n$canonQueryStr";
        $signature = base64_encode(hash_hmac('sha256', $strToSign, env('AWS_SECRET_ACCESS_KEY'), true));

        return 'http://' . self::ENDPOINT . self::URI . "?$canonQueryStr&Signature=" . rawurlencode($signature);
    }
}
