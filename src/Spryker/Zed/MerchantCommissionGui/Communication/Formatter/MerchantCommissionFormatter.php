<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantCommissionGui\Communication\Formatter;

use ArrayObject;
use Generated\Shared\Transfer\MerchantCommissionAmountFormatRequestTransfer;
use Generated\Shared\Transfer\MerchantCommissionAmountTransfer;
use Generated\Shared\Transfer\MerchantCommissionAmountViewTransfer;
use Generated\Shared\Transfer\MerchantCommissionTransfer;
use Generated\Shared\Transfer\MerchantCommissionViewTransfer;
use Spryker\Zed\MerchantCommissionGui\Dependency\Facade\MerchantCommissionGuiToMerchantCommissionFacadeInterface;

class MerchantCommissionFormatter implements MerchantCommissionFormatterInterface
{
    /**
     * @var \Spryker\Zed\MerchantCommissionGui\Dependency\Facade\MerchantCommissionGuiToMerchantCommissionFacadeInterface
     */
    protected MerchantCommissionGuiToMerchantCommissionFacadeInterface $merchantCommissionFacade;

    public function __construct(MerchantCommissionGuiToMerchantCommissionFacadeInterface $merchantCommissionFacade)
    {
        $this->merchantCommissionFacade = $merchantCommissionFacade;
    }

    public function formatMerchantCommissionForView(MerchantCommissionTransfer $merchantCommissionTransfer): MerchantCommissionViewTransfer
    {
        $merchantCommissionViewTransfer = (new MerchantCommissionViewTransfer())->fromArray($merchantCommissionTransfer->toArray(), true);

        return $this->formatMerchantCommissionAmounts($merchantCommissionTransfer, $merchantCommissionViewTransfer);
    }

    protected function formatMerchantCommissionAmounts(
        MerchantCommissionTransfer $merchantCommissionTransfer,
        MerchantCommissionViewTransfer $merchantCommissionViewTransfer
    ): MerchantCommissionViewTransfer {
        $merchantCommissionAmountFormatRequestTransfer = (new MerchantCommissionAmountFormatRequestTransfer())
            ->setCalculatorTypePlugin($merchantCommissionTransfer->getCalculatorTypePluginOrFail());

        if ($merchantCommissionTransfer->getAmount()) {
            $merchantCommissionAmountFormatRequestTransfer->setAmount($merchantCommissionTransfer->getAmountOrFail());
            $formattedMerchantCommissionAmount = $this->merchantCommissionFacade->formatMerchantCommissionAmount(
                $merchantCommissionAmountFormatRequestTransfer,
            );

            $merchantCommissionViewTransfer->setAmount($formattedMerchantCommissionAmount);
        }

        if ($merchantCommissionTransfer->getMerchantCommissionAmounts()->count() === 0) {
            return $merchantCommissionViewTransfer;
        }

        $merchantCommissionAmountViewTransfers = new ArrayObject();
        foreach ($merchantCommissionTransfer->getMerchantCommissionAmounts() as $merchantCommissionAmountTransfer) {
            $merchantCommissionAmountViewTransfer = $this->formatMerchantCommissionAmountTransfer(
                $merchantCommissionAmountTransfer,
                $merchantCommissionAmountFormatRequestTransfer,
            );

            $merchantCommissionAmountViewTransfers->append($merchantCommissionAmountViewTransfer);
        }

        return $merchantCommissionViewTransfer->setMerchantCommissionAmounts($merchantCommissionAmountViewTransfers);
    }

    protected function formatMerchantCommissionAmountTransfer(
        MerchantCommissionAmountTransfer $merchantCommissionAmountTransfer,
        MerchantCommissionAmountFormatRequestTransfer $merchantCommissionAmountFormatRequestTransfer
    ): MerchantCommissionAmountViewTransfer {
        $merchantCommissionAmountViewTransfer = (new MerchantCommissionAmountViewTransfer())->fromArray(
            $merchantCommissionAmountTransfer->toArray(),
            true,
        );
        $merchantCommissionAmountFormatRequestTransfer->setCurrency($merchantCommissionAmountTransfer->getCurrencyOrFail());

        if ($merchantCommissionAmountTransfer->getGrossAmount()) {
            $merchantCommissionAmountFormatRequestTransfer->setAmount($merchantCommissionAmountTransfer->getGrossAmountOrFail());
            $formattedGrossAmount = $this->merchantCommissionFacade->formatMerchantCommissionAmount(
                $merchantCommissionAmountFormatRequestTransfer,
            );

            $merchantCommissionAmountViewTransfer->setGrossAmount($formattedGrossAmount);
        }

        if ($merchantCommissionAmountTransfer->getNetAmount()) {
            $merchantCommissionAmountFormatRequestTransfer->setAmount($merchantCommissionAmountTransfer->getNetAmountOrFail());
            $formattedGrossAmount = $this->merchantCommissionFacade->formatMerchantCommissionAmount(
                $merchantCommissionAmountFormatRequestTransfer,
            );

            $merchantCommissionAmountViewTransfer->setNetAmount($formattedGrossAmount);
        }

        return $merchantCommissionAmountViewTransfer;
    }
}
