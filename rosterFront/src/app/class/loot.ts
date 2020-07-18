import {Raid} from "./raid";
import {PlayerJob} from "./player-job";
import {Week} from "./week";
import {Item} from "./item";

export class Loot {
  instance: Raid;
  playerJob: PlayerJob;
  week: Week;
  item: Item;
  coffer: number;
}
