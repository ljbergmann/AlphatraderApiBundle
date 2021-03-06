<?php

namespace Tests\Methods;

use Alphatrader\ApiBundle\Api\Methods\CentralBankReservesController;

/**
 * Class CentralBankReservesControllerTest
 * @package Alphatrader\ApiBundle\Api\Methods
 * @author Tr0nYx <tronyx@bric.finance>
 * @author ljbergmann <lb@sky-lab.de>
 */
class CentralBankReservesControllerTest extends BaseTestCase
{
    public function test_getReserveById()
    {
        $expected = json_encode([]);
        $request = $this->createMock('Alphatrader\ApiBundle\Api\Methods\CentralBankReservesController');
        $request->method('getReserveById')->will($this->returnValue($expected));

        $bankaccount = new CentralBankReservesController($this->config);
        $bankaccount->setClient($this->getClient($expected));
        try {
            $val = $bankaccount->getReserveById(1);
        } catch (\RuntimeException $val) {
            $this->assertInstanceOf('Alphatrader\ApiBundle\Api\Exception\AlphaTraderApiException', $val);
        }
    }

    public function test_getReserveByCompanyId()
    {
        $expected = json_encode([]);
        $request = $this->createMock('Alphatrader\ApiBundle\Api\Methods\CentralBankReservesController');
        $request->method('getReserveByCompanyId')->will($this->returnValue($expected));

        $bankaccount = new CentralBankReservesController($this->config);
        $bankaccount->setClient($this->getClient($expected));
        try {
            $val = $bankaccount->getReserveByCompanyId(1);
        } catch (\RuntimeException $val) {
            $this->assertInstanceOf('Alphatrader\ApiBundle\Api\Exception\AlphaTraderApiException', $val);
        }
    }

    public function test_increaseReserves()
    {
        $expected = json_encode([]);
        $request = $this->createMock('Alphatrader\ApiBundle\Api\Methods\CentralBankReservesController');
        $request->method('increaseReserves')->will($this->returnValue($expected));

        $company = $this->createMock('Alphatrader\ApiBundle\Model\Company');

        $bankaccount = new CentralBankReservesController($this->config);
        $bankaccount->setClient($this->getClient($expected));
        try {
            $val = $bankaccount->increaseReserves($company, 1);
        } catch (\RuntimeException $val) {
            $this->assertInstanceOf('Alphatrader\ApiBundle\Api\Exception\AlphaTraderApiException', $val);
        }
    }
}
