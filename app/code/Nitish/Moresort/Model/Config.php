<?php
namespace Nitish\Moresort\Model;

class Config extends \Magento\Catalog\Model\Config
{
    public function getAttributeUsedForSortByArray()
    {
        foreach ($this->getAttributesUsedForSortBy() as $attribute) {
            /* @var $attribute \Magento\Eav\Model\Entity\Attribute\AbstractAttribute */
            $options[$attribute->getAttributeCode()] = $attribute->getStoreLabel();
        }
		$options['bestseller'] = __('Best Sellers');
		$options['created_at'] = __('New Arrivals');
		$options['toprated'] = __('Top Rated');
        return $options;
    }
 }