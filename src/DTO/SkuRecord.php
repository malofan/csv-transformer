<?php

declare(strict_types=1);

namespace Spot\DTO;

/**
 * @property-read string $distributorId
 * @property-read string $distributorProductCode
 * @property-read string $productName
 * @property-read string|null $barcode
 * @property-read string|null $manufacturerProductCode
 * @property-read string|null $units
 */
class SkuRecord
{
    public $distributorId;
    public $distributorProductCode;
    public $productName;
    public $barcode;
    public $manufacturerProductCode;
    public $units;

    public function __construct(
        string $distributorId,
        string $distributorProductCode,
        string $productName,
        ?string $barcode,
        ?string $manufacturerProductCode,
        ?string $units
    ) {
        $this->distributorId = $distributorId;
        $this->distributorProductCode = $distributorProductCode;
        $this->productName = $productName;
        $this->barcode = $barcode;
        $this->manufacturerProductCode = $manufacturerProductCode;
        $this->units = $units;
    }
}
