<?php
/**
 * User: ljbergmann
 * Date: 05.10.16 01:56
 */

namespace Tests\Model;

use Alphatrader\ApiBundle\Model\ListingProfile;

/**
 * Class ListingProfileTest
 * @package AlphaTraderApiTests\Model
 */

class ListingProfileTest extends \PHPUnit_Framework_TestCase
{
    use RandomTrait;
    
    public function testBond()
    {
        $listingProfile = new ListingProfile();
        $this->assertNull($listingProfile->getBond());
        
        $bond   = $this->createMock('Alphatrader\ApiBundle\Model\Bond');
        $issuer = $this->createMock('Alphatrader\ApiBundle\Model\CompanyName');
        
        $bond->expects($this->any())->method('getIssuer')->willReturn($issuer);
        $listingProfile->setBond($bond);
        
        $this->assertInstanceOf('Alphatrader\ApiBundle\Model\Bond', $listingProfile->getBond());
    }

    public function testCompany()
    {
        $listingProfile = new ListingProfile();
        $this->assertNull($listingProfile->getCompany());

        $company = $this->createMock('Alphatrader\ApiBundle\Model\CompanyCompactProfile');
        $listingProfile->setCompany($company);

        $this->assertInstanceOf('Alphatrader\ApiBundle\Model\CompanyCompactProfile', $listingProfile->getCompany());
    }

    public function testCurrentSpread()
    {
        $listingProfile = new ListingProfile();
        $this->assertNull($listingProfile->getCurrentSpread());

        $spread = $this->createMock('Alphatrader\ApiBundle\Model\PriceSpread');

        $spread->expects($this->any())->method('getAskPrice')->willReturn($this->getRandomFloat());
        $spread->expects($this->any())->method('getAskSize')->willReturn(mt_rand(1, 10000));
        $spread->expects($this->any())->method('getBidPrice')->willReturn($this->getRandomFloat());
        $spread->expects($this->any())->method('getBidSize')->willReturn(mt_rand(1, 10000));
        $spread->expects($this->any())->method('getSpreadAbs')->willReturn($this->getRandomFloat(1, 200));
        $spread->expects($this->any())->method('getSpreadPercent')->willReturn($this->getRandomFloat(0, 1));

        $listingProfile->setCurrentSpread($spread);

        $this->assertInstanceOf('Alphatrader\ApiBundle\Model\PriceSpread', $listingProfile->getCurrentSpread());
    }

    public function testDesignatedSponsors()
    {
        $listingProfile = new ListingProfile();
        $this->assertNull($listingProfile->getDesignatedSponsors());

        $secSpn = $this->createMock('Alphatrader\ApiBundle\Model\SecuritySponsorship');
        $dsr    = $this->createMock('Alphatrader\ApiBundle\Model\DesignatedSponsorRating');
        $ls     = $this->createMock('Alphatrader\ApiBundle\Model\Listing');
        $cc     = $this->createMock('Alphatrader\ApiBundle\Model\CompactCompany');

        $secSpn->expects($this->any())->method('getDesignatedSponsor')->willReturn($cc);
        $secSpn->expects($this->any())->method('getListing')->willReturn($ls);
        $secSpn->expects($this->any())->method('getSponsorRating')->willReturn($dsr);

        $listingProfile->setDesignatedSponsors($secSpn);

        $this->assertInstanceOf('Alphatrader\ApiBundle\Model\SecuritySponsorship', $listingProfile->getDesignatedSponsors());
    }

    public function testId()
    {
        $listingProfile = new ListingProfile();
        $this->assertNull($listingProfile->getId());

        $id = uniqid();
        $listingProfile->setId($id);

        $this->assertEquals($id, $listingProfile->getId());
    }

    public function testLastOrderLogEntry()
    {
        $listingProfile = new ListingProfile();
        $this->assertNull($listingProfile->getLastOrderLogEntry());

        $lole = $this->createMock('Alphatrader\ApiBundle\Model\SecurityOrderLogEntry');

        $lole->expects($this->any())->method('getId')->willReturn($this->getRandomString(12));
        $lole->expects($this->any())->method('getNumberOfShares')->willReturn(mt_rand(1, 500));
        $lole->expects($this->any())->method('getPrice')->willReturn($this->getRandomFloat(1, 200));
        $lole->expects($this->any())->method('getSecurityIdentifier')->willReturn($this->getRandomString(6));
        $lole->expects($this->any())->method('getSellerSecuritiesAccount')->willReturn(uniqid());
        $lole->expects($this->any())->method('getBuyerSecuritiesAccount')->willReturn(uniqid());
        $lole->expects($this->any())->method('getVolume')->willReturn($this->getRandomFloat(200, 50000));

        $listingProfile->setLastOrderLogEntry($lole);

        $this->assertInstanceOf('Alphatrader\ApiBundle\Model\SecurityOrderLogEntry', $listingProfile->getLastOrderLogEntry());
    }

    public function testLastPrice()
    {
        $listingProfile = new ListingProfile();
        $this->assertNull($listingProfile->getLastOrderLogEntry());

        $lp = $this->createMock('Alphatrader\ApiBundle\Model\SecurityPrice');
        $lp->expects($this->any())->method('getValue')->willReturn($this->getRandomFloat(200, 10000));

        $listingProfile->setLastPrice($lp);

        $this->assertInstanceOf('Alphatrader\ApiBundle\Model\SecurityPrice', $listingProfile->getLastPrice());
    }

    public function testMarketCap()
    {
        $listingProfile = new ListingProfile();
        $this->assertNull($listingProfile->getMarketCap());

        $marketCap = $this->getRandomFloat();
        $listingProfile->setMarketCap($marketCap);

        $this->assertTrue(is_float($listingProfile->getMarketCap()));
        $this->assertEquals($marketCap, $listingProfile->getMarketCap());
    }

    public function testName()
    {
        $listingProfile = new ListingProfile();
        $this->assertNull($listingProfile->getName());

        $name = $this->getRandomString(12);
        $listingProfile->setName($name);

        $this->assertEquals($name, $listingProfile->getName());

        $bond = $this->createMock('Alphatrader\ApiBundle\Model\Bond');
        $bond->expects($this->any())->method('getName')->willReturn($name);
        $listingProfile->setBond($bond);
        $this->assertSame($name, $listingProfile->getName());
        $listingProfile->setBond(null);

        $this->assertSame($name, $listingProfile->getName());

        $company = $this->createMock('Alphatrader\ApiBundle\Model\CompanyCompactProfile');
        $company->expects($this->any())->method('getName')->willReturn($name);
        $listingProfile->setCompany($company);
        $this->assertSame($name, $listingProfile->getName());
        $listingProfile->setCompany(null);

        $this->assertSame($name, $listingProfile->getName());

        $systemBond = $this->createMock('Alphatrader\ApiBundle\Model\SystemBond');
        $systemBond->expects($this->any())->method('getName')->willReturn($name);
        $listingProfile->setSystemBond($systemBond);
        $this->assertSame($name, $listingProfile->getName());
    }

    public function testOutstandingShares()
    {
        $listingProfile = new ListingProfile();
        $this->assertNull($listingProfile->getOutstandingShares());

        $outstandingShares = mt_rand(50000, 500000);

        $listingProfile->setOutstandingShares($outstandingShares);
        $this->assertTrue(is_int($listingProfile->getOutstandingShares()));
        $this->assertEquals($outstandingShares, $listingProfile->getOutstandingShares());
    }

    public function testPrices14d()
    {
        $listingProfile = new ListingProfile();
        $this->assertNull($listingProfile->getPrices14d());

        $lole = $this->createMock('Alphatrader\ApiBundle\Model\SecurityOrderLogEntry');

        $lole->expects($this->any())->method('getId')->willReturn($this->getRandomString(12));
        $lole->expects($this->any())->method('getNumberOfShares')->willReturn(mt_rand(1, 500));
        $lole->expects($this->any())->method('getPrice')->willReturn($this->getRandomFloat(1, 200));
        $lole->expects($this->any())->method('getSecurityIdentifier')->willReturn($this->getRandomString(6));
        $lole->expects($this->any())->method('getSellerSecuritiesAccount')->willReturn(uniqid());
        $lole->expects($this->any())->method('getBuyerSecuritiesAccount')->willReturn(uniqid());
        $lole->expects($this->any())->method('getVolume')->willReturn($this->getRandomFloat(200, 50000));

        $listingProfile->setPrices14d([$lole,$lole]);

        $this->assertContainsOnlyInstancesOf('Alphatrader\ApiBundle\Model\SecurityOrderLogEntry', $listingProfile->getPrices14d());
    }

    public function testSecurityIdentifier()
    {
        $listingProfile = new ListingProfile();
        $this->assertNull($listingProfile->getSecurityIdentifier());

        $secIddent = $this->getRandomString(32);
        $listingProfile->setSecurityIdentifier($secIddent);

        $this->assertTrue(is_string($listingProfile->getSecurityIdentifier()));
        $this->assertEquals($secIddent, $listingProfile->getSecurityIdentifier());
    }

    public function testSystemBond()
    {
        $listingProfile = new ListingProfile();
        $this->assertNull($listingProfile->getBond());

        $bond   = $this->createMock('Alphatrader\ApiBundle\Model\Bond');
        $issuer = $this->createMock('Alphatrader\ApiBundle\Model\UserName');

        $bond->expects($this->any())->method('getIssuer')->willReturn($issuer);
        $listingProfile->setSystemBond($bond);

        $this->assertInstanceOf('Alphatrader\ApiBundle\Model\Bond', $listingProfile->getSystemBond());
    }

    public function testType()
    {
        $listingProfile = new ListingProfile();
        $this->assertNull($listingProfile->getType());

        $type = $this->getRandomString(12);
        $listingProfile->setType($type);

        $this->assertTrue(is_string($listingProfile->getType()));
        $this->assertEquals($type, $listingProfile->getType());
    }

    public function testIssuerName()
    {
        $listingProfile = new ListingProfile();
        $this->assertEquals('Central Bank', $listingProfile->getIssuerName());

        $name = $this->getRandomString(12);

        // Bond Set
        $bond = $this->createMock('\Alphatrader\ApiBundle\Model\Bond');
        $issuer = $this->createMock('\Alphatrader\ApiBundle\Model\CompanyName');

        $issuer->expects($this->any())->method('getName')->willReturn($name);
        $bond->expects($this->any())->method('getIssuer')->willReturn($issuer);
        $listingProfile->setBond($bond);

        $this->assertNotEquals('Central Bank', $listingProfile->getIssuerName());
        $this->assertEquals($name, $listingProfile->getIssuerName());
        $listingProfile->setBond(null);

        //Company Set
        $company = $this->createMock('\Alphatrader\ApiBundle\Model\CompanyCompactProfile');
        $company->expects($this->any())->method('getName')->willReturn($name);
        $listingProfile->setCompany($company);

        $this->assertNotEquals('Central Bank', $listingProfile->getIssuerName());
        $this->assertEquals($name, $listingProfile->getIssuerName());

        $listingProfile->setCompany(null);


        $listingProfile->setSecurityIdentifier("SBSF8797");
        $this->assertEquals('Central Bank', $listingProfile->getIssuerName());
    }

    public function testGetIssuerSecurityIdentifier()
    {
        $listingProfile = new ListingProfile();
        $this->assertNull($listingProfile->getIssuerSecurityIdentifier());
        $secIdent = $this->getRandomString(32);

        $listingProfile->setSecurityIdentifier($secIdent);
        $company = $this->createMock('\Alphatrader\ApiBundle\Model\CompanyCompactProfile');
        $listingProfile->setCompany($company);
        $this->assertEquals($secIdent, $listingProfile->getIssuerSecurityIdentifier());
        $listingProfile->setCompany(null);

        $sBond = $this->createMock('\Alphatrader\ApiBundle\Model\SystemBond');
        $listingProfile->setSystemBond($sBond);
        $this->assertEquals($secIdent, $listingProfile->getIssuerSecurityIdentifier());
        $listingProfile->setSystemBond(null);

        $this->assertNull($listingProfile->getIssuerSecurityIdentifier());

        $bond   = $this->createMock('\Alphatrader\ApiBundle\Model\Bond');
        $cname  = $this->createMock('\Alphatrader\ApiBundle\Model\CompanyName');
        $list   = $this->createMock('\Alphatrader\ApiBundle\Model\Listing');

        $list->expects($this->any())->method('getSecurityIdentifier')->willReturn($secIdent);
        $cname->expects($this->any())->method('getListing')->willReturn($list);
        $bond->expects($this->any())->method('getIssuer')->willReturn($cname);
        $listingProfile->setBond($bond);

        $this->assertEquals($secIdent, $listingProfile->getIssuerSecurityIdentifier());
    }

    public function testGetBondOrSystemBond()
    {
        $listingProfile = new ListingProfile();
        $this->assertNull($listingProfile->getBondOrSystemBond());

        $bond = $this->createMock('\Alphatrader\ApiBundle\Model\Bond');
        $listingProfile->setBond($bond);

        $this->assertInstanceOf('\Alphatrader\ApiBundle\Model\Bond', $listingProfile->getBondOrSystemBond());
        $listingProfile->setBond(null);

        $this->assertNull($listingProfile->getBondOrSystemBond());

        $sysbond = $this->createMock('\Alphatrader\ApiBundle\Model\SystemBond');
        $listingProfile->setSystemBond($sysbond);

        $this->assertInstanceOf('\Alphatrader\ApiBundle\Model\SystemBond', $listingProfile->getBondOrSystemBond());
    }
    
    public function testPriceGain()
    {
        $listingProfile = new ListingProfile();
        $this->assertEquals(0, $listingProfile->getPriceGain());

        $price = $this->createMock('\Alphatrader\ApiBundle\Model\SecurityPrice');
        $price->expects($this->any())->method('getValue')->willReturn($this->getRandomFloat(1, 100));

        $listingProfile->setPrices14d([$price]);
        $this->assertEquals(0, $listingProfile->getPriceGain());

        $prices = [$price,$price];
        $listingProfile->setPrices14d($prices);

        $currentPrice = $prices[0]->getValue();
        $lastPrice = $prices[1]->getValue();
        $res = (($currentPrice / $lastPrice) - 1) * 100;

        $this->assertEquals($res, $listingProfile->getPriceGain());
    }

    public function testPreviousPriceDate()
    {
        $listingProfile = new ListingProfile();
        $this->assertNull($listingProfile->getPreviousPriceDate());

        $date = new \DateTime('now');

        $price = $this->createMock('\Alphatrader\ApiBundle\Model\SecurityPrice');
        $price->expects($this->any())->method('getDate')->willReturn($date);

        $listingProfile->setPrices14d([$price]);
        $this->assertNull($listingProfile->getPreviousPriceDate());

        $prices = [$price,$price];
        $listingProfile->setPrices14d($prices);

        $this->assertEquals($date, $listingProfile->getPreviousPriceDate());
    }

    public function testGetPrices14dDates()
    {
        $listingProfile = new ListingProfile();
        $this->assertEquals('', $listingProfile->getPrices14dDates());

        $d1 = new \DateTime('now');
        $d2 = new \DateTime('-1 Day');

        $price1 = $this->createMock('\Alphatrader\ApiBundle\Model\SecurityPrice');
        $price1->expects($this->any())->method('getDate')->willReturn($d1);

        $price2 = $this->createMock('\Alphatrader\ApiBundle\Model\SecurityPrice');
        $price2->expects($this->any())->method('getDate')->willReturn($d2);

        $dates = $this->createMock('\Doctrine\Common\Collections\ArrayCollection');
        $dates->expects($this->any())->method('toArray')->willReturn([$price1,$price2]);

        $listingProfile->setPrices14d($dates);

        $result = '"'.date("d.m.", $d1->getTimestamp()).'","'.date("d.m.", $d2->getTimestamp()).'"';

        $this->assertEquals($result, $listingProfile->getPrices14dDates());
    }

    public function testGetPrices14dValues()
    {
        $listingProfile = new ListingProfile();
        $this->assertEquals('', $listingProfile->getPrices14dValues());

        $p1 = $this->getRandomFloat();
        $p2 = $this->getRandomFloat();

        $price1 = $this->createMock('\Alphatrader\ApiBundle\Model\SecurityPrice');
        $price1->expects($this->any())->method('getValue')->willReturn($p1);

        $price2 = $this->createMock('\Alphatrader\ApiBundle\Model\SecurityPrice');
        $price2->expects($this->any())->method('getValue')->willReturn($p2);

        $prices = $this->createMock('\Doctrine\Common\Collections\ArrayCollection');
        $prices->expects($this->any())->method('toArray')->willReturn([$price1,$price2]);

        $listingProfile->setPrices14d($prices);

        $result = $p1.",".$p2;

        $this->assertEquals($result, $listingProfile->getPrices14dValues());
    }
}
