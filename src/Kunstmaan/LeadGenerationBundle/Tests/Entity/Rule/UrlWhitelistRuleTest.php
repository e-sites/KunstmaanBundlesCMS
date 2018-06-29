<?php

namespace Kunstmaan\LeadGenerationBundle\Tests\Entity\Rule;

use Kunstmaan\LeadGenerationBundle\Entity\Rule\UrlWhitelistRule;
use Kunstmaan\LeadGenerationBundle\Form\Rule\UrlWhiteListAdminType;
use Kunstmaan\LeadGenerationBundle\Tests\Entity\Popup\Popup;
use PHPUnit_Framework_TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2012-09-04 at 16:54:04.
 */
class UrlWhitelistRuleTest extends PHPUnit_Framework_TestCase
{
    public function testGettersAndSetters()
    {
        $rule = new UrlWhitelistRule();
        $rule->setPopup(new Popup());
        $rule->setUrls('https://nasa.gov');

        $this->assertEquals('https://nasa.gov', $rule->getUrls());
        $this->assertEquals('UrlWhitelistRule', $rule->getJsObjectClass());
        $this->assertEquals('/bundles/kunstmaanleadgeneration/js/rule/UrlWhitelistRule.js', $rule->getJsFilePath());
        $this->assertEquals(UrlWhiteListAdminType::class, $rule->getAdminType());
        $this->assertInstanceOf(Popup::class, $rule->getPopup());
        $this->assertTrue(is_array($rule->getJsProperties()));
    }
}
