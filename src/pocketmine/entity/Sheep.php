<?php

/*
 *
 *  _____   _____   __   _   _   _____  __    __  _____
 * /  ___| | ____| |  \ | | | | /  ___/ \ \  / / /  ___/
 * | |     | |__   |   \| | | | | |___   \ \/ /  | |___
 * | |  _  |  __|  | |\   | | | \___  \   \  /   \___  \
 * | |_| | | |___  | | \  | | |  ___| |   / /     ___| |
 * \_____/ |_____| |_|  \_| |_| /_____/  /_/     /_____/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author iTX Technologies
 * @link https://itxtech.org
 *
 */

namespace pocketmine\entity;

use pocketmine\block\Wool;
use pocketmine\item\Item as ItemItem;
use pocketmine\level\format\FullChunk;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;

class Sheep extends Animal implements Colorable{
	const NETWORK_ID = self::SHEEP;

	const DATA_COLOR_INFO = 16;

	public $width = 0.625;
	public $length = 1.4375;
	public $height = 1.8;
	
	public function getName() : string{
		return "Sheep";
	}

	public function __construct(FullChunk $chunk, CompoundTag $nbt){
		if(!isset($nbt->Color)){
			$nbt->Color = new ByteTag("Color", self::getRandomColor());
		}
		parent::__construct($chunk, $nbt);

		$this->setDataProperty(self::DATA_COLOR_INFO, self::DATA_TYPE_BYTE, $this->getColor());
	}

	public static function getRandomColor() : int{
		$rand = mt_rand(0, 100000); //Allow 3 decimal places
		if($rand <= 5000){
			return Wool::BLACK; //5%
		}elseif($rand <= 10000){
			return Wool::GRAY; //5%
		}elseif($rand <= 15000){
			return Wool::LIGHT_GRAY; //5%
		}elseif($rand <= 18000){
			return Wool::BROWN; //3%
		}elseif($rand <= 99836){
			return Wool::WHITE; //81.836%
		}else{
			return Wool::PINK; //0.164%
		}
	}

	public function getColor() : int{
		return (int) $this->namedtag["Color"];
	}

	public function setColor(int $color){
		$this->namedtag->Color = new ByteTag("Color", $color);
	}

	public function getDrops(){
		$drops = [
			ItemItem::get(ItemItem::WOOL, $this->getColor(), 1)
		];
		return $drops;
	}
}