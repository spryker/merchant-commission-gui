<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantCommissionGui\Communication\Formatter;

use Generated\Shared\Transfer\MerchantCommissionTransfer;
use Generated\Shared\Transfer\MerchantCommissionViewTransfer;

interface MerchantCommissionFormatterInterface
{
    public function formatMerchantCommissionForView(MerchantCommissionTransfer $merchantCommissionTransfer): MerchantCommissionViewTransfer;
}
