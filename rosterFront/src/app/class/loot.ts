import {Item} from "./item";
import {Slot} from "./slot";

export class Loot {
  loot_id: number;
  chest: string;
  item_url: string;
  instance_url: string;
  item_id: string;
  player_url: string;
  instance_id: number;
  item_name: string;
  player_name: string;
  ord: number;
  player_id: number;
  playerjob_id: number;
  value: number;
  week: number;
  item_isUpgrade: string;
  item_upgraded: Item;
  instance_value: number;
  item: Item;
  slot : Slot;
  job_url: string;
}
