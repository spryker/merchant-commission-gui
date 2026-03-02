<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantCommissionGui\Communication;

use Generated\Shared\Transfer\MerchantCommissionCollectionResponseTransfer;
use Orm\Zed\MerchantCommission\Persistence\SpyMerchantCommissionQuery;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\MerchantCommissionGui\Communication\Form\MerchantCommissionImportForm;
use Spryker\Zed\MerchantCommissionGui\Communication\Formatter\MerchantCommissionFormatter;
use Spryker\Zed\MerchantCommissionGui\Communication\Formatter\MerchantCommissionFormatterInterface;
use Spryker\Zed\MerchantCommissionGui\Communication\Mapper\MerchantCommissionCsvMapper;
use Spryker\Zed\MerchantCommissionGui\Communication\Mapper\MerchantCommissionCsvMapperInterface;
use Spryker\Zed\MerchantCommissionGui\Communication\Reader\MerchantCommissionCsvReader;
use Spryker\Zed\MerchantCommissionGui\Communication\Reader\MerchantCommissionCsvReaderInterface;
use Spryker\Zed\MerchantCommissionGui\Communication\Table\MerchantCommissionImportErrorTable;
use Spryker\Zed\MerchantCommissionGui\Communication\Table\MerchantCommissionListTable;
use Spryker\Zed\MerchantCommissionGui\Communication\Transformer\MerchantCommissionAmountTransformer;
use Spryker\Zed\MerchantCommissionGui\Communication\Transformer\MerchantCommissionAmountTransformerInterface;
use Spryker\Zed\MerchantCommissionGui\Communication\Validator\MerchantCommissionCsvValidator;
use Spryker\Zed\MerchantCommissionGui\Communication\Validator\MerchantCommissionCsvValidatorInterface;
use Spryker\Zed\MerchantCommissionGui\Dependency\Facade\MerchantCommissionGuiToGlossaryFacadeInterface;
use Spryker\Zed\MerchantCommissionGui\Dependency\Facade\MerchantCommissionGuiToMerchantCommissionFacadeInterface;
use Spryker\Zed\MerchantCommissionGui\Dependency\Service\MerchantCommissionGuiToUtilCsvServiceInterface;
use Spryker\Zed\MerchantCommissionGui\Dependency\Service\MerchantCommissionGuiToUtilDateTimeServiceInterface;
use Spryker\Zed\MerchantCommissionGui\MerchantCommissionGuiDependencyProvider;
use Spryker\Zed\MerchantCommissionGuiExtension\Communication\Dependency\Plugin\MerchantCommissionExportPluginInterface;
use Symfony\Component\Form\FormInterface;

/**
 * @method \Spryker\Zed\MerchantCommissionGui\MerchantCommissionGuiConfig getConfig()
 */
class MerchantCommissionGuiCommunicationFactory extends AbstractCommunicationFactory
{
    public function createMerchantCommissionListTable(): MerchantCommissionListTable
    {
        return new MerchantCommissionListTable(
            $this->getMerchantCommissionPropelQuery(),
            $this->getUtilDateTimeService(),
        );
    }

    public function createMerchantCommissionImportErrorTable(
        MerchantCommissionCollectionResponseTransfer $merchantCommissionCollectionResponseTransfer
    ): MerchantCommissionImportErrorTable {
        return new MerchantCommissionImportErrorTable(
            $merchantCommissionCollectionResponseTransfer,
            $this->getGlossaryFacade(),
        );
    }

    /**
     * @param array<string, mixed> $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getMerchantCommissionImportForm(array $options = []): FormInterface
    {
        return $this->getFormFactory()->create(MerchantCommissionImportForm::class, [], $options);
    }

    public function createMerchantCommissionCsvValidator(): MerchantCommissionCsvValidatorInterface
    {
        return new MerchantCommissionCsvValidator(
            $this->getConfig(),
            $this->getUtilCsvService(),
        );
    }

    public function createMerchantCommissionCsvReader(): MerchantCommissionCsvReaderInterface
    {
        return new MerchantCommissionCsvReader(
            $this->createMerchantCommissionCsvMapper(),
            $this->getUtilCsvService(),
        );
    }

    public function createMerchantCommissionCsvMapper(): MerchantCommissionCsvMapperInterface
    {
        return new MerchantCommissionCsvMapper($this->createMerchantCommissionAmountTransformer());
    }

    public function createMerchantCommissionAmountTransformer(): MerchantCommissionAmountTransformerInterface
    {
        return new MerchantCommissionAmountTransformer($this->getMerchantCommissionFacade());
    }

    public function createMerchantCommissionFormatter(): MerchantCommissionFormatterInterface
    {
        return new MerchantCommissionFormatter($this->getMerchantCommissionFacade());
    }

    public function getMerchantCommissionFacade(): MerchantCommissionGuiToMerchantCommissionFacadeInterface
    {
        return $this->getProvidedDependency(MerchantCommissionGuiDependencyProvider::FACADE_MERCHANT_COMMISSION);
    }

    public function getGlossaryFacade(): MerchantCommissionGuiToGlossaryFacadeInterface
    {
        return $this->getProvidedDependency(MerchantCommissionGuiDependencyProvider::FACADE_GLOSSARY);
    }

    public function getUtilDateTimeService(): MerchantCommissionGuiToUtilDateTimeServiceInterface
    {
        return $this->getProvidedDependency(MerchantCommissionGuiDependencyProvider::SERVICE_UTIL_DATE_TIME);
    }

    public function getUtilCsvService(): MerchantCommissionGuiToUtilCsvServiceInterface
    {
        return $this->getProvidedDependency(MerchantCommissionGuiDependencyProvider::SERVICE_UTIL_CSV);
    }

    public function getMerchantCommissionPropelQuery(): SpyMerchantCommissionQuery
    {
        return $this->getProvidedDependency(MerchantCommissionGuiDependencyProvider::PROPEL_QUERY_MERCHANT_COMMISSION);
    }

    public function getMerchantCommissionExportPlugin(): MerchantCommissionExportPluginInterface
    {
        return $this->getProvidedDependency(MerchantCommissionGuiDependencyProvider::PLUGIN_MERCHANT_COMMISSION_EXPORT);
    }
}
