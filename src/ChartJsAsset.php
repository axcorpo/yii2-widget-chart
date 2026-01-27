<?php

namespace tws\widgets\chart;

use yii\web\AssetBundle;

class ChartJsAsset extends AssetBundle
{
	/**
	 * @inheritdoc
	 */
	public $js = [
		'js/Chart.bundle.min.js',
	];

	/**
	 * @inheritdoc
	 */
	public $depends = [
		'yii\web\JqueryAsset',
	];

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		$this->sourcePath = __DIR__ . '/assets/chartjs';
	}
}
