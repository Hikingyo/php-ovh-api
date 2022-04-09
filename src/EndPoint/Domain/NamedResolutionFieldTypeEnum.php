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
    /**
     * @var string
     */
    private const A = 'A';

    /**
     * @var string
     */
    private const AAAA = 'AAAA';

    /**
     * @var string
     */
    private const CAA = 'CAA';

    /**
     * @var string
     */
    private const CNAME = 'CNAME';

    /**
     * @var string
     */
    private const DKIM = 'DKIM';

    /**
     * @var string
     */
    private const DMARC = 'DMARC';

    /**
     * @var string
     */
    private const DNAME = 'DNAME';

    /**
     * @var string
     */
    private const LOC = 'LOC';

    /**
     * @var string
     */
    private const MX = 'MX';

    /**
     * @var string
     */
    private const NAPTR = 'NAPTR';

    /**
     * @var string
     */
    private const NS = 'NS';

    /**
     * @var string
     */
    private const PTR = 'PTR';

    /**
     * @var string
     */
    private const SPF = 'SPF';

    /**
     * @var string
     */
    private const SRV = 'SRV';

    /**
     * @var string
     */
    private const SSHFP = 'SSHFP';

    /**
     * @var string
     */
    private const TLSA = 'TLSA';

    /**
     * @var string
     */
    private const TXT = 'TXT';
}
