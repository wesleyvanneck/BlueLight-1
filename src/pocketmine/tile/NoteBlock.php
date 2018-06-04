<?php

/*
 *   ____  _            _      _       _     _
 *  |  _ \| |          | |    (_)     | |   | |
 *  | |_) | |_   _  ___| |     _  __ _| |__ | |_
 *  |  _ <| | | | |/ _ \ |    | |/ _` | '_ \| __|
 *  | |_) | | |_| |  __/ |____| | (_| | | | | |_
 *  |____/|_|\__,_|\___|______|_|\__, |_| |_|\__|
 *                                __/ |
 *                               |___/
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author BlueLightDutch Team
 * 
*/

declare(strict_types=1);

namespace pocketmine\tile;

use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\Player;

class NoteBlock extends Spawnable{
	
	public const TAG_NOTE = "note";
	public const TAG_POWERED = "powered";
	/** @var int */
	protected $note = 0;
	protected $powered = 0;
	protected function readSaveData(CompoundTag $nbt) : void{
		if($nbt->hasTag(self::TAG_NOTE, IntTag::class)){
			$this->note = $nbt->getInt(self::TAG_NOTE);
		}
		if($nbt->hasTag(self::TAG_POWERED, ByteTag::class)){
			$this->powered = $nbt->getByte(self::TAG_POWERED);
		}
	}
	public function setNote(int $note) : void{
		$this->note = $note;
	}
	public function getNote() : int{
		return $this->note;
	}
	
	public function setPowered(bool $value) : void{
		$this->powered = (int) $value;
	}
	public function isPowered() : bool{
		return (bool) $this->powered;
	}
	public function getDefaultName() : string{
		return "NoteBlock";
	}
	protected function writeSaveData(CompoundTag $nbt) : void{
		parent::saveNBT();
		
		$nbt->setInt(self::TAG_NOTE, $this->note);
		$nbt->setByte(self::TAG_POWERED, $this->powered);
	}
	public function addAdditionalSpawnData(CompoundTag $nbt) : void{
		if($nbt->hasTag(self::TAG_NOTE, IntTag::class)){
			$nbt->setTag($this->namedtag->getTag(self::TAG_NOTE));
		}
		if($nbt->hasTag(self::TAG_POWERED, ByteTag::class)){
			$nbt->setTag($this->namedtag->getTag(self::TAG_POWERED));
		}
	}
}
