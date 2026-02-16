<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantCommissionGui\Dependency\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface MerchantCommissionGuiToUtilCsvServiceInterface
{
    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return array<array<string>>
     */
    public function readUploadedFile(UploadedFile $file): array;
}
