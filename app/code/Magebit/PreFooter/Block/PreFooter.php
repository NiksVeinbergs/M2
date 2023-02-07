<?php
/**
 * Magebit_PreFooter
 *
 * @category     Magebit
 * @package      Magebit_PreFooter
 * @author       Niks Veinbergs
 * @copyright    Copyright (c) 2023 Magebit, Ltd.(https://www.magebit.com/)
 */

declare(strict_types=1);

namespace Magebit\PreFooter\Block;

use Magento\Cms\Model\Page;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

/**
 * Class PreFooter
 */
class PreFooter extends Template implements BlockInterface
{
    /**
     *Constants used
     */
    const PRE_FOOTER_TEXT = 'pre_footer_text';

    /**
     * @var Page
     */
    protected $_page;

    /**
     * @param Template\Context $context
     * @param Page $page
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Page $page,
        array $data = []
    ) {
        $this->_page = $page;
        parent::__construct($context, $data);
    }

    /**
     * Description.
     *Get pre footer text from page element and return as a string
     *
     * @return string
     */
    public function getPreFooterText(): string
    {
        $page = $this->getPage();
        return $page->getData(self::PRE_FOOTER_TEXT);
    }

    /**
     * Description.
     *Get current opened page in browser and return data of Page
     *
     * @return Page
     */
    public function getPage(): Page
    {
        if (!$this->hasData('page')) {
            $page = $this->_page;
            $this->setData('page', $page);
        }
        return $this->getData('page');
    }
}
