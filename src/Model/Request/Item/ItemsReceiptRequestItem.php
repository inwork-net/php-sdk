<?php


namespace InworkNet\SDK\Model\Request\Item;


use InworkNet\SDK\Model\Traits\RecursiveRestoreTrait;
use InworkNet\SDK\Model\Types\TaxType;

class ItemsReceiptRequestItem extends AbstractRequestItem implements \JsonSerializable
{
    use RecursiveRestoreTrait;

    /** Налог без НДС */
    const TAX_NONE = 'none';

    /** Налог НДС по ставке 0% */
    const TAX_VAT0 = 'vat0';

    /** Налог НДС по ставке 10% */
    const TAX_VAT10 = 'vat10';

    /** Налог НДС по ставке 20% */
    const TAX_VAT20 = 'vat20';

    /** Налог НДС по расчетной ставке 10/110 */
    const TAX_VAT110 = 'vat110';

    /** Налог НДС по расчетной ставке 20/120 */
    const TAX_VAT120 = 'vat120';

    /**
     * @return array
     */
    public static function getAvailableTaxes()
    {
        return [
            self::TAX_NONE,
            self::TAX_VAT0,
            self::TAX_VAT10,
            self::TAX_VAT20,
            self::TAX_VAT110,
            self::TAX_VAT120,
        ];
    }

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $price;

    /**
     * @var string
     */
    private $tax;

    /**
     * @var float
     */
    private $sum;

    /**
     * @var float
     */
    private $quantity;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param string $tax
     *
     * @return $this
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * @return float
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param float $sum
     *
     * @return $this
     */
    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param float $quantity
     *
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getRequiredFields()
    {
        return [
            'name' => self::TYPE_STRING,
            'price' => self::TYPE_FLOAT,
            'quantity' => self::TYPE_FLOAT,
            'tax' => new TaxType($this),
        ];
    }

    /**
     * @inheritDoc
     */
    public function getOptionalFields()
    {
        return [
            'sum' => self::TYPE_FLOAT,
        ];
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $itemData = [
            'name' => $this->getName(),
            'price' => $this->getPrice(),
            'quantity' => $this->getQuantity(),
            'tax' => $this->getTax(),
            'sum' => $this->getSum(),
        ];

        $itemData = array_filter($itemData, function ($param) {
            return !empty($param);
        });

        return $itemData;
    }
}
