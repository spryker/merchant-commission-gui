<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantCommissionGui\Communication\Transformer;

use Generated\Shared\Transfer\MerchantCommissionAmountTransformerRequestTransfer;
use Spryker\Zed\MerchantCommissionGui\Dependency\Facade\MerchantCommissionGuiToMerchantCommissionFacadeInterface;

class MerchantCommissionAmountTransformer implements MerchantCommissionAmountTransformerInterface
{
    /**
     * @var \Spryker\Zed\MerchantCommissionGui\Dependency\Facade\MerchantCommissionGuiToMerchantCommissionFacadeInterface
     */
    protected MerchantCommissionGuiToMerchantCommissionFacadeInterface $merchantCommissionFacade;

    public function __construct(MerchantCommissionGuiToMerchantCommissionFacadeInterface $merchantCommissionFacade)
    {
        $this->merchantCommissionFacade = $merchantCommissionFacade;
    }

    public function transformMerchantCommissionAmount(string $merchantCommissionCalculatorPluginType, float $amount): int
    {
        $merchantCommissionAmountTransformerRequestTransfer = (new MerchantCommissionAmountTransformerRequestTransfer())
            ->setCalculatorTypePlugin($merchantCommissionCalculatorPluginType)
            ->setAmountForPersistence($amount);

        return $this->merchantCommissionFacade->transformMerchantCommissionAmountForPersistence(
            $merchantCommissionAmountTransformerRequestTransfer,
        );
    }
}
