<?php

class SiteController
{
	const THEME_BLUE = 'theme-blue';
	const THEME_YELLOW = 'theme-yellow';
	
	const SECT_MAIN = 'main';
	const SECT_SHOP = 'shop';
	const SECT_SINCENTER = 'shincenter';
	const SECT_RETAIL = 'retail';
	
	private $path = '';
	
	private $is_main_page = false;
	private $is_catalog_page = false;
	private $is_news_page = false;
	private $is_shin_center_page = false;
	private $is_retail_page = false;
	private $is_shop = false;

	private $unit_html = '<span>#</span>';

	private $theme;
	
	private $currency = array();
	
	/**
     * @var SiteController
     */
    public static $instance;
	
	
	function __construct()
	{
		$this->path = $GLOBALS['APPLICATION']->GetCurPage(false);

		$this->is_main_page = $this->path == '/' ? true : false ;
		$this->is_catalog_page = strpos($this->path, '/catalog/') !== false;
		$this->is_news_page = strpos($this->path, '/news/') === 0;

		$this->is_shin_center_page = strpos($this->path, '/gruzoviye-shiny/') === 0;
		$this->is_retail_page = strpos($this->path, '/retail-network/') === 0;
		$this->is_shop = strpos($this->path, '/catalog/') === 0 || strpos($this->path, '/shop/') === 0;
		
		$this->is_personal_page = strpos($this->path, '/shop/personal/') === 0 || strpos($this->path, '/personal/') === 0;

		#theme
		if($this->is_shin_center_page)
            $this->theme = self::THEME_BLUE;
		elseif($this->is_shop)
            $this->theme = self::THEME_YELLOW;

		#define
		if($this->is_shop)
			define('IS_SHOP', 'Y');
	}
	

	public function getHtmlFormatedPrice($currencu_id, $number, $currency_unit = true)
	{
		$currency = $this->loadCurrency($currencu_id);
		
		$number = str_replace(' ', '', $number);
		$number = (double)$number;
		
		if(empty($currency))
		{
			//throw new Exception('Currency not found');
			return $number;
		}
		
		#echo '<pre>'.print_r($currency, true).'</pre>';
		
		$THOUSANDS_SEP = '';
		
		switch($currency['THOUSANDS_VARIANT'])
		{
			case 'B':
				$THOUSANDS_SEP = '&nbsp;';
				break;
				
			case 'S':
				$THOUSANDS_SEP = ' ';
				break;
				
			case 'N':
				$THOUSANDS_SEP = '';
				break;
				
			case 'D':
				$THOUSANDS_SEP = '.';
				break;
				
			case 'C':
				$THOUSANDS_SEP = ',';
				break;
				
			default:
				$THOUSANDS_SEP = $currency['THOUSANDS_SEP'];
				break;
		}
		
		$format_price = number_format($number, $currency['DECIMALS'], $currency['DEC_POINT'], $THOUSANDS_SEP);
		$pos = strpos('#', $currency['FORMAT_STRING']);
		
		$text1 = '';
		$text2 = '';
		
		if($pos > 0)
			$text1 = trim(substr($currency['FORMAT_STRING'], 0, $pos));
		
		$text2 = trim(substr($currency['FORMAT_STRING'], $pos + 1));


		$currency['FORMAT_STRING'] = strlen($text1) > 0 ? str_replace('#', $text1, $this->unit_html) : '';
		$currency['FORMAT_STRING'] .= '#';

		#echo $this->unit_html;

		if(strlen($text2) > 0 && $currency_unit)
			$currency['FORMAT_STRING'] .= str_replace('#', $text2, $this->unit_html);
				
		$format_price = str_replace('#', $format_price, $currency['FORMAT_STRING']);
		
		/*
		"FORMAT_STRING" => "# руб",
		"FULL_NAME" => "Рубль",
		"DEC_POINT" => ".",
		"THOUSANDS_SEP" => "\xA0",  // неразрывный пробел
		"DECIMALS" => 2,
		"CURRENCY" => "RUB",
		"LID" => "ru"
		*/
		
		return $format_price;
		
	}
	
	protected function loadCurrency($currencu_id)
	{
		if(!empty($this->currency[$currencu_id]))
			return $this->currency[$currencu_id];
		
		if(!\Bitrix\Main\Loader::includeModule('currency'))
			return array();

		$rs = Bitrix\Currency\CurrencyLangTable::getByPrimary(array('CURRENCY' => $currencu_id, 'LID' => LANGUAGE_ID));
		if($c = $rs->fetch())
			$this->currency[$currencu_id] = $c;
		else 
			return array();
		
		//$this->currency[$currencu_id] = CCurrencyLang::GetByID($currencu_id, LANGUAGE_ID);
		
		return $this->currency[$currencu_id];
	}
	
    /**
     * @return SiteController
     */
	public static function getEntity()
    {
        if(!isset(static::$instance))
            static::$instance = new static();

        return static::$instance;
    }

	/**
	 * @return bool|string
	 */
	public function getSiteSection()
	{
		if($this->is_main_page)	
			return self::SECT_MAIN;
			
		
		if($this->is_shop)	
			return self::SECT_SHOP;
					
		if($this->is_retail_page)	
			return self::SECT_RETAIL;

		if($this->is_shin_center_page)	
			return self::SECT_SINCENTER;
			
		return false;
	}
	
    /**
     * @return bool
     */
	public function isMainPage()
	{
		return $this->is_main_page;
	}

	public function getEnumHtml()
	{
		return $this->unit_html;
	}

	public function setEnumHtml($html)
	{
		if(strpos($html,'#') === false)
			$html = '#';

		$this->unit_html = $html;
	}

    /**
     * @return bool
     */
	public function is404()
	{
		return defined('ERROR_404') && ERROR_404 == 'Y';
	}

	/**
	 * @return bool
	 */
	public function isShop(){
		return $this->is_shop;
	}
    /**
     * @return bool
     */
	public function needColumn()
	{
		return !(defined('COLUMN_OFF') || strpos($this->path, '/shop/personal/') === 0);
	}

    /**
     * @return mixed
     */
	public function getTheme()
	{
		return $this->theme;
	}

	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}
	
	public function checkPath($page)
	{
		return strpos($this->path, $page) === 0;
	}
}


/*
 * $c = $arResult['AMOUNT'] > 20 ? $arResult['AMOUNT'] - floor($arResult['AMOUNT'] / 10) * 10 : $arResult['AMOUNT'];

$text = '';

if($c == 1)
	$text =  'товар';
elseif($c > 1 && $c < 5)
	$text =  'товара';
elseif($c > 5)
	$text =  'товаров';
)
 */

