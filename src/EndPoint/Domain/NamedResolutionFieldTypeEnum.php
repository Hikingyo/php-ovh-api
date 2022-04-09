<?php

namespace Hikingyo\Ovh\EndPoint\Domain;

use MyCLabs\Enum\Enum;

/**
 * @method static NamedResolutionFieldTypeEnum A()
 * @method static NamedResolutionFieldTypeEnum AAAA()
 * @method static NamedResolutionFieldTypeEnum CAA()
 * @method static NamedResolutionFieldTypeEnum CNAME()
 * @method static NamedResolutionFieldTypeEnum MX()
 * @method static NamedResolutionFieldTypeEnum NS()
 * @method static NamedResolutionFieldTypeEnum PTR()
 * @method static NamedResolutionFieldTypeEnum SPF()
 * @method static NamedResolutionFieldTypeEnum SRV()
 * @method static NamedResolutionFieldTypeEnum TXT()
 * @method static NamedResolutionFieldTypeEnum DKIM()
 * @method static NamedResolutionFieldTypeEnum DMARC()
 * @method static NamedResolutionFieldTypeEnum DNAME()
 * @method static NamedResolutionFieldTypeEnum NAPTR()
 * @method static NamedResolutionFieldTypeEnum SSHFP()
 * @method static NamedResolutionFieldTypeEnum TLSA()
 * @method static NamedResolutionFieldTypeEnum LOC()
 */
class NamedResolutionFieldTypeEnum extends Enum
{
    private const A = 'A';
    private const AAAA = 'AAAA';
    private const CAA = 'CAA';
    private const CNAME = 'CNAME';
    private const DKIM = 'DKIM';
    private const DMARC = 'DMARC';
    private const DNAME = 'DNAME';
    private const LOC = 'LOC';
    private const MX = 'MX';
    private const NAPTR = 'NAPTR';
    private const NS = 'NS';
    private const PTR = 'PTR';
    private const SPF = 'SPF';
    private const SRV = 'SRV';
    private const SSHFP = 'SSHFP';
    private const TLSA = 'TLSA';
    private const TXT = 'TXT';
}
