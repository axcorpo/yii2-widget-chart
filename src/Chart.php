<?php

namespace tws\widgets\chart;

use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

/**
 * Class Chart
 *
 * @author Tree Web Solutions <treewebsolutions.com@gmail.com>
 */
class Chart extends Widget
{
	const TYPE_FLOT = 'flot';
	const TYPE_CHARTJS = 'chartjs';

	/**
	 * @var array The client script to use.
	 */
	public $type = self::TYPE_FLOT;

	/**
	 * @var array The widget options.
	 */
	public $options = [];

	/**
	 * @var array The client (JS) options.
	 */
	public $clientOptions = [];

	/**
	 * @var array The client (JS) events.
	 */
	public $clientEvents = [];

	/**
	 * @var string The client (JS) selector.
	 */
	private $_clientSelector;

	/**
	 * @var string The global widget (JS) hash variable.
	 */
	private $_hashVar;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		$this->setupProperties();
		$this->registerAssets();
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		if ($this->type === self::TYPE_FLOT) {
			return Html::tag('div', null, $this->options);
		} elseif ($this->type === self::TYPE_CHARTJS) {
			return Html::tag('canvas', null, $this->options);
		}

		return '';
	}

	/**
	 * Gets the client selector.
	 *
	 * @return string
	 */
	public function getClientSelector()
	{
		if (!$this->_clientSelector) {
			$this->_clientSelector = '#' . $this->options['id'] ?: $this->getId();
		}
		return $this->_clientSelector;
	}

	/**
	 * Gets the hash variable.
	 *
	 * @return string
	 */
	public function getHashVar()
	{
		if (!$this->_hashVar) {
			$this->_hashVar = 'chart_' . hash('crc32', $this->buildClientOptions());
		}
		return $this->_hashVar;
	}

	/**
	 * Sets the widget properties.
	 */
	protected function setupProperties()
	{
		$this->options = array_merge([
			'id' => $this->getId(),
			'class' => 'chart-container',
			'data' => [
				'chart-options' => $this->getHashVar(),
			],
		], $this->options);

		Html::addCssClass($this->options, 'chart-container');
	}

	/**
	 * Builds Client Options.
	 *
	 * @return string
	 */
	protected function buildClientOptions()
	{
		// Ensure default values
		$defaultClientOptions = [
			// Defaults can be added here
		];
		// Merge client options
		$clientOptions = array_merge($defaultClientOptions, $this->clientOptions);
		// Return options as JSON
		return Json::encode($clientOptions);
	}

	/**
	 * Registers widget assets.
	 */
	protected function registerAssets()
	{
		$view = $this->getView();
		$js = '';

		$view->registerJs("var {$this->getHashVar()} = {$this->buildClientOptions()};", View::POS_HEAD);

		if ($this->type === self::TYPE_FLOT) {
			FlotChartsAsset::register($view);
			$js = "jQuery.plot(jQuery('{$this->getClientSelector()}'), {$this->getHashVar()}.data, {$this->getHashVar()}.options)";
		} elseif ($this->type === self::TYPE_CHARTJS) {
			ChartJsAsset::register($view);
			$js = "new Chart(jQuery('{$this->getClientSelector()}').get(0).getContext('2d'), {$this->getHashVar()})";
		}

		if (!empty($this->clientEvents)) {
			foreach ($this->clientEvents as $clientEvent => $eventHandler) {
				if (!($eventHandler instanceof JsExpression)) {
					$eventHandler = new JsExpression($eventHandler);
				}
				$js .= ".on('{$clientEvent}', {$eventHandler})";
			}
		}

		$view->registerJs("{$js};");
	}
}
