<?php

namespace Hikingyo\Ovh\Tests\EndPoint\Domain;

use Hikingyo\Ovh\EndPoint\Domain\NamedResolutionFieldTypeEnum;
use Hikingyo\Ovh\EndPoint\Domain\Zone;
use Hikingyo\Ovh\Exception\ResourceNotFoundException;
use Hikingyo\Ovh\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * @internal
 * @coversNothing
 */
class ZoneTest extends TestCase
{
    public function testICanGetRecordsListOfAGivenZone(): void
    {
        $expected = [
            5025087199,
            5025087235,
            5025087223,
            5025087220,
            5025087226,
            5025087229,
            5025087232,
        ];

        /** @var MockObject|Zone $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/domain/zone/hikingyo.com/record')
            ->willReturn($expected)
        ;

        $actual = $api->getRecords('hikingyo.com');
        $this->assertEquals($expected, $actual);
    }

    public function testICannotGetRecordsWithAnUnknownFieldType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The option "fieldType" with value "unknown" is invalid. Accepted values are: "A", "AAAA", "CAA", "CNAME", "DKIM", "DMARC", "DNAME", "LOC", "MX", "NAPTR", "NS", "PTR", "SPF", "SRV", "SSHFP", "TLSA", "TXT".');

        /** @var MockObject|Zone $api */
        $api = $this->getApiMock();
        $api->expects($this->never())
            ->method('get')
        ;

        $api->getRecords('hikingyo.com', 'unknown');
    }

    public function testICanGetRecordsForAGivenTypeField()
    {
        $expected = [
            5025087199,
        ];

        /** @var MockObject|Zone $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/domain/zone/hikingyo.com/record', ['fieldType' => NamedResolutionFieldTypeEnum::A()])
            ->willReturn($expected)
        ;

        $actual = $api->getRecords('hikingyo.com', NamedResolutionFieldTypeEnum::A());
        $this->assertEquals($expected, $actual);
    }

    public function testWhenIGetRecordOfAZoneICanNotAccessIGetAMessage()
    {
        /** @var MockObject|Zone $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/domain/zone/hikingyo.com/record')
            ->willThrowException(new ResourceNotFoundException('This service does not exist'))
        ;

        $this->expectException(ResourceNotFoundException::class);
        $this->expectExceptionMessage('This service does not exist');

        $api->getRecords('hikingyo.com');
    }

    public function testICanListZones(): void
    {
        $expected = [
            'domain.com',
            'domain2.com',
        ];

        /** @var MockObject|Zone $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/domain/zone')
            ->willReturn($expected)
        ;

        $actual = $api->list();

        $this->assertEquals($expected, $actual);
    }

    public function testICanGetZoneDetails(): void
    {
        $expected = [
            'name'            => 'domain.com',
            'hasDnsAnycast'   => false,
            'dnssecSupported' => true,
            'lastUpdate'      => '2019-01-01T00:00:00+00:00',
            'nameservers'     => [
                'ns1.ovh.net',
                'ns2.ovh.net',
            ],
        ];

        /** @var MockObject|Zone $api */
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/domain/zone/domain.com')
            ->willReturn($expected)
        ;

        $actual = $api->one('domain.com');

        $this->assertEquals($expected, $actual);
    }

    protected function getEndPointClass(): string
    {
        return Zone::class;
    }
}
