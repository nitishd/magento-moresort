<?php
namespace Nitish\Moresort\Block\Product\ProductList;

class Toolbar extends \Magento\Catalog\Block\Product\ProductList\Toolbar
{
    /**
     * Get current store name.
     *
     * @return string
     */
    public function getCurrentStoreName()
    {
        return $this->_storeManager->getStore()->getName();
    }

    public function setCollection($collection)
    {
        if($this->getCurrentOrder()=="bestseller")
        {
              $collection->getSelect()->joinLeft( 
                'sales_order_item', 
                'e.entity_id = sales_order_item.product_id', 
                array('qty_ordered'=>'SUM(sales_order_item.qty_ordered)')) 
                ->group('e.entity_id') 
                ->order('qty_ordered '.$this->getCurrentDirectionReverse());
        }

        if($this->getCurrentOrder()=="toprated")
        {
            $collection->joinField(
                'rating_summary',                // alias
                //'review/review_aggregate',      // table
                'review_entity_summary',      // table
                'rating_summary',               // field
                'entity_pk_value=entity_id',    // bind
                array(
                    'entity_type' => 1, 
                    //'store_id' => Mage::app()->getStore()->getId()
                    'store_id' => $this->getCurrentStoreName()
                ),                              // conditions
                'left'                          // join type
            );
            $collection->getSelect()->order('rating_summary desc');
        }

        $this->_collection = $collection;

        $this->_collection->setCurPage($this->getCurrentPage());

        $limit = (int)$this->getLimit();
        if ($limit) {
            $this->_collection->setPageSize($limit);
        }
        if ($this->getCurrentOrder()) {
            $this->_collection->setOrder($this->getCurrentOrder(), $this->getCurrentDirection());
        }
        return $this;
    }

    public function getCurrentDirectionReverse() {
            if ($this->getCurrentDirection() == 'asc') {
                return 'desc';
            } elseif ($this->getCurrentDirection() == 'desc') {
                return 'asc';
            } else {
                return $this->getCurrentDirection();
            }
        }

}
