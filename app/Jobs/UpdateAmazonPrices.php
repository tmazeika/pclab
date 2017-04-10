<?php

namespace PCForge\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use InvalidArgumentException;
use PCForge\Models\Component;

class UpdateAmazonPrices implements ShouldQueue
{
    const MAX_ASINS_PER_REQUEST = 10;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
            foreach ($item->Offers->Offer as $offer) {
                $listing = $offer->OfferListing;
                $asin = $item->ASIN;
                $available = strval($listing->AvailabilityAttributes->AvailabilityType) === 'now'
                    && intval($listing->IsEligibleForPrime) === 1;
                $currentPrice = intval($listing->Price->Amount);

                Component::where('asin', $asin)->update([
                    'is_available' => true, // TODO: $available
                    'price'        => $currentPrice,
                ]);

                break;
            }
        }
    }

    private function getAwsRequestUrl(array $params): string
    {
        ksort($params);

        $pairs = [];

        foreach ($params as $key => $val) {
            $pairs[] = rawurlencode($key) . '=' . rawurlencode($val);
        }

        $canonQueryStr = join('&', $pairs);
        $strToSign = "GET\n" . self::ENDPOINT . "\n" . self::URI . "\n$canonQueryStr";
        $signature = base64_encode(hash_hmac('sha256', $strToSign, env('AWS_SECRET_ACCESS_KEY'), true));

        return 'http://' . self::ENDPOINT . self::URI . "?$canonQueryStr&Signature=" . rawurlencode($signature);
    }
}
