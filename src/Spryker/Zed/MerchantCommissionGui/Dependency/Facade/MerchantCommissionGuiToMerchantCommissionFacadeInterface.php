<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantCommissionGui\Dependency\Facade;

use Generated\Shared\Transfer\MerchantCommissionAmountFormatRequestTransfer;
use Generated\Shared\Transfer\MerchantCommissionAmountTransformerRequestTransfer;
use Generated\Shared\Transfer\MerchantCommissionCollectionRequestTransfer;
use Generated\Shared\Transfer\MerchantCommissionCollectionResponseTransfer;
use Generated\Shared\Transfer\MerchantCommissionCollectionTransfer;
use Generated\Shared\Transfer\MerchantCommissionCriteriaTransfer;

interface MerchantCommissionGuiToMerchantCommissionFacadeInterface
{
    public function getMerchantCommissionCollection(
        MerchantCommissionCriteriaTransfer $merchantCommissionCriteriaTransfer
    ): MerchantCommissionCollectionTransfer;

    public function importMerchantCommissionCollection(
        MerchantCommissionCollectionRequestTransfer $merchantCommissionCollectionRequestTransfer
    ): MerchantCommissionCollectionResponseTransfer;

    public function transformMerchantCommissionAmountForPersistence(
        MerchantCommissionAmountTransformerRequestTransfer $merchantCommissionAmountTransformerRequestTransfer
    ): int;

    public function formatMerchantCommissionAmount(
        MerchantCommissionAmountFormatRequestTransfer $merchantCommissionAmountFormatRequestTransfer
    ): string;
}
