<?php
/** 
 * @author rpsimao
 * 
 */
class RPS_User_Service_Styles
{
    public static function normal($fontSize) {
		
		$style = new Zend_Pdf_Style();
		$style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
		$style->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), $fontSize);
		return $style;
	}
	
	public static function values($fontSize) {
	
	    $style = new Zend_Pdf_Style();
	    $style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
	    $style->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_COURIER), $fontSize);
	    return $style;
	}
	
	public static function normalItalic($fontSize) {
	
	    $style = new Zend_Pdf_Style();
	    $style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
	    $style->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_ITALIC), $fontSize);
	    return $style;
	}
	
	
	public static function bold($fontSize) {
		
		$style = new Zend_Pdf_Style();
		$style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
		$style->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), $fontSize);
		return $style;
	}
	
	public static function boldItalic($fontSize) {
	
	    $style = new Zend_Pdf_Style();
	    $style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
	    $style->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD_ITALIC), $fontSize);
	    return $style;
	}
	
	public static function condensed($fontSize) {
		
		$style = new Zend_Pdf_Style();
		$style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
		$style->setFont(Zend_Pdf_Font::fontWithPath('/usr/share/fonts/otf/Narrow.ttf'), $fontSize);
		return $style;
	}
	
	public static function condensedBold($fontSize) {
		
		$style = new Zend_Pdf_Style();
		$style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
		$style->setFont(Zend_Pdf_Font::fontWithPath('/usr/share/fonts/otf/Nar.ttf'), $fontSize);
		return $style;
	}
	
	public static function normalWithCustomColor($fontSize, $red, $green, $blue) {
		
		$style = new Zend_Pdf_Style();
		$style->setFillColor(new Zend_Pdf_Color_Rgb($red, $green, $blue));
		$style->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), $fontSize);
		return $style;
	}
	
	
	public static function boldWithCustomColor($fontSize, $red, $green, $blue) {
		
		$style = new Zend_Pdf_Style();
		$style->setFillColor(new Zend_Pdf_Color_Rgb($red, $green, $blue));
		$style->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), $fontSize);
		return $style;
	}
	
	public static function condensedWithCustomColor($fontSize, $red, $green, $blue) {
		
		$style = new Zend_Pdf_Style();
		$style->setFillColor(new Zend_Pdf_Color_Rgb($red, $green, $blue));
		$style->setFont(Zend_Pdf_Font::fontWithPath('/usr/share/fonts/otf/Narrow.ttf'), $fontSize);
		return $style;
	}
	
	public static function condensedBoldWithCustomColor($fontSize, $red, $green, $blue) {
		
		$style = new Zend_Pdf_Style();
		$style->setFillColor(new Zend_Pdf_Color_Rgb($red, $green, $blue));
		$style->setFont(Zend_Pdf_Font::fontWithPath('/usr/share/fonts/otf/Nar.ttf'), $fontSize);
		return $style;
	}
	
	public static function fillWhite() {
		
		$style = new Zend_Pdf_Style();
		$style->setFillColor(new Zend_Pdf_Color_Rgb(1,0,0));
		return $style;
	}
	
public static function checkMark($fontSize) {
		
		$style = new Zend_Pdf_Style();
		$style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
		$style->setFont(Zend_Pdf_Font::fontWithPath('/usr/share/fonts/otf/ZapfDingbats.ttf'), $fontSize);
		return $style;
	}
	
public static function checkBox($fontSize) {
		
		$style = new Zend_Pdf_Style();
		$style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
		$style->setFont(Zend_Pdf_Font::fontWithPath('/usr/share/fonts/otf/wingding.ttf'), $fontSize);
		return $style;
	}
	
	
	public static function convertMoney($number) {
		
		setlocale(LC_MONETARY, 'pt_PT');
		$millhar =  number_format($number, 0, ',', '.');
		return $millhar;
	}
}
?>