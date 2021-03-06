<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Magento
 * @package     Mage_Backend
 * @subpackage  unit_tests
 * @copyright   Copyright (c) 2012 X.commerce, Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Mage_Backend_Model_ConfigTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Mage_Backend_Model_Config
     */
    protected $_model;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $_eventManagerMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $_structureReaderMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $_transFactoryMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $_objectFactoryMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $_appConfigMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    protected $_applicationMock;

    public function setUp()
    {
        $this->_eventManagerMock = $this->getMock('Mage_Core_Model_Event_Manager', array(), array(), '', false);
        $this->_structureReaderMock = $this->getMock(
            'Mage_Backend_Model_Config_Structure_Reader', array(), array(), '', false
        );
        $structureMock = $this->getMock('Mage_Backend_Model_Config_Structure', array(), array(), '', false);
        $this->_structureReaderMock->expects($this->any())->method('getConfiguration')->will(
            $this->returnValue($structureMock)
        );
        $this->_transFactoryMock = $this->getMock(
            'Mage_Backend_Model_Resource_Transaction_Factory', array(), array(), '', false
        );
        $this->_objectFactoryMock = $this->getMock('Mage_Core_Model_Config', array(), array(), '', false);
        $this->_appConfigMock = $this->getMock('Mage_Core_Model_Config', array(), array(), '', false);
        $this->_applicationMock = $this->getMock('Mage_Core_Model_Application', array(), array(), '', false);

        $this->_model = new Mage_Backend_Model_Config(array(
            'eventManager' => $this->_eventManagerMock,
            'structureReader' => $this->_structureReaderMock,
            'transactionFactory' => $this->_transFactoryMock,
            'objectFactory' => $this->_objectFactoryMock,
            'applicationConfig' => $this->_appConfigMock,
            'application' => $this->_appConfigMock
        ));
    }

    public function testSaveDoesNotDoAnythingIfGroupsAreNotPassed()
    {
        $this->_structureReaderMock->expects($this->never())->method('getConfiguration');
        $this->_model->save();
    }

    public function testSaveEmptiesNonSetArguments()
    {
        $this->_structureReaderMock->expects($this->never())->method('getConfiguration');
        $this->assertNull($this->_model->getSection());
        $this->assertNull($this->_model->getWebsite());
        $this->assertNull($this->_model->getStore());
        $this->_model->save();
        $this->assertSame('', $this->_model->getSection());
        $this->assertSame('', $this->_model->getWebsite());
        $this->assertSame('', $this->_model->getStore());
    }
}
