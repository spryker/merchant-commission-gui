<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantCommissionGui\Dependency\Facade;

use Generated\Shared\Transfer\DataExportConfigurationTransfer;
use Generated\Shared\Transfer\DataExportReportTransfer;

class MerchantCommissionGuiToMerchantCommissionDataExportFacadeBridge implements MerchantCommissionGuiToMerchantCommissionDataExportFacadeInterface
{
    /**
     * @var \Spryker\Zed\MerchantCommissionDataExport\Business\MerchantCommissionDataExportFacadeInterface
     */
    protected $merchantCommissionDataExportFacade;

    /**
     * @param \Spryker\Zed\MerchantCommissionDataExport\Business\MerchantCommissionDataExportFacadeInterface $merchantCommissionDataExportFacade
     */
    public function __construct($merchantCommissionDataExportFacade)
    {
        $this->merchantCommissionDataExportFacade = $merchantCommissionDataExportFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\DataExportConfigurationTransfer $dataExportConfigurationTransfer
     *
     * @return \Generated\Shared\Transfer\DataExportReportTransfer
     */
    public function exportMerchantCommission(
        DataExportConfigurationTransfer $dataExportConfigurationTransfer
    ): DataExportReportTransfer {
        return $this->merchantCommissionDataExportFacade->exportMerchantCommission($dataExportConfigurationTransfer);
    }
}
