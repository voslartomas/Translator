<?php

namespace Webcook\Translator;

/**
 * Interface for translators.
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
interface ITranslator {
	
	/**
	 * Returns list of possible languages.
	 * @return Array<LanguageResult> list of possible languages
	 */
	public function getLanguages();
	
	/**
	 * Translate text.
	 * @param type $text
	 * @param type $languageTo
	 * @param type $languageFrom
	 * @return TranslateResult
	 */
	public function translate($text, $languageFrom, $languageTo);
}
