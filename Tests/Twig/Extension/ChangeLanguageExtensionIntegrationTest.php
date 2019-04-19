<?php

namespace Craue\TwigExtensionsBundle\Tests\Twig\Extension;

use Craue\TwigExtensionsBundle\Tests\TwigBasedTestCase;
use Craue\TwigExtensionsBundle\Twig\Extension\ChangeLanguageExtension;

/**
 * @group integration
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2019 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class ChangeLanguageExtensionIntegrationTest extends TwigBasedTestCase {

	/**
	 * @var ChangeLanguageExtension
	 */
	protected $ext;

	protected function setUp() {
		parent::setUp();

		$this->ext = self::$kernel->getContainer()->get('twig.extension.craue_changeLanguage');
	}

	/**
	 * @dataProvider dataGetLanguageName
	 */
	public function testGetLanguageName($showForeignLanguageNames, $showFirstUppercase, $locale, $result) {
		$this->ext->setShowForeignLanguageNames($showForeignLanguageNames);
		$this->ext->setShowFirstUppercase($showFirstUppercase);

		$this->assertSame($result,
				$this->getTwig()->render('@IntegrationTest/ChangeLanguage/languageName.html.twig', [
					'locale' => $locale,
				]));
	}

	public function dataGetLanguageName() {
		return [
			[true, false, null, ''],
			[true, false, '', ''],
			[true, false, 'de', 'Deutsch'],
			[true, false, 'de_DE', 'Deutsch (Deutschland)'],
			[true, false, 'ru', 'русский'],
			[false, false, 'de', 'German'],
			[true, true, 'ru', 'Русский'],
		];
	}

}
