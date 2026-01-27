<?php

namespace tws\widgets\chart;

use yii\web\AssetBundle;

class FlotChartsAsset extends AssetBundle
{
	/**
	 * @inheritdoc
	 */
	public $js = [
		'js/jquery.flot.min.js',
		'js/jquery.flot.axislabels.js',
		'js/jquery.flot.canvas.min.js',
		'js/jquery.flot.categories.min.js',
		'js/jquery.flot.crosshair.min.js',
		'js/jquery.flot.errorbars.min.js',
		'js/jquery.flot.fillbetween.min.js',
		'js/jquery.flot.image.min.js',
		'js/jquery.flot.navigate.min.js',
		'js/jquery.flot.orderBars.js',
		'js/jquery.flot.pie.min.js',
		'js/jquery.flot.resize.min.js',
		'js/jquery.flot.selection.min.js',
		'js/jquery.flot.stack.min.js',
		'js/jquery.flot.symbol.min.js',
		'js/jquery.flot.threshold.min.js',
		'js/jquery.flot.time.min.js',
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

		$this->sourcePath = __DIR__ . '/assets/flotcharts';
	}
}
