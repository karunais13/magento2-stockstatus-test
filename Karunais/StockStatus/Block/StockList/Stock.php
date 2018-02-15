<?php

namespace Karunais\StockStatus\Block\StockList;

use \Magento\Sales\Model\Order;

class Stock extends \Magento\Framework\View\Element\Template
{
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = [],
        \Magento\CatalogInventory\Api\StockStateInterface $stock,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Framework\Api\SearchCriteriaInterface $criteria,
        \Magento\Sales\Model\Order $order
    ) {
        $this->stock  = $stock;
        $this->order  = $order;
        $this->productRepository = $productRepository;
        $this->searchCriteria = $criteria;

        parent::__construct($context, $data);
    }

    public function getProductData($page=1)
    {
        $this->searchCriteria->setFilterGroups([]);
        $products = $this->productRepository->getList($this->searchCriteria);
        $productItems = $products->getItems();

        return $productItems;
    }

    public function getStockAvailableQty($prdId)
    {
        return $this->stock->getStockQty($prdId);
    }

    public function getProductOrderStatus()
    {
        $itemProcess  = [];
        foreach($this->order->getCollection() as $key => $orderModel){
            $order   = clone $orderModel;
            $orderStatus   = $order->getData('status');
            $items   = $this->order->load($orderModel->getData('entity_id'))->getAllItems();
            foreach( $items as $key => $item ){
              $product    = $item->getData();
              $productId  = $product['product_id'];
              if( !array_key_exists($productId, $itemProcess) )
                  $itemProcess[$productId]    = [
                      Order::STATE_COMPLETE    => 0,
                      'pending'                => 0,
                      Order::STATE_PROCESSING  => 0
                  ];

              $itemProcess[$productId][$orderStatus]  += $product['qty_ordered'];
            }
        }
        return $itemProcess;
    }


}
