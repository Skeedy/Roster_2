import {Job} from "./job";
import {Item} from "./item";
import {Wishitem} from "./wishitem";
import {Currentstuff} from "./currentstuff";

export class PlayerJob {
  id: number;
  isMain: boolean;
  isSub: boolean;
  job: Job;
  ord: number;
  wishitem: Wishitem;
  slot: number;
  currentstuff: Currentstuff;
}
